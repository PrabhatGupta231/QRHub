@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Blog Articles</h2>
        <div class="flex items-center space-x-2 self-end sm:self-auto">
            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728A9 9 0 115.636 5.636m12.728 12.728A9 9 0 015.636 5.636" /></svg>
                <span>Write Article</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Panel -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col sm:flex-row justify-between gap-4">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex max-w-md w-full">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search articles by title or summary..." class="flex-grow px-3 py-2 text-xs border rounded-l-lg dark:bg-slate-900 border-slate-300 dark:border-slate-700 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500" />
            <button type="submit" class="px-4 py-2 bg-indigo-650 text-white text-xs font-semibold rounded-r-lg hover:bg-indigo-700">Search</button>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="p-4">Featured Image</th>
                        <th class="p-4">Post Title</th>
                        <th class="p-4">Category</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Views</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-650 dark:text-slate-300">
                    @forelse($posts as $post)
                        <tr>
                            <!-- Image -->
                            <td class="p-4">
                                <div class="w-16 h-12 bg-slate-100 dark:bg-slate-900 rounded-lg overflow-hidden flex items-center justify-center border border-slate-200 dark:border-slate-800">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Thumbnail" class="w-full h-full object-cover" />
                                    @else
                                        <span class="text-[9px] text-slate-400 text-center font-bold px-1">No Image</span>
                                    @endif
                                </div>
                            </td>
                            <!-- Title -->
                            <td class="p-4">
                                <span class="font-bold text-slate-900 dark:text-white text-sm line-clamp-1">{{ $post->title }}</span>
                                <p class="text-[10px] text-slate-400 mt-0.5">Slug: {{ $post->slug }}</p>
                            </td>
                            <!-- Category -->
                            <td class="p-4 font-semibold text-indigo-600 dark:text-indigo-400">{{ $post->category->name }}</td>
                            <!-- Status -->
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $post->is_published ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/20 dark:text-emerald-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-950/20 dark:text-amber-400' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <!-- Views -->
                            <td class="p-4 text-center font-semibold">{{ $post->visits_count }}</td>
                            <!-- Actions -->
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="inline-block px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 rounded font-semibold text-[10px]">Edit</a>
                                
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-600 dark:text-red-400 rounded font-semibold text-[10px]">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">No blog posts found. Write your first article today!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
