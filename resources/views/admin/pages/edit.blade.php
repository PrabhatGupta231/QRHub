@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6 max-w-4xl">
    
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white font-sans">Edit Custom Page: {{ $page->title }}</h2>
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:underline">&larr; Back to Pages</a>
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

    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label for="title" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Page Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <div>
            <label for="content" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">HTML Content</label>
            <textarea name="content" id="content" rows="12" required class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('content', $page->content) }}</textarea>
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
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" placeholder="Custom page title shown in tab search index" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>
                <div>
                    <label for="meta_description" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" placeholder="Custom snippet shown below page title in search results" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
                <div>
                    <label for="meta_keywords" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}" placeholder="e.g. privacy, disclaimer, terms" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 dark:border-slate-700/50 pt-6 flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $page->is_active) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" />
                <label for="is_active" class="ml-2 block text-xs font-bold text-slate-900 dark:text-white select-none">Page is active / Accessible</label>
            </div>
            
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow">
                Save & Update
            </button>
        </div>

    </form>

</div>
@endsection
