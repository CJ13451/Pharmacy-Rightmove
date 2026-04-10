<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use RuntimeException;
use ZipArchive;

/**
 * Extracts SCORM packages uploaded through the admin and resolves their
 * launch URL + SCORM version from imsmanifest.xml.
 *
 * Packages are stored on the `public` disk under `scorm-packages/{moduleId}/`
 * so the launcher can load them via the regular `storage/` URL.
 */
class ScormService
{
    private const EXTRACTION_ROOT = 'scorm-packages';

    /**
     * Extract a SCORM zip that lives on the `public` disk and return the
     * extraction metadata.
     *
     * @return array{package_path: string, entry_path: string, version: string}
     */
    public function extract(string $zipRelativePath, string $moduleId): array
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($zipRelativePath)) {
            throw new RuntimeException("SCORM zip not found on public disk: {$zipRelativePath}");
        }

        $zipAbsolutePath = $disk->path($zipRelativePath);
        $packagePath = self::EXTRACTION_ROOT.'/'.$moduleId;
        $extractionAbsolutePath = $disk->path($packagePath);

        // Wipe any previous extraction for this module so re-uploads do not
        // leave stale files behind.
        if (is_dir($extractionAbsolutePath)) {
            $this->deleteDirectory($extractionAbsolutePath);
        }

        if (! mkdir($extractionAbsolutePath, 0755, true) && ! is_dir($extractionAbsolutePath)) {
            throw new RuntimeException("Unable to create SCORM extraction directory: {$extractionAbsolutePath}");
        }

        $this->unzipSafely($zipAbsolutePath, $extractionAbsolutePath);

        $manifestPath = $this->locateManifest($extractionAbsolutePath);

        if ($manifestPath === null) {
            throw new RuntimeException('imsmanifest.xml was not found inside the uploaded SCORM package.');
        }

        [$entryPath, $version] = $this->parseManifest($manifestPath, $extractionAbsolutePath);

        return [
            'package_path' => $packagePath,
            'entry_path' => $entryPath,
            'version' => $version,
        ];
    }

    /**
     * Remove a previously extracted package from disk.
     */
    public function purge(?string $packagePath): void
    {
        if (! $packagePath) {
            return;
        }

        $absolute = Storage::disk('public')->path($packagePath);

        if (is_dir($absolute)) {
            $this->deleteDirectory($absolute);
        }
    }

    /**
     * Extract a zip archive while guarding against zip-slip path traversal.
     */
    private function unzipSafely(string $zipPath, string $destination): void
    {
        $zip = new ZipArchive();
        $opened = $zip->open($zipPath);

        if ($opened !== true) {
            throw new RuntimeException("Unable to open SCORM zip (error code {$opened}).");
        }

        try {
            $realDestination = realpath($destination);

            if ($realDestination === false) {
                throw new RuntimeException("Extraction destination does not exist: {$destination}");
            }

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entryName = $zip->getNameIndex($i);

                if ($entryName === false || $entryName === '') {
                    continue;
                }

                // Normalise and reject traversal attempts.
                $normalised = str_replace('\\', '/', $entryName);

                if (str_contains($normalised, '../') || str_starts_with($normalised, '/')) {
                    throw new RuntimeException("Unsafe path inside SCORM zip: {$entryName}");
                }

                $targetPath = $realDestination.DIRECTORY_SEPARATOR.$normalised;

                if (str_ends_with($normalised, '/')) {
                    if (! is_dir($targetPath) && ! mkdir($targetPath, 0755, true) && ! is_dir($targetPath)) {
                        throw new RuntimeException("Unable to create directory: {$targetPath}");
                    }
                    continue;
                }

                $parentDir = dirname($targetPath);

                if (! is_dir($parentDir) && ! mkdir($parentDir, 0755, true) && ! is_dir($parentDir)) {
                    throw new RuntimeException("Unable to create directory: {$parentDir}");
                }

                $stream = $zip->getStream($entryName);

                if ($stream === false) {
                    throw new RuntimeException("Unable to read entry from SCORM zip: {$entryName}");
                }

                $out = fopen($targetPath, 'wb');

                if ($out === false) {
                    fclose($stream);
                    throw new RuntimeException("Unable to write file: {$targetPath}");
                }

                stream_copy_to_stream($stream, $out);
                fclose($stream);
                fclose($out);
            }
        } finally {
            $zip->close();
        }
    }

    /**
     * Find imsmanifest.xml. SCORM allows the manifest at the package root,
     * but some authoring tools nest the content inside a single subdirectory,
     * so we walk one level down as a fallback.
     */
    private function locateManifest(string $extractionPath): ?string
    {
        $rootManifest = $extractionPath.DIRECTORY_SEPARATOR.'imsmanifest.xml';

        if (is_file($rootManifest)) {
            return $rootManifest;
        }

        foreach (glob($extractionPath.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) ?: [] as $child) {
            $candidate = $child.DIRECTORY_SEPARATOR.'imsmanifest.xml';

            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    /**
     * Parse the manifest and return [relative entry path, scorm version].
     *
     * @return array{0: string, 1: string}
     */
    private function parseManifest(string $manifestPath, string $extractionRoot): array
    {
        $previous = libxml_use_internal_errors(true);

        try {
            $xml = simplexml_load_file($manifestPath);
        } finally {
            libxml_use_internal_errors($previous);
        }

        if ($xml === false) {
            throw new RuntimeException('Unable to parse imsmanifest.xml.');
        }

        $version = $this->detectVersion($xml);

        // The resource referenced by the first organization item is the
        // launch target in practice.
        $resourceIdentifierRef = null;

        $itemRef = $xml->xpath('//*[local-name()="organizations"]/*[local-name()="organization"]/*[local-name()="item"][1]/@identifierref');
        if (! empty($itemRef)) {
            $resourceIdentifierRef = (string) $itemRef[0];
        }

        $resources = $xml->xpath('//*[local-name()="resources"]/*[local-name()="resource"]') ?: [];
        $entryHref = null;

        if ($resourceIdentifierRef !== null) {
            foreach ($resources as $resource) {
                $attrs = $resource->attributes();
                if ((string) ($attrs['identifier'] ?? '') === $resourceIdentifierRef) {
                    $entryHref = (string) ($attrs['href'] ?? '');
                    break;
                }
            }
        }

        if (! $entryHref && isset($resources[0])) {
            $attrs = $resources[0]->attributes();
            $entryHref = (string) ($attrs['href'] ?? '');
        }

        if (! $entryHref) {
            throw new RuntimeException('Unable to determine SCORM launch file from imsmanifest.xml.');
        }

        // Strip any query string the manifest may have included.
        $entryHrefClean = explode('?', $entryHref, 2)[0];

        // The entry path is relative to wherever the manifest lives. If the
        // manifest was nested one directory below the extraction root, the
        // launch file lives in the same subdirectory.
        $manifestDir = rtrim(str_replace('\\', '/', dirname($manifestPath)), '/');
        $rootDir = rtrim(str_replace('\\', '/', $extractionRoot), '/');
        $relativeManifestDir = ltrim(substr($manifestDir, strlen($rootDir)), '/');

        $entryRelative = $relativeManifestDir === ''
            ? $entryHrefClean
            : $relativeManifestDir.'/'.$entryHrefClean;

        // Collapse any "./" segments but refuse "../" (shouldn't appear, but
        // belt and braces).
        $entryRelative = str_replace('\\', '/', $entryRelative);
        if (str_contains($entryRelative, '../')) {
            throw new RuntimeException('SCORM manifest points outside the package.');
        }

        return [$entryRelative, $version];
    }

    private function detectVersion(\SimpleXMLElement $xml): string
    {
        $namespaces = $xml->getNamespaces(true);

        foreach ($namespaces as $uri) {
            if (str_contains($uri, 'adlcp_v1p3') || str_contains($uri, 'CP_v1p3') || str_contains($uri, '2004')) {
                return '2004';
            }
        }

        $schemaVersionNodes = $xml->xpath('//*[local-name()="schemaversion"]') ?: [];

        foreach ($schemaVersionNodes as $node) {
            $value = trim((string) $node);

            if ($value !== '' && str_contains($value, '2004')) {
                return '2004';
            }

            if ($value !== '' && str_starts_with($value, '1.2')) {
                return '1.2';
            }
        }

        return '1.2';
    }

    private function deleteDirectory(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        $items = scandir($path) ?: [];

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $target = $path.DIRECTORY_SEPARATOR.$item;

            if (is_dir($target) && ! is_link($target)) {
                $this->deleteDirectory($target);
            } else {
                @unlink($target);
            }
        }

        @rmdir($path);
    }
}
