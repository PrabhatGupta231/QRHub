<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteTitle ?? \App\Models\Setting::getValue('site_title', 'QRHub') }}</title>
    <meta name="description" content="{{ $siteDescription ?? \App\Models\Setting::getValue('site_description', '') }}">
    <meta name="keywords" content="{{ $siteKeywords ?? \App\Models\Setting::getValue('site_keywords', '') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $siteTitle ?? \App\Models\Setting::getValue('site_title', 'QRHub') }}">
    <meta property="og:description" content="{{ $siteDescription ?? \App\Models\Setting::getValue('site_description', '') }}">
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $siteTitle ?? \App\Models\Setting::getValue('site_title', 'QRHub') }}">
    <meta property="twitter:description" content="{{ $siteDescription ?? \App\Models\Setting::getValue('site_description', '') }}">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS / JS Bundles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Analytics -->
    @php
        $gaId = \App\Models\Setting::getValue('google_analytics_id');
    @endphp
    @if(!empty($gaId))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        </script>
    @endif

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col transition-colors duration-300">

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            {{ \App\Models\Setting::getValue('site_name', 'QRHub') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Generator</a>
                    <a href="{{ route('types') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">QR Types</a>
                    <a href="{{ route('blog') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Blog</a>
                    <a href="{{ route('contact') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-colors">Contact</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Light / Dark Mode Toggle -->
                    <button 
                        @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                        type="button" 
                        class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none transition-colors"
                        aria-label="Toggle dark mode"
                    >
                        <!-- Sun Icon (visible in dark mode) -->
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728A9 9 0 115.636 5.636m12.728 12.728A9 9 0 015.636 5.636" />
                        </svg>
                        <!-- Moon Icon (visible in light mode) -->
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden" x-data="{ mobileMenuOpen: false }">
                        <button 
                            @click="mobileMenuOpen = !mobileMenuOpen" 
                            type="button" 
                            class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:text-indigo-600 focus:outline-none"
                            aria-label="Open mobile menu"
                        >
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <!-- Mobile Menu -->
                        <div 
                            x-show="mobileMenuOpen" 
                            @click.away="mobileMenuOpen = false"
                            class="absolute top-16 right-4 left-4 p-4 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 flex flex-col space-y-4"
                            x-transition
                        >
                            <a href="{{ route('home') }}" class="font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600">Generator</a>
                            <a href="{{ route('types') }}" class="font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600">QR Types</a>
                            <a href="{{ route('blog') }}" class="font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600">Blog</a>
                            <a href="{{ route('contact') }}" class="font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Header Ad Placement -->
    <x-ad-placement slot="ad_header" />

    <!-- Main Content Container -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Content-Footer Ad Placement -->
    <x-ad-placement slot="ad_footer" />

    <!-- Mobile Sticky Ad Placement -->
    @php
        $stickyAd = \App\Models\Setting::getValue('ad_sticky');
    @endphp
    @if(!empty(trim($stickyAd)))
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 md:hidden flex justify-center py-2 shadow-lg">
            {!! $stickyAd !!}
        </div>
    @endif

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1: Brand -->
                <div class="space-y-4">
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        {{ \App\Models\Setting::getValue('site_name', 'QRHub') }}
                    </span>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        High-quality, free, custom QR Code Generator with colors, transparent backgrounds, and logos.
                    </p>
                </div>
                <!-- Col 2: Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">Product</h3>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">QR Generator</a></li>
                        <li><a href="{{ route('types') }}" class="hover:text-indigo-600 transition-colors">QR Code Types</a></li>
                    </ul>
                </div>
                <!-- Col 3: Resources -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">Resources</h3>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('blog') }}" class="hover:text-indigo-600 transition-colors">Guides & Blog</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-indigo-600 transition-colors">Help & Support</a></li>
                    </ul>
                </div>
                <!-- Col 4: Legal Pages -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">Legal</h3>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        @php
                            $legalPages = \App\Models\Page::where('is_active', true)->get();
                        @endphp
                        @foreach($legalPages as $lp)
                            <li><a href="{{ route('page', $lp->slug) }}" class="hover:text-indigo-600 transition-colors">{{ $lp->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-slate-200 dark:border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500 dark:text-slate-400">
                <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('site_name', 'QRHub') }}. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ route('admin.login') }}" class="hover:underline">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
