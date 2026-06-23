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
                    <span class="text-slate-500 dark:text-slate-400">Contact Us</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-2">Get in Touch</h1>
            <p class="text-lg text-slate-500 dark:text-slate-400">
                Have questions, feature requests, custom logo feedback, or business inquiries? Drop us a line below.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Contact Form (8 cols) -->
            <div class="lg:col-span-8 bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8">
                
                <!-- Success Alert -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border border-emerald-250 dark:border-emerald-800/30 text-sm font-semibold flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Validation Errors Alert -->
                @if($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border border-red-250 dark:border-red-800/30 text-sm font-semibold">
                        <div class="flex items-center space-x-2 mb-2 font-bold">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <span>Please fix the following issues:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Your Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="John Doe" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="john@example.com" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Subject</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required placeholder="Feature Request / Custom Partnership" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Message Body</label>
                        <textarea name="message" id="message" rows="5" required placeholder="Write details here..." class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center space-x-2 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        <span>Send Message</span>
                    </button>
                </form>

            </div>

            <!-- Right: Info & Ads (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-md">
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white mb-4">Direct Details</h3>
                    <div class="space-y-4 text-sm text-slate-600 dark:text-slate-300">
                        <div class="flex items-start space-x-3">
                            <span class="p-2 bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 rounded-lg flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </span>
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white">Email support</h4>
                                <p class="text-xs mt-0.5">support@qrhub.com</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="p-2 bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 rounded-lg flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </span>
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white">Response Time</h4>
                                <p class="text-xs mt-0.5">We usually reply within 24-48 business hours.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ad placement in sidebar -->
                <x-ad-placement slot="ad_sidebar" />

            </div>

        </div>

    </div>
</div>
@endsection
