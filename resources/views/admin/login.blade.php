<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - QRHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl p-8 space-y-6">
        
        <div class="text-center">
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent inline-block">
                QRHub Admin
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Access the administration control panel</p>
        </div>

        @if($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-950/20 text-red-650 dark:text-red-400 rounded-xl text-xs border border-red-200 dark:border-red-800/30">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="admin@qrhub.com" class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-300 dark:border-slate-750 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Password</label>
                <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full px-4 py-2.5 text-sm rounded-lg border border-slate-300 dark:border-slate-750 bg-white dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" />
                <label for="remember" class="ml-2 block text-xs text-slate-600 dark:text-slate-400">Remember session credentials</label>
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow transition-colors">
                Sign In
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="{{ route('home') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">&larr; Return to Homepage</a>
        </div>

    </div>

</body>
</html>
