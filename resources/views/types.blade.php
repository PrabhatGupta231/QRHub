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
                    <span class="text-slate-500 dark:text-slate-400">QR Code Types</span>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-4">Supported QR Code Types</h1>
            <p class="text-lg text-slate-500 dark:text-slate-400">
                Learn about the structural standards, payloads, and ideal use cases for the 10 QR code formats supported by QRHub.
            </p>
        </div>

        <!-- Ad Slot: Between Content -->
        <x-ad-placement slot="ad_content" />

        <!-- Types List -->
        <div class="space-y-12">
            
            <!-- URL -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 sm:p-8 shadow-md border border-slate-100 dark:border-slate-700">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center space-x-3 mb-4">
                    <span class="p-2 bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    </span>
                    <span>1. Destination URL QR Code</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-300 mb-4 leading-relaxed text-sm">
                    URL QR codes redirect users to target website links. Upon scanning with a smartphone, the user's browser opens the link automatically. Prepending `https://` is recommended for security.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Data Format</h4>
                        <code class="text-indigo-600 dark:text-indigo-400">https://example.com/promo</code>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Common Uses</h4>
                        <p class="text-slate-500 dark:text-slate-400">Restaurant menus, digital flyers, app landing pages, portfolio sharing.</p>
                    </div>
                </div>
            </div>

            <!-- WiFi -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 sm:p-8 shadow-md border border-slate-100 dark:border-slate-700">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center space-x-3 mb-4">
                    <span class="p-2 bg-purple-50 dark:bg-purple-950/30 text-purple-600 dark:text-purple-400 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a11 11 0 0115.808 0M1.757 7.071a17 17 0 0120.485 0" /></svg>
                    </span>
                    <span>2. WiFi Network QR Code</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-300 mb-4 leading-relaxed text-sm">
                    Connect to a WiFi network without typing passwords. Scanners parse network encryption (WPA/WEP) and credentials, offering one-click login dialogs.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Data Format</h4>
                        <code class="text-indigo-600 dark:text-indigo-400">WIFI:S:MyNet;T:WPA;P:SecretPass;H:false;;</code>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Common Uses</h4>
                        <p class="text-slate-500 dark:text-slate-400">Office welcome tables, coffee shops, hotels, home guest rooms.</p>
                    </div>
                </div>
            </div>

            <!-- vCard -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 sm:p-8 shadow-md border border-slate-100 dark:border-slate-700">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center space-x-3 mb-4">
                    <span class="p-2 bg-pink-50 dark:bg-pink-950/30 text-pink-600 dark:text-pink-400 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M21 12h-6m6 4h-6" /></svg>
                    </span>
                    <span>3. vCard Business Card QR Code</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-300 mb-4 leading-relaxed text-sm">
                    Imports contact details directly into the phonebook of the scanning device. It supports full names, organizational roles, cell phones, emails, street addresses, and custom websites.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Data Format</h4>
                        <code class="text-indigo-600 dark:text-indigo-400">BEGIN:VCARD\nVERSION:3.0\nN:Doe;John...\nEND:VCARD</code>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Common Uses</h4>
                        <p class="text-slate-500 dark:text-slate-400">Paper business cards, email signatures, event badges.</p>
                    </div>
                </div>
            </div>

            <!-- WhatsApp -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 sm:p-8 shadow-md border border-slate-100 dark:border-slate-700">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center space-x-3 mb-4">
                    <span class="p-2 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-lg">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.96 9.96 0 001.333 4.982L2 22l5.176-1.359a9.943 9.943 0 004.832 1.259h.004c5.507 0 9.99-4.479 9.992-9.986.002-2.67-1.037-5.178-2.929-7.07A9.925 9.925 0 0012.012 2zm5.836 14.199c-.32.9-1.845 1.76-2.53 1.83-.54.05-1.09.28-3.46-.66-3.05-1.2-5.01-4.31-5.16-4.51-.15-.2-1.25-1.66-1.25-3.17 0-1.51.79-2.25 1.07-2.55.28-.3.62-.37.82-.37h.59c.19 0 .44-.07.69.54.25.61.85 2.07.93 2.22.08.15.13.33.03.53-.1.2-.21.33-.37.52-.16.19-.34.42-.48.57-.16.16-.33.34-.14.67.19.32.84 1.39 1.81 2.25 1.25 1.11 2.3 1.45 2.63 1.61.33.16.52.13.72-.1.2-.23.85-.99 1.08-1.33.23-.34.46-.28.78-.16.32.12 2.04 1.02 2.39 1.2.35.18.59.26.68.41.09.15.09.87-.23 1.77z"/></svg>
                    </span>
                    <span>4. WhatsApp Message QR Code</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-300 mb-4 leading-relaxed text-sm">
                    Launches a chat room window on the customer's WhatsApp app pointing to your phone number, along with a pre-written message template to initiate conversation.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Data Format</h4>
                        <code class="text-indigo-600 dark:text-indigo-400">https://wa.me/15550000000?text=Hi</code>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-xl">
                        <h4 class="font-bold mb-1 text-slate-700 dark:text-slate-350">Common Uses</h4>
                        <p class="text-slate-500 dark:text-slate-400">Customer service chats, order desks, real estate listing inquiries.</p>
                    </div>
                </div>
            </div>

            <!-- Email, Text, Phone, SMS, Location, Social -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 sm:p-8 shadow-md border border-slate-100 dark:border-slate-700">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Other Supported Types</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-slate-600 dark:text-slate-300">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">Email QR Code</h4>
                        <p class="text-xs mb-3">Formats a draft email with the recipient, subject, and message. Code syntax: <code class="bg-slate-100 dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 p-0.5 rounded">mailto:email?subject=X&amp;body=Y</code></p>

                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">SMS QR Code</h4>
                        <p class="text-xs mb-3">Launches a text messaging app with target recipient and pre-composed text. Code syntax: <code class="bg-slate-100 dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 p-0.5 rounded">smsto:number:message</code></p>

                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">Location (Geographical) QR</h4>
                        <p class="text-xs">Opens navigation mapping services (Google Maps/Apple Maps) pointing to coordinates. Code syntax: <code class="bg-slate-100 dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 p-0.5 rounded">geo:lat,lng</code></p>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">Phone Call QR Code</h4>
                        <p class="text-xs mb-3">Triggers phone dialer prompt with your company number. Code syntax: <code class="bg-slate-100 dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 p-0.5 rounded">tel:number</code></p>

                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">Plain Text QR Code</h4>
                        <p class="text-xs mb-3">Displays simple string sentences on screen upon scan. Good for serial keys or inventory.</p>

                        <h4 class="font-bold text-slate-900 dark:text-white mb-1">Social Profiles QR</h4>
                        <p class="text-xs">Direct link to target social pages (Facebook, Instagram, LinkedIn) to build followers.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold shadow hover:bg-indigo-700 transition-colors">
                <span>Start Generating QR Codes</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
        </div>

    </div>
</div>
@endsection
