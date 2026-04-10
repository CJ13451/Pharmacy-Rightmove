<?php

namespace App\Observers;

use App\Models\CourseModule;
use App\Services\ScormService;
use Illuminate\Support\Facades\Log;
use Throwable;

class CourseModuleObserver
{
    public function __construct(private readonly ScormService $scorm)
    {
    }

    /**
     * When an admin uploads (or replaces) a SCORM package, extract it and
     * resolve the launch URL from imsmanifest.xml.
     */
    public function saved(CourseModule $module): void
    {
        if ($module->content_type !== 'scorm') {
            return;
        }

        if (! $module->wasChanged('scorm_package_url')) {
            return;
        }

        $zipPath = $module->scorm_package_url;

        if (! $zipPath) {
            // Package cleared - tidy up the previous extraction.
            $this->scorm->purge($module->getOriginal('scorm_package_path'));

            $module->updateQuietly([
                'scorm_package_path' => null,
                'scorm_entry_path' => null,
            ]);

            return;
        }

        try {
            $result = $this->scorm->extract($zipPath, (string) $module->id);

            $update = [
                'scorm_package_path' => $result['package_path'],
                'scorm_entry_path' => $result['entry_path'],
            ];

            // Only overwrite the version if the admin left it blank - they
            // may have intentionally chosen one.
            if (empty($module->scorm_version)) {
                $update['scorm_version'] = $result['version'];
            }

            $module->updateQuietly($update);
        } catch (Throwable $e) {
            Log::error('Failed to extract SCORM package', [
                'module_id' => $module->id,
                'zip_path' => $zipPath,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Clean up extracted SCORM files when a module is deleted.
     */
    public function deleted(CourseModule $module): void
    {
        $this->scorm->purge($module->scorm_package_path);
    }
}
