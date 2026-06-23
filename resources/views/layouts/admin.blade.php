<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - QRHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col md:flex-row transition-colors duration-300">

    <!-- Sidebar -->
    <aside class="w-full md:w-64 bg-slate-900 dark:bg-slate-950 text-white flex-shrink-0 flex flex-col border-r border-slate-800">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                QRHub Admin
            </a>
            <!-- Dark Mode Toggle inside Admin -->
            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-1 text-slate-400 hover:text-white rounded-lg">
                <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728A9 9 0 115.636 5.636m12.728 12.728A9 9 0 015.636 5.636" /></svg>
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            </button>
        </div>

        <!-- Sidebar Links -->
        <nav class="flex-grow p-4 space-y-1 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white hover:bg-indigo-650' : 'text-slate-350' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zm10 0a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" /></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.posts.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-indigo-600 text-white hover:bg-indigo-650' : 'text-slate-350' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6M7 12h6" /></svg>
                <span>Blog Posts</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white hover:bg-indigo-650' : 'text-slate-350' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.tags.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.tags.*') ? 'bg-indigo-600 text-white hover:bg-indigo-650' : 'text-slate-350' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <span>Tags</span>
            </a>

            <a href="{{ route('admin.pages.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.pages.*') ? 'bg-indigo-600 text-white hover:bg-indigo-650' : 'text-slate-350' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                <span>Pages</span>
            </a>

            <a href="{{ route('admin.messages.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.messages.*') ? 'bg-indigo-600 text-white hover:bg-indigo-650' : 'text-slate-350' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5" /></svg>
                <span>Inbox Messages</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white hover:bg-indigo-650' : 'text-slate-350' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                <span>Ads & Settings</span>
            </a>

            <div class="border-t border-slate-800 my-4 pt-4">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    <span>View Website</span>
                </a>

                <button onclick="document.getElementById('logout-form').submit()" class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-lg text-red-400 hover:bg-red-950/20 hover:text-red-300 transition-colors text-left focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    <span>Logout</span>
                </button>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Workspace Container -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top bar -->
        <header class="h-16 bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-6">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Admin Dashboard</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-semibold text-slate-600 dark:text-slate-350">
                    {{ Auth::user()->name }}
                </span>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow p-6 sm:p-8 overflow-y-auto">
            
            <!-- Success Alert Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-sm border border-emerald-200 dark:border-emerald-800/30 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('admin_content')
        </main>
    </div>

</body>
</html>
