@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-6 text-xs text-slate-400 dark:text-slate-500 font-medium" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
                <li class="flex items-center space-x-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-500 dark:text-slate-400">Blog</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-2">QR Code Guides & Articles</h1>
            <p class="text-slate-500 dark:text-slate-400 max-w-2xl">
                Explore expert advice, branding tips, scanner device compatibility guides, and creative applications of QR code technology.
            </p>
        </div>

        <!-- Ad Slot: Header placement -->
        <x-ad-placement slot="ad_header" />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Articles Grid (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                
                @if($posts->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($posts as $post)
                            <article class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-md border border-slate-150 dark:border-slate-700/50 flex flex-col hover:shadow-lg transition-shadow duration-300">
                                <div class="h-48 bg-slate-100 dark:bg-slate-900 flex items-center justify-center relative overflow-hidden">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" />
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white p-6 text-center font-bold text-sm">
                                            {{ $post->title }}
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 mb-2">
                                        <span>{{ $post->category->name }}</span>
                                        <span class="text-slate-400 font-medium">{{ $post->published_at->format('M d, Y') }}</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white line-clamp-2 mb-3">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-indigo-600 transition-colors">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p class="text-slate-500 dark:text-slate-400 text-xs line-clamp-3 mb-4 flex-grow">
                                        {{ $post->summary }}
                                    </p>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-600 dark:text-indigo-400 font-bold text-xs hover:underline flex items-center">
                                        <span>Read Article</span>
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-12 text-center border border-slate-200 dark:border-slate-700">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">No Articles Found</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">We couldn't find any articles matching your request. Try broadening your query.</p>
                    </div>
                @endif

            </div>

            <!-- Right: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Search Widget -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider mb-4">Search Blog</h3>
                    <form action="{{ route('blog') }}" method="GET" class="flex space-x-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search guides..." class="flex-grow px-3 py-2 rounded-lg text-xs border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white" />
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold">Go</button>
                    </form>
                </div>

                <!-- Categories Widget -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider mb-4">Categories</h3>
                    <ul class="space-y-2 text-xs font-semibold text-slate-600 dark:text-slate-400">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blog.category', $category->slug) }}" class="flex justify-between items-center hover:text-indigo-600 py-1 border-b border-slate-100 dark:border-slate-700/50">
                                    <span>{{ $category->name }}</span>
                                    <span class="bg-slate-100 dark:bg-slate-900 px-2 py-0.5 rounded text-[10px]">{{ $category->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tags Widget -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider mb-4">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-900 hover:bg-indigo-50 dark:hover:bg-indigo-950 text-slate-600 dark:text-slate-400 hover:text-indigo-600 text-[10px] rounded font-bold uppercase tracking-wider transition-colors">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Ad placement in sidebar -->
                <x-ad-placement slot="ad_sidebar" />

            </div>

        </div>

    </div>
</div>
@endsection
