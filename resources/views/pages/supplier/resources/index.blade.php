<x-layouts.app title="Manage Resources">
<div class="max-w-7xl mx-auto px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Resources</h1>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Upload Resource</h2>
        <form action="{{ route('supplier.resources.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="guide">Guide</option>
                        <option value="brochure">Brochure</option>
                        <option value="case_study">Case Study</option>
                        <option value="video">Video</option>
                        <option value="training">Training</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('description') }}</textarea>
            </div>
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File (max 20MB)</label>
                <input type="file" name="file" id="file" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                @error('file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">Upload</button>
        </form>
    </div>

    @if($resources->count())
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Downloads</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($resources as $resource)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $resource->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $resource->type)) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $resource->download_count }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('supplier.resources.destroy', $resource->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this resource?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $resources->links() }}</div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-500">
            No resources uploaded yet. Use the form above to upload your first resource.
        </div>
    @endif
</div>
</x-layouts.app>
