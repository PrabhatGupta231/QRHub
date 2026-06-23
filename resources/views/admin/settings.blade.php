@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6 max-w-4xl">
    
    <div>
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Ads & General Configurations</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Configure global SEO keywords, tracking codes, and paste Google AdSense code blocks.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Tab navigation (General vs Ads) -->
        <div x-data="{ tab: 'general' }" class="space-y-6">
            
            <div class="flex space-x-4 border-b border-slate-200 dark:border-slate-800 pb-2">
                <button 
                    @click="tab = 'general'" 
                    type="button" 
                    :class="tab === 'general' ? 'border-indigo-650 text-indigo-600 dark:text-indigo-400 border-b-2 font-bold' : 'text-slate-500 hover:text-slate-850'" 
                    class="pb-2 text-sm font-semibold focus:outline-none"
                >
                    General SEO Settings
                </button>
                <button 
                    @click="tab = 'ads'" 
                    type="button" 
                    :class="tab === 'ads' ? 'border-indigo-650 text-indigo-600 dark:text-indigo-400 border-b-2 font-bold' : 'text-slate-500 hover:text-slate-850'" 
                    class="pb-2 text-sm font-semibold focus:outline-none"
                >
                    Google AdSense Scripts
                </button>
            </div>

            <!-- General Tab -->
            <div x-show="tab === 'general'" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Site Name</label>
                        <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? '' }}" required class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>
                    <div>
                        <label for="google_analytics_id" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Google Analytics ID (GT-XXXXX / UA-XXXXX)</label>
                        <input type="text" name="google_analytics_id" id="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="GT-XXXXXXX" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </div>
                </div>

                <div>
                    <label for="site_title" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Global Homepage Meta Title</label>
                    <input type="text" name="site_title" id="site_title" value="{{ $settings['site_title'] ?? '' }}" required class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

                <div>
                    <label for="site_description" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Global Homepage Meta Description</label>
                    <textarea name="site_description" id="site_description" rows="3" required class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>

                <div>
                    <label for="site_keywords" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Global SEO Keywords (Comma Separated)</label>
                    <input type="text" name="site_keywords" id="site_keywords" value="{{ $settings['site_keywords'] ?? '' }}" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

            </div>

            <!-- Ads Tab -->
            <div x-show="tab === 'ads'" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8 space-y-6" x-cloak>
                <div class="p-4 bg-indigo-50 dark:bg-indigo-950/20 text-indigo-750 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800/30 text-xs rounded-xl flex items-start space-x-2">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Paste raw HTML script elements provided by Google AdSense. Placements will display on the frontend automatically when filled. Keep empty to disable slots.</span>
                </div>

                <div>
                    <label for="ad_header" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Header Banner Ad (Shown at very top)</label>
                    <textarea name="ad_header" id="ad_header" rows="3" placeholder="<ins class='adsbygoogle' ...></ins>" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-750 bg-slate-50 dark:bg-slate-900 font-mono text-indigo-650 dark:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $settings['ad_header'] ?? '' }}</textarea>
                </div>

                <div>
                    <label for="ad_content" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Between Content Ad (Shown on blog show / QR catalog pages)</label>
                    <textarea name="ad_content" id="ad_content" rows="3" placeholder="<ins class='adsbygoogle' ...></ins>" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-750 bg-slate-50 dark:bg-slate-900 font-mono text-indigo-650 dark:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $settings['ad_content'] ?? '' }}</textarea>
                </div>

                <div>
                    <label for="ad_sidebar" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Sidebar Ad (Shown alongside preview / blog sidebar)</label>
                    <textarea name="ad_sidebar" id="ad_sidebar" rows="3" placeholder="<ins class='adsbygoogle' ...></ins>" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-750 bg-slate-50 dark:bg-slate-900 font-mono text-indigo-650 dark:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $settings['ad_sidebar'] ?? '' }}</textarea>
                </div>

                <div>
                    <label for="ad_footer" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Footer Banner Ad (Shown above main footer)</label>
                    <textarea name="ad_footer" id="ad_footer" rows="3" placeholder="<ins class='adsbygoogle' ...></ins>" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-750 bg-slate-50 dark:bg-slate-900 font-mono text-indigo-650 dark:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $settings['ad_footer'] ?? '' }}</textarea>
                </div>

                <div>
                    <label for="ad_sticky" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Mobile Sticky Anchor Ad (Sticky at bottom on mobile devices)</label>
                    <textarea name="ad_sticky" id="ad_sticky" rows="3" placeholder="<ins class='adsbygoogle' ...></ins>" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-750 bg-slate-50 dark:bg-slate-900 font-mono text-indigo-650 dark:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $settings['ad_sticky'] ?? '' }}</textarea>
                </div>

            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow">
                Save Configurations
            </button>
        </div>

    </form>

</div>
@endsection
