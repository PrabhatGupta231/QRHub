@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-xs text-slate-400 dark:text-slate-500 font-medium" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
                <li class="flex items-center space-x-2">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    <span class="text-slate-500 dark:text-slate-400">{{ $page->title }}</span>
                </li>
            </ol>
        </nav>

        <!-- Main Card layout -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 p-6 sm:p-10">
            
            <!-- Title -->
            <div class="border-b border-slate-100 dark:border-slate-700/50 pb-6 mb-6">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">{{ $page->title }}</h1>
                <p class="text-xs text-slate-400 mt-2">Last updated: {{ $page->updated_at->format('M d, Y') }}</p>
            </div>

            <!-- Ad Slot: Between Title and content -->
            <x-ad-placement slot="ad_content" />

            <!-- Rich Content Output -->
            <div class="prose prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-350 leading-relaxed space-y-4">
                {!! $page->content !!}
            </div>

        </div>

    </div>
</div>
@endsection
