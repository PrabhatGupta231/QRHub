@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6 max-w-4xl">
    
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white font-sans">Edit Blog Article</h2>
        <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-slate-500 hover:underline">&larr; Back to Articles</a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="p-4 bg-red-50 dark:bg-red-950/20 text-red-655 dark:text-red-400 rounded-xl text-xs border border-red-200 dark:border-red-800/30">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Title -->
            <div class="sm:col-span-2">
                <label for="title" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Article Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required placeholder="e.g. 5 Ways QR Codes Can Grow Your Business" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <!-- Category -->
            <div>
                <label for="category_id" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Category</label>
                <select name="category_id" id="category_id" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Summary -->
        <div>
            <label for="summary" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Summary / Excerpt (Max 500 characters)</label>
            <textarea name="summary" id="summary" rows="2" required placeholder="A short, catchy overview of the article shown in lists and search engines." class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('summary', $post->summary) }}</textarea>
        </div>

        <!-- Content -->
        <div>
            <label for="content" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Full HTML Content</label>
            <textarea name="content" id="content" rows="12" required placeholder="<h2>Heading</h2><p>Article body content written in HTML...</p>" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t border-slate-100 dark:border-slate-700/50 pt-6">
            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Featured Header Image</label>
                <div class="flex items-center space-x-4 mb-2">
                    <div class="w-16 h-12 bg-slate-100 dark:bg-slate-900 rounded-lg overflow-hidden flex items-center justify-center border border-slate-200 dark:border-slate-800 flex-shrink-0">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Thumbnail" class="w-full h-full object-cover" />
                        @else
                            <span class="text-[9px] text-slate-400 text-center font-bold px-1">None</span>
                        @endif
                    </div>
                    <span class="text-[10px] text-slate-500">Keep blank if you don't wish to change the header image.</span>
                </div>
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none" />
                <p class="text-[10px] text-slate-400 mt-1">PNG, JPG, or JPEG format. Maximum 2MB. Uploaded images are scaled down automatically to width 800px.</p>
            </div>
            <!-- Tags Selection -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-2">Associate Tags</label>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    @php
                        $activeTags = $post->tags->pluck('id')->toArray();
                    @endphp
                    @foreach($tags as $tag)
                        <div class="flex items-center">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}" {{ in_array($tag->id, old('tags', $activeTags)) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" />
                            <label for="tag-{{ $tag->id }}" class="ml-2 text-slate-650 dark:text-slate-350 select-none">{{ $tag->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- SEO Parameters Accordion (Collapsible) -->
        <div x-data="{ seoOpen: false }" class="border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
            <button @click="seoOpen = !seoOpen" type="button" class="w-full px-5 py-3 flex items-center justify-between bg-slate-50 dark:bg-slate-900 font-semibold text-xs text-left focus:outline-none">
                <span>SEO Metadata Configuration (Optional)</span>
                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': seoOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div x-show="seoOpen" class="p-5 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 space-y-4" x-transition>
                <div>
                    <label for="meta_title" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $post->meta_title) }}" placeholder="Custom page title shown in tab search index" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" placeholder="Custom snippet shown below page title in search results" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('meta_description', $post->meta_description) }}</textarea>
                </div>
                <div>
                    <label for="meta_keywords" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}" placeholder="e.g. qr codes, brand styling, guide" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 dark:border-slate-700/50 pt-6 flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $post->is_published) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" />
                <label for="is_published" class="ml-2 block text-xs font-bold text-slate-900 dark:text-white select-none">Published / Live</label>
            </div>
            
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow">
                Save & Update
            </button>
        </div>

    </form>

</div>
@endsection
