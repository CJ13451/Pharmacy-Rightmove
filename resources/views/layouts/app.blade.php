{{-- This layout redirects to the component layout for backwards compatibility --}}
<x-layouts.app :title="$title ?? null">
    {{ $slot }}
</x-layouts.app>
