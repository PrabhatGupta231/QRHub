@extends('layouts.app')

@section('content')
<!-- JSON-LD Article Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ $post->title }}",
  "image": [
    "{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('logo.png') }}"
  ],
  "datePublished": "{{ $post->published_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": [{
      "@type": "Organization",
      "name": "{{ \App\Models\Setting::getValue('site_name', 'QRHub') }}",
      "url": "{{ url('/') }}"
    }]
}
</script>

<div class="py-12 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-6 text-xs text-slate-400 dark:text-slate-500 font-medium" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
                <li class="flex items-center space-x-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <a href="{{ route('blog') }}" class="hover:text-indigo-600">Blog</a>
                </li>
                <li class="flex items-center space-x-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-500 dark:text-slate-400 truncate max-w-xs">{{ $post->title }}</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Article Content (8 cols) -->
            <div class="lg:col-span-8 bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                
                <!-- Hero Image or Gradient -->
                <div class="h-64 sm:h-96 w-full bg-gradient-to-r from-indigo-600 to-purple-600 relative overflow-hidden flex items-center justify-center">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" />
                    @else
                        <div class="text-white text-center p-8">
                            <span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-3 py-1 rounded-full">{{ $post->category->name }}</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold mt-4">{{ $post->title }}</h2>
                        </div>
                    @endif
                </div>

                <div class="p-6 sm:p-10">
                    
                    <!-- Article Meta Row -->
                    <div class="flex flex-wrap items-center justify-between border-b border-slate-100 dark:border-slate-700/50 pb-6 mb-8 text-xs font-bold text-slate-500 dark:text-slate-400">
                        <div class="flex items-center space-x-4">
                            <span>Category: <a href="{{ route('blog.category', $post->category->slug) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $post->category->name }}</a></span>
                            <span>&bull;</span>
                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                            <span>&bull;</span>
                            <span>Views: {{ $post->visits_count }}</span>
                        </div>
                        
                        <!-- Social Share Icons -->
                        <div class="flex items-center space-x-2 mt-4 sm:mt-0">
                            <!-- Twitter -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="p-2 bg-slate-100 dark:bg-slate-900 rounded-lg text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" aria-label="Share on Twitter">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="p-2 bg-slate-100 dark:bg-slate-900 rounded-lg text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" aria-label="Share on Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                            </a>
                            <!-- WhatsApp -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" class="p-2 bg-slate-100 dark:bg-slate-900 rounded-lg text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition-colors" aria-label="Share on WhatsApp">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.504-5.724-1.466L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.114-2.903-6.99C16.557 1.876 14.079.843 11.442.843c-5.442 0-9.868 4.424-9.873 9.873-.001 1.642.43 3.242 1.249 4.646L1.87 20.895l5.056-1.328z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Summary box -->
                    <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border-l-4 border-indigo-600 text-sm italic text-slate-600 dark:text-slate-350 mb-8 leading-relaxed">
                        {{ $post->summary }}
                    </div>

                    <!-- Ad Slot: Between Title & Content -->
                    <x-ad-placement slot="ad_content" />

                    <!-- Main Article Body -->
                    <div class="prose prose-indigo dark:prose-invert max-w-none text-slate-600 dark:text-slate-350 leading-relaxed space-y-6">
                        {!! $post->content !!}
                    </div>

                    <!-- Tags Row -->
                    @if($post->tags->count() > 0)
                        <div class="border-t border-slate-100 dark:border-slate-700/50 mt-10 pt-6">
                            <span class="text-xs font-bold text-slate-400 mr-2 uppercase">Tags:</span>
                            <div class="inline-flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}" class="px-2.5 py-1 bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 text-[10px] rounded font-bold uppercase tracking-wider">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>

            <!-- Right: Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Related Posts Widget -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white uppercase tracking-wider mb-4">Related Posts</h3>
                    <div class="space-y-4">
                        @foreach($relatedPosts as $rp)
                            <div class="flex items-start space-x-3">
                                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-900 rounded-lg flex-shrink-0 overflow-hidden flex items-center justify-center">
                                    @if($rp->featured_image)
                                        <img src="{{ asset('storage/' . $rp->featured_image) }}" alt="{{ $rp->title }}" class="w-full h-full object-cover" />
                                    @else
                                        <span class="text-[9px] font-bold text-slate-400 p-2 text-center leading-tight">{{ Str::limit($rp->title, 20) }}</span>
                                    @endif
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xs font-bold text-slate-900 dark:text-white hover:text-indigo-600 line-clamp-2">
                                        <a href="{{ route('blog.show', $rp->slug) }}">{{ $rp->title }}</a>
                                    </h4>
                                    <span class="text-[10px] text-slate-400 mt-1 block">{{ $rp->published_at->format('M d, Y') }}</span>
                                </div>
                            </div>
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
