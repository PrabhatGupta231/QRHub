@extends('layouts.admin')

@section('admin_content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="{ editingTag: null }">
    
    <!-- Left Column: Tag Listing (8 cols) -->
    <div class="lg:col-span-8 space-y-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Blog Tags</h2>
        
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="p-4">Tag Name</th>
                            <th class="p-4">Slug</th>
                            <th class="p-4 text-center">Associated Posts</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-650 dark:text-slate-300">
                        @forelse($tags as $tag)
                            <tr>
                                <td class="p-4 font-bold text-slate-900 dark:text-white text-sm">{{ $tag->name }}</td>
                                <td class="p-4">{{ $tag->slug }}</td>
                                <td class="p-4 text-center font-semibold text-indigo-650 dark:text-indigo-400">{{ $tag->posts_count }}</td>
                                <td class="p-4 text-right space-x-2">
                                    <button 
                                        @click="editingTag = @json($tag)" 
                                        type="button" 
                                        class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 rounded font-semibold text-[10px]"
                                    >
                                        Edit
                                    </button>
                                    
                                    <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this tag?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-650 dark:text-red-400 rounded font-semibold text-[10px]">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400">No tags found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Add/Edit Form (4 cols) -->
    <div class="lg:col-span-4 space-y-6">
        
        <!-- Create Form (Visible when not editing) -->
        <div x-show="!editingTag" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-4">
            <h3 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider">Add Tag</h3>
            <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Tag Name</label>
                    <input type="text" name="name" required placeholder="e.g. WiFi Setup" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>
                <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow">
                    Create Tag
                </button>
            </form>
        </div>

        <!-- Edit Form (Visible when editing) -->
        <div x-show="editingTag" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 space-y-4" x-cloak>
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider">Edit Tag</h3>
                <button @click="editingTag = null" type="button" class="text-xs text-slate-400 hover:underline">Cancel</button>
            </div>
            <form :action="'/admin/tags/' + editingTag?.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Tag Name</label>
                    <input type="text" name="name" :value="editingTag?.name" required class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>
                <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow">
                    Save Changes
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
