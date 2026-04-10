<x-layouts.app title="Manage Resources">
    <div class="max-w-7xl mx-auto px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('supplier.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Manage Resources</h1>
            </div>
            <button 
                type="button"
                onclick="document.getElementById('upload-modal').classList.remove('hidden')"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Upload Resource
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($supplier->tier->value === 'free')
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-amber-800">Upgrade to add resources</h3>
                        <p class="text-sm text-amber-700 mt-1">Premium and Featured plans allow you to upload downloadable resources for potential customers.</p>
                        <a href="{{ route('supplier.subscription') }}" class="inline-block mt-3 text-sm font-medium text-amber-800 hover:text-amber-900">
                            Upgrade Now →
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($resources->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                @foreach($resources as $resource)
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                @php
                                    $icon = match(strtolower($resource->file_type)) {
                                        'pdf' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
                                        'doc', 'docx' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                                        'xls', 'xlsx' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>',
                                        default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'
                                    };
                                @endphp
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $icon !!}
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $resource->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ strtoupper($resource->file_type) }} · {{ $resource->formatted_file_size }} · {{ number_format($resource->downloads_count) }} downloads
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a 
                                href="{{ $resource->file_url }}" 
                                target="_blank"
                                class="p-2 text-gray-400 hover:text-gray-600 transition"
                                title="Download"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('supplier.resources.destroy', $resource) }}" onsubmit="return confirm('Delete this resource?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-xl p-12 text-center">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No resources yet</h3>
                <p class="text-gray-500 mb-6">Upload brochures, spec sheets, and other resources for potential customers.</p>
                @if($supplier->tier->value !== 'free')
                    <button 
                        type="button"
                        onclick="document.getElementById('upload-modal').classList.remove('hidden')"
                        class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition"
                    >
                        Upload First Resource
                    </button>
                @endif
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    <div id="upload-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('upload-modal').classList.add('hidden')"></div>
            
            <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Upload Resource</h3>
                    <button 
                        type="button"
                        onclick="document.getElementById('upload-modal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('supplier.resources.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input 
                            type="text" 
                            name="title" 
                            required
                            class="w-full rounded-lg border-gray-300"
                            placeholder="e.g. Product Brochure 2024"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea 
                            name="description" 
                            rows="2"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Brief description of this resource..."
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">File *</label>
                        <input 
                            type="file" 
                            name="file" 
                            required
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                        >
                        <p class="text-xs text-gray-500 mt-1">PDF, Word, Excel, PowerPoint, or ZIP. Max 25MB.</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button 
                            type="button"
                            onclick="document.getElementById('upload-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition"
                        >
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
