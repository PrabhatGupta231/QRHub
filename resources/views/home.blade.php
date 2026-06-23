@extends('layouts.app')

@section('content')
<div x-data="qrGenerator()" x-init="init()" class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Create Beautiful, <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Custom QR Codes</span>
            </h1>
            <p class="mt-4 text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">
                Generate 100% free, high-resolution QR codes in seconds. Add custom logos, colors, background transparency, and download in vector SVG or print-ready PNG. No registration required.
            </p>
        </div>

        <!-- Ad Slot: Top Banner -->
        <x-ad-placement slot="ad_header" />

        <!-- Main QR Code Generator Interface -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side: Controls & Tabs (7 cols) -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8 space-y-8">
                
                <!-- QR Code Types Grid -->
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">1. Choose QR Code Type</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                        <!-- URL Button -->
                        <button @click="setTab('url')" :class="tabClass('url')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            <span class="text-xs mt-1">URL</span>
                        </button>
                        <!-- Text Button -->
                        <button @click="setTab('text')" :class="tabClass('text')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                            <span class="text-xs mt-1">Text</span>
                        </button>
                        <!-- Email Button -->
                        <button @click="setTab('email')" :class="tabClass('email')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            <span class="text-xs mt-1">Email</span>
                        </button>
                        <!-- Phone Button -->
                        <button @click="setTab('phone')" :class="tabClass('phone')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            <span class="text-xs mt-1">Phone</span>
                        </button>
                        <!-- SMS Button -->
                        <button @click="setTab('sms')" :class="tabClass('sms')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            <span class="text-xs mt-1">SMS</span>
                        </button>
                        <!-- WhatsApp Button -->
                        <button @click="setTab('whatsapp')" :class="tabClass('whatsapp')" type="button">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.96 9.96 0 001.333 4.982L2 22l5.176-1.359a9.943 9.943 0 004.832 1.259h.004c5.507 0 9.99-4.479 9.992-9.986.002-2.67-1.037-5.178-2.929-7.07A9.925 9.925 0 0012.012 2zm5.836 14.199c-.32.9-1.845 1.76-2.53 1.83-.54.05-1.09.28-3.46-.66-3.05-1.2-5.01-4.31-5.16-4.51-.15-.2-1.25-1.66-1.25-3.17 0-1.51.79-2.25 1.07-2.55.28-.3.62-.37.82-.37h.59c.19 0 .44-.07.69.54.25.61.85 2.07.93 2.22.08.15.13.33.03.53-.1.2-.21.33-.37.52-.16.19-.34.42-.48.57-.16.16-.33.34-.14.67.19.32.84 1.39 1.81 2.25 1.25 1.11 2.3 1.45 2.63 1.61.33.16.52.13.72-.1.2-.23.85-.99 1.08-1.33.23-.34.46-.28.78-.16.32.12 2.04 1.02 2.39 1.2.35.18.59.26.68.41.09.15.09.87-.23 1.77z"/></svg>
                            <span class="text-xs mt-1">WhatsApp</span>
                        </button>
                        <!-- WiFi Button -->
                        <button @click="setTab('wifi')" :class="tabClass('wifi')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a11 11 0 0115.808 0M1.757 7.071a17 17 0 0120.485 0" /></svg>
                            <span class="text-xs mt-1">WiFi</span>
                        </button>
                        <!-- vCard Button -->
                        <button @click="setTab('vcard')" :class="tabClass('vcard')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M21 12h-6m6 4h-6" /></svg>
                            <span class="text-xs mt-1">vCard</span>
                        </button>
                        <!-- Location Button -->
                        <button @click="setTab('location')" :class="tabClass('location')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span class="text-xs mt-1">Location</span>
                        </button>
                        <!-- Social Media Button -->
                        <button @click="setTab('social')" :class="tabClass('social')" type="button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            <span class="text-xs mt-1">Social</span>
                        </button>
                    </div>
                </div>

                <!-- QR Forms Container -->
                <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800">
                    
                    <!-- URL Form -->
                    <template x-if="type === 'url'">
                        <div class="space-y-4">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Destination URL</label>
                            <input x-model="fields.url" @input="debouncedFetch()" type="url" placeholder="https://example.com" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                        </div>
                    </template>

                    <!-- Text Form -->
                    <template x-if="type === 'text'">
                        <div class="space-y-4">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Plain Text</label>
                            <textarea x-model="fields.text" @input="debouncedFetch()" rows="4" placeholder="Enter text content here..." class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white"></textarea>
                        </div>
                    </template>

                    <!-- Email Form -->
                    <template x-if="type === 'email'">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Email Address</label>
                                <input x-model="fields.email" @input="debouncedFetch()" type="email" placeholder="hello@example.com" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Subject</label>
                                <input x-model="fields.subject" @input="debouncedFetch()" type="text" placeholder="Inquiry" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Message Body</label>
                                <textarea x-model="fields.body" @input="debouncedFetch()" rows="3" placeholder="Enter message here..." class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white"></textarea>
                            </div>
                        </div>
                    </template>

                    <!-- Phone Form -->
                    <template x-if="type === 'phone'">
                        <div class="space-y-4">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Phone Number</label>
                            <input x-model="fields.phone" @input="debouncedFetch()" type="tel" placeholder="+1 (555) 000-0000" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                        </div>
                    </template>

                    <!-- SMS Form -->
                    <template x-if="type === 'sms'">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Phone Number</label>
                                <input x-model="fields.phone" @input="debouncedFetch()" type="tel" placeholder="+1 (555) 000-0000" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Message</label>
                                <textarea x-model="fields.message" @input="debouncedFetch()" rows="3" placeholder="Enter message..." class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white"></textarea>
                            </div>
                        </div>
                    </template>

                    <!-- WhatsApp Form -->
                    <template x-if="type === 'whatsapp'">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Phone Number (with Country Code, e.g. 15550000000)</label>
                                <input x-model="fields.phone" @input="debouncedFetch()" type="tel" placeholder="15550000000" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Pre-filled Text Message</label>
                                <textarea x-model="fields.message" @input="debouncedFetch()" rows="3" placeholder="Hello, I would like to inquire about..." class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white"></textarea>
                            </div>
                        </div>
                    </template>

                    <!-- WiFi Form -->
                    <template x-if="type === 'wifi'">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Network SSID (Name)</label>
                                <input x-model="fields.ssid" @input="debouncedFetch()" type="text" placeholder="MyWiFiNetwork" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Password</label>
                                <input x-model="fields.password" @input="debouncedFetch()" type="password" placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Network Encryption</label>
                                    <select x-model="fields.encryption" @change="debouncedFetch()" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white">
                                        <option value="WPA">WPA/WPA2</option>
                                        <option value="WEP">WEP</option>
                                        <option value="nopass">Unencrypted (Open)</option>
                                    </select>
                                </div>
                                <div class="flex items-center mt-6">
                                    <input x-model="fields.hidden" @change="debouncedFetch()" id="wifi-hidden" type="checkbox" value="true" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" />
                                    <label for="wifi-hidden" class="ml-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Hidden Network</label>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- vCard Form -->
                    <template x-if="type === 'vcard'">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">First Name</label>
                                    <input x-model="fields.first_name" @input="debouncedFetch()" type="text" placeholder="John" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Last Name</label>
                                    <input x-model="fields.last_name" @input="debouncedFetch()" type="text" placeholder="Doe" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Organization</label>
                                    <input x-model="fields.org" @input="debouncedFetch()" type="text" placeholder="Acme Corp" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Job Title</label>
                                    <input x-model="fields.title" @input="debouncedFetch()" type="text" placeholder="Manager" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Mobile Phone</label>
                                    <input x-model="fields.cell" @input="debouncedFetch()" type="tel" placeholder="+15550000000" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Work Phone</label>
                                    <input x-model="fields.work" @input="debouncedFetch()" type="tel" placeholder="+15550000001" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Email</label>
                                    <input x-model="fields.email" @input="debouncedFetch()" type="email" placeholder="john@example.com" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Website URL</label>
                                    <input x-model="fields.url" @input="debouncedFetch()" type="url" placeholder="https://example.com" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Full Work Address</label>
                                <input x-model="fields.address" @input="debouncedFetch()" type="text" placeholder="123 main St, NY, USA" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">Note</label>
                                <textarea x-model="fields.note" @input="debouncedFetch()" rows="2" placeholder="Brief note..." class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white"></textarea>
                            </div>
                        </div>
                    </template>

                    <!-- Location Form -->
                    <template x-if="type === 'location'">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Latitude</label>
                                    <input x-model="fields.latitude" @input="debouncedFetch()" type="text" placeholder="40.7128" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Longitude</label>
                                    <input x-model="fields.longitude" @input="debouncedFetch()" type="text" placeholder="-74.0060" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Social Form -->
                    <template x-if="type === 'social'">
                        <div class="space-y-4">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Social Profile URL</label>
                            <input x-model="fields.social_url" @input="debouncedFetch()" type="url" placeholder="https://instagram.com/myusername" class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:text-white" />
                        </div>
                    </template>
                </div>

                <!-- Customization Accordions -->
                <div class="space-y-4" x-data="{ activeAccordion: null }">
                    
                    <!-- Accordion 1: Design & Colors -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = (activeAccordion === 1 ? null : 1)" class="w-full px-6 py-4 flex items-center justify-between bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-semibold text-left focus:outline-none">
                            <span class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                                <span>Design & Colors</span>
                            </span>
                            <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': activeAccordion === 1}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="activeAccordion === 1" class="p-6 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 space-y-6" x-transition>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">QR Code Color</label>
                                    <div class="flex items-center space-x-2">
                                        <input x-model="color" @input="debouncedFetch()" type="color" class="h-10 w-12 rounded border border-slate-300 dark:border-slate-700 cursor-pointer" />
                                        <input x-model="color" @input="debouncedFetch()" type="text" class="w-full px-3 py-2 border rounded-lg dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-sm" />
                                    </div>
                                </div>
                                <div x-show="!transparent">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Background Color</label>
                                    <div class="flex items-center space-x-2">
                                        <input x-model="bgColor" @input="debouncedFetch()" type="color" class="h-10 w-12 rounded border border-slate-300 dark:border-slate-700 cursor-pointer" />
                                        <input x-model="bgColor" @input="debouncedFetch()" type="text" class="w-full px-3 py-2 border rounded-lg dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-sm" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input x-model="transparent" @change="debouncedFetch()" id="qr-transparent" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" />
                                <label for="qr-transparent" class="ml-2 block text-sm text-slate-700 dark:text-slate-200">Transparent Background</label>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 2: Upload Logo -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = (activeAccordion === 2 ? null : 2)" class="w-full px-6 py-4 flex items-center justify-between bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-semibold text-left focus:outline-none">
                            <span class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span>Add Custom Logo</span>
                            </span>
                            <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': activeAccordion === 2}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="activeAccordion === 2" class="p-6 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 space-y-4" x-transition>
                            
                            <!-- Logo Picker / Preview -->
                            <div class="flex items-center space-x-4">
                                <div class="relative w-16 h-16 bg-slate-100 dark:bg-slate-900 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <template x-if="logoUrl">
                                        <img :src="logoUrl" class="w-full h-full object-contain" />
                                    </template>
                                    <template x-if="!logoUrl">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0a9 9 0 0118 0z" /></svg>
                                    </template>
                                </div>
                                <div class="flex-grow">
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Upload PNG, JPG, or JPEG logo. Max 2MB. Recommended layout is a simple, high-contrast, centered icon.</p>
                                    <div class="flex items-center space-x-2">
                                        <input @change="uploadLogo($event)" type="file" accept="image/png, image/jpeg, image/jpg" class="hidden" id="logo-file-input" />
                                        <label for="logo-file-input" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold cursor-pointer transition-colors">
                                            Choose File
                                        </label>
                                        <button x-show="logoUrl" @click="removeLogo()" type="button" class="px-4 py-2 border border-red-200 dark:border-red-800 text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg text-xs font-semibold transition-colors">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion 3: Code Configuration -->
                    <div class="border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                        <button @click="activeAccordion = (activeAccordion === 3 ? null : 3)" class="w-full px-6 py-4 flex items-center justify-between bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white font-semibold text-left focus:outline-none">
                            <span class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4 2 2 0 000 4zm0 0v2m0-6V4m6 6v10m6-2a2 2 0 100-4 2 2 0 000 4zm0 0v2m0-6V4" /></svg>
                                <span>Layout & Export Settings</span>
                            </span>
                            <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': activeAccordion === 3}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="activeAccordion === 3" class="p-6 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 space-y-6" x-transition>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">QR Size (px)</label>
                                    <select x-model="size" @change="debouncedFetch()" class="w-full px-3 py-2 border rounded-lg dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-sm">
                                        <option value="200">200x200</option>
                                        <option value="300">300x300</option>
                                        <option value="450">450x450</option>
                                        <option value="600">600x600</option>
                                        <option value="800">800x800</option>
                                        <option value="1000">1000x1000</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Margin Blocks</label>
                                    <select x-model="margin" @change="debouncedFetch()" class="w-full px-3 py-2 border rounded-lg dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-sm">
                                        <option value="0">0 (No Margin)</option>
                                        <option value="1">1</option>
                                        <option value="2">2 (Default)</option>
                                        <option value="4">4</option>
                                        <option value="6">6</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-2">Error Correction</label>
                                    <select x-model="ecc" @change="debouncedFetch()" class="w-full px-3 py-2 border rounded-lg dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-sm">
                                        <option value="L">L (7% Recovery)</option>
                                        <option value="M">M (15% Recovery)</option>
                                        <option value="Q">Q (25% Recovery)</option>
                                        <option value="H">H (30% Recovery - Recommended for logo)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Right Side: Real-Time Preview Panel (5 cols) -->
            <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-6">
                
                <!-- Preview Card -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8 flex flex-col items-center">
                    
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-6 w-full text-center">Live Preview</h2>
                    
                    <!-- QR Image Frame -->
                    <div class="relative w-64 h-64 bg-slate-100 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex items-center justify-center overflow-hidden shadow-inner">
                        
                        <!-- Real-time Loading Spinner -->
                        <div x-show="loading" class="absolute inset-0 bg-white/60 dark:bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-10" x-transition>
                            <svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <!-- Render SVG directly -->
                        <div class="w-full h-full text-slate-900 dark:text-white flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:max-w-full [&>svg]:max-h-full" x-html="svgPreview"></div>

                    </div>

                    <!-- Size details text -->
                    <span class="text-xs text-slate-400 dark:text-slate-500 mt-4" x-text="'Standard Export: ' + size + ' x ' + size + ' px'"></span>

                    <!-- Export Actions Grid -->
                    <div class="grid grid-cols-2 gap-3 w-full mt-6">
                        <!-- Download SVG -->
                        <button @click="triggerDownload('svg')" type="button" class="w-full flex items-center justify-center space-x-2 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition-all text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            <span>Download SVG</span>
                        </button>
                        <!-- Download PNG -->
                        <button @click="triggerDownload('png')" type="button" class="w-full flex items-center justify-center space-x-2 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-semibold shadow-md transition-all text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            <span>Download PNG</span>
                        </button>
                    </div>

                    <!-- Micro Actions Row -->
                    <div class="grid grid-cols-3 gap-2 w-full mt-3">
                        <button @click="copyData()" type="button" class="flex flex-col items-center justify-center py-2 px-1 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-all border border-slate-100 dark:border-slate-800">
                            <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                            <span class="text-[10px] mt-1 font-semibold text-slate-500 dark:text-slate-400" x-text="copied ? 'Copied!' : 'Copy Data'"></span>
                        </button>
                        <button @click="openShareModal()" type="button" class="flex flex-col items-center justify-center py-2 px-1 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-all border border-slate-100 dark:border-slate-800">
                            <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742l5.263-2.632m0 5.422l-5.262-2.63m1.526-1.116A3 3 0 1111 8a3 3 0 01-1.052 2.315M17 14a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span class="text-[10px] mt-1 font-semibold text-slate-500 dark:text-slate-400">Share QR</span>
                        </button>
                        <button @click="printQR()" type="button" class="flex flex-col items-center justify-center py-2 px-1 hover:bg-slate-100 dark:hover:bg-slate-700/50 rounded-xl transition-all border border-slate-100 dark:border-slate-800">
                            <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            <span class="text-[10px] mt-1 font-semibold text-slate-500 dark:text-slate-400">Print QR</span>
                        </button>
                    </div>

                </div>

                <!-- Ad Slot: Sidebar Placement -->
                <x-ad-placement slot="ad_sidebar" />

            </div>

        </div>

        <!-- Hidden Form for Post Download -->
        <form id="download-form" action="{{ route('qr.download') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="type" :value="type" />
            <input type="hidden" name="format" id="download-format-input" />
            <input type="hidden" name="size" :value="size" />
            <input type="hidden" name="margin" :value="margin" />
            <input type="hidden" name="color" :value="color" />
            <input type="hidden" name="bg_color" :value="bgColor" />
            <input type="hidden" name="transparent" :value="transparent" />
            <input type="hidden" name="ecc" :value="ecc" />
            <input type="hidden" name="logo_path" :value="logoPath" />

            <!-- Type-Specific Dynamic Fields -->
            <template x-for="(val, key) in fields">
                <input type="hidden" :name="key" :value="val" />
            </template>
        </form>

        <!-- Share Modal Backdrop -->
        <div x-show="showShareModal" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition>
            <div @click.away="showShareModal = false" class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700 flex flex-col space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Share QR Code</h3>
                    <button @click="showShareModal = false" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Copy this direct link to share your QR Code image preview with others:</p>
                    <div class="flex items-center space-x-2">
                        <input type="text" :value="shareLink" readonly class="flex-grow px-3 py-2 text-xs border rounded-lg bg-slate-50 dark:bg-slate-900 border-slate-300 dark:border-slate-700 dark:text-white" id="share-link-input" />
                        <button @click="copyShareLink()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700">Copy</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Popular QR Types -->
        <div class="mt-24 border-t border-slate-200 dark:border-slate-800 pt-16">
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white text-center mb-12">Popular QR Code Types</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow border border-slate-100 dark:border-slate-700 flex flex-col">
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 rounded-xl w-fit">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071a11 11 0 0115.808 0M1.757 7.071a17 17 0 0120.485 0" /></svg>
                    </div>
                    <h3 class="text-xl font-bold mt-4 mb-2 text-slate-900 dark:text-white">WiFi Connection</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm flex-grow mb-4">Let customers, guests, or employees scan to connect to your office or store WiFi immediately. No more typed passwords!</p>
                    <button @click="setTab('wifi')" class="text-indigo-600 font-semibold text-sm hover:underline w-fit flex items-center">Generate WiFi QR &rarr;</button>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow border border-slate-100 dark:border-slate-700 flex flex-col">
                    <div class="p-3 bg-purple-50 dark:bg-purple-950/30 text-purple-600 dark:text-purple-400 rounded-xl w-fit">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M21 12h-6m6 4h-6" /></svg>
                    </div>
                    <h3 class="text-xl font-bold mt-4 mb-2 text-slate-900 dark:text-white">vCard Contact Card</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm flex-grow mb-4">Place a vCard QR on your print business cards. Scanners will load your phone, email, and address directly into their phonebook.</p>
                    <button @click="setTab('vcard')" class="text-indigo-600 font-semibold text-sm hover:underline w-fit flex items-center">Generate vCard QR &rarr;</button>
                </div>
                <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow border border-slate-100 dark:border-slate-700 flex flex-col">
                    <div class="p-3 bg-pink-50 dark:bg-pink-950/30 text-pink-600 dark:text-pink-400 rounded-xl w-fit">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    </div>
                    <h3 class="text-xl font-bold mt-4 mb-2 text-slate-900 dark:text-white">Marketing URLs</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm flex-grow mb-4">Redirect offline users on menus, banners, and flyers to dynamic web pages, landing pages, discounts, and app download portals.</p>
                    <button @click="setTab('url')" class="text-indigo-600 font-semibold text-sm hover:underline w-fit flex items-center">Generate URL QR &rarr;</button>
                </div>
            </div>
        </div>

        <!-- Section 3: Features -->
        <div class="mt-24 bg-indigo-900 text-white rounded-3xl p-8 sm:p-12 shadow-2xl relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-800 rounded-full opacity-50 blur-3xl"></div>
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Optimized for Speed, Security, and Scalability</h2>
                    <p class="mt-4 text-indigo-200 text-lg leading-relaxed">
                        Unlike other tools, QRHub doesn't store your QR values, track your users, or redirect links through middleman portals. Everything is generated safely, instantly, and served locally.
                    </p>
                    <div class="mt-8 flex flex-col space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="p-2 bg-indigo-800 rounded-lg text-indigo-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            <span class="font-medium text-indigo-100">No Signup or Account Registration Required</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="p-2 bg-indigo-800 rounded-lg text-indigo-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            <span class="font-medium text-indigo-100">Fully Vector SVG Export (Infinite Resolution)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="p-2 bg-indigo-800 rounded-lg text-indigo-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            <span class="font-medium text-indigo-100">Secure Rate Limiting and Validation Controls</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-indigo-850 p-6 rounded-2xl border border-indigo-750">
                        <h4 class="font-bold text-lg text-indigo-300">100% Free</h4>
                        <p class="text-xs text-indigo-200 mt-2">Unlimited downloads. No paid tiers, hidden subscriptions, or trial constraints.</p>
                    </div>
                    <div class="bg-indigo-850 p-6 rounded-2xl border border-indigo-750">
                        <h4 class="font-bold text-lg text-indigo-300">Brand Logo</h4>
                        <p class="text-xs text-indigo-200 mt-2">Integrate your custom branding logo directly inside the code matrix with one click.</p>
                    </div>
                    <div class="bg-indigo-850 p-6 rounded-2xl border border-indigo-750">
                        <h4 class="font-bold text-lg text-indigo-300">Fast Loading</h4>
                        <p class="text-xs text-indigo-200 mt-2">Built on lightweight, optimized architectures with cached route layers.</p>
                    </div>
                    <div class="bg-indigo-850 p-6 rounded-2xl border border-indigo-750">
                        <h4 class="font-bold text-lg text-indigo-300">AdSense Ready</h4>
                        <p class="text-xs text-indigo-200 mt-2">Strategically sized, non-obtrusive ad placement placeholders ready to earn revenue.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: How It Works -->
        <div class="mt-24 text-slate-900 dark:text-white">
            <h2 class="text-3xl font-extrabold text-center mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg mb-4">1</div>
                    <h3 class="font-bold text-lg mb-2">Select Type & Content</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Choose from 10 inputs like WiFi, URL, or vCard and fill in your fields.</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg mb-4">2</div>
                    <h3 class="font-bold text-lg mb-2">Customize Branding</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Adjust colors, make backgrounds transparent, or upload your logo icon.</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold text-lg mb-4">3</div>
                    <h3 class="font-bold text-lg mb-2">Instant Download</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Check readability in the live preview and download in SVG or PNG vector.</p>
                </div>
            </div>
        </div>

        <!-- Section 5: FAQ Section (Accordion list using Alpine.js) -->
        <div class="mt-24 max-w-4xl mx-auto" x-data="{ openFaq: null }">
            <h2 class="text-3xl font-extrabold text-center mb-12 text-slate-900 dark:text-white">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <div class="border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 rounded-2xl overflow-hidden">
                    <button @click="openFaq = (openFaq === 1 ? null : 1)" class="w-full px-6 py-4 flex items-center justify-between font-semibold text-left focus:outline-none dark:text-white">
                        <span>Are the QR codes generated on QRHub static or dynamic?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': openFaq === 1}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="openFaq === 1" class="px-6 pb-6 text-sm text-slate-500 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700/50 pt-4" x-transition>
                        All QR codes generated are static. This means they embed your content (e.g. WiFi credentials, contact cards) directly into the code and will work forever. Static codes are completely secure and do not route through third-party servers.
                    </div>
                </div>

                <div class="border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 rounded-2xl overflow-hidden">
                    <button @click="openFaq = (openFaq === 2 ? null : 2)" class="w-full px-6 py-4 flex items-center justify-between font-semibold text-left focus:outline-none dark:text-white">
                        <span>Why does my QR code with a logo fail to scan?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': openFaq === 2}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="openFaq === 2" class="px-6 pb-6 text-sm text-slate-500 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700/50 pt-4" x-transition>
                        If your QR code fails to scan, ensure that: (1) there is sufficient color contrast between the code blocks and the background. (2) The uploaded logo is not too large and covers less than 15-20% of the matrix. (3) You have selected the "High (H)" error correction level, which duplicates block records to help scanners read obstructed codes.
                    </div>
                </div>

                <div class="border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 rounded-2xl overflow-hidden">
                    <button @click="openFaq = (openFaq === 3 ? null : 3)" class="w-full px-6 py-4 flex items-center justify-between font-semibold text-left focus:outline-none dark:text-white">
                        <span>Is there a scan limit on my generated codes?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': openFaq === 3}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="openFaq === 3" class="px-6 pb-6 text-sm text-slate-500 dark:text-slate-400 border-t border-slate-100 dark:border-slate-700/50 pt-4" x-transition>
                        No! Since the generated codes are static and point directly to your inputs, they have no expiration date and no scanning limits. You can scan them millions of times for commercial or personal purposes for free.
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 6: Latest Blog Articles -->
        <div class="mt-24">
            <h2 class="text-3xl font-extrabold text-center mb-12 text-slate-900 dark:text-white">Latest from Our Blog</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts as $post)
                    <article class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-md border border-slate-100 dark:border-slate-700 flex flex-col">
                        <div class="h-48 bg-slate-100 dark:bg-slate-900 flex items-center justify-center relative overflow-hidden">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" />
                            @else
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white p-6 text-center font-bold text-lg">
                                    {{ $post->title }}
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                                {{ $post->category->name }}
                            </span>
                            <h3 class="text-xl font-bold mt-2 mb-3 text-slate-900 dark:text-white line-clamp-2">
                                <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-indigo-650 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 mb-4 flex-grow">
                                {{ $post->summary }}
                            </p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-600 dark:text-indigo-400 font-bold text-sm hover:underline">
                                Read Article &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

    </div>
</div>

<!-- Dynamic client script for Alpine.js QR Preview -->
<script>
    function qrGenerator() {
        return {
            type: 'url',
            fields: {
                // url fields
                url: 'https://google.com',
                // text fields
                text: '',
                // email fields
                email: '',
                subject: '',
                body: '',
                // phone & sms
                phone: '',
                message: '',
                // wifi
                ssid: '',
                password: '',
                encryption: 'WPA',
                hidden: 'false',
                // vcard
                first_name: '',
                last_name: '',
                org: '',
                title: '',
                cell: '',
                work: '',
                address: '',
                note: '',
                // location
                latitude: '',
                longitude: '',
                // social
                social_url: ''
            },
            color: '#0F172A', // Navy/Slate (matches premium look)
            bgColor: '#FFFFFF',
            transparent: false,
            logoPath: '',
            logoUrl: '',
            size: 300,
            margin: 2,
            ecc: 'M',
            svgPreview: '',
            loading: false,
            copied: false,
            showShareModal: false,
            shareLink: '',
            timeout: null,

            init() {
                this.fetchPreview();
            },

            setTab(tab) {
                this.type = tab;
                
                // Clear and load defaults
                if (tab === 'url' && !this.fields.url) {
                    this.fields.url = 'https://google.com';
                }
                
                this.fetchPreview();
            },

            tabClass(tab) {
                const base = "flex flex-col items-center justify-center p-3 rounded-xl border text-sm font-semibold transition-all ";
                if (this.type === tab) {
                    return base + "bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-600/30 scale-105";
                }
                return base + "bg-slate-50 dark:bg-slate-900 border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800";
            },

            debouncedFetch() {
                if (this.timeout) clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.fetchPreview();
                }, 400); // 400ms debounce
            },

            async fetchPreview() {
                this.loading = true;
                
                const payload = {
                    type: this.type,
                    color: this.color,
                    bg_color: this.bgColor,
                    transparent: this.transparent ? 'true' : 'false',
                    size: this.size,
                    margin: this.margin,
                    ecc: this.ecc,
                    logo_path: this.logoPath,
                    ...this.fields
                };

                try {
                    const response = await fetch('{{ route("qr.preview") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });

                    if (response.ok) {
                        this.svgPreview = await response.text();
                    } else {
                        console.error('Failed to load QR preview.');
                    }
                } catch (e) {
                    console.error(e);
                } finally {
                    this.loading = false;
                }
            },

            async uploadLogo(event) {
                const file = event.target.files[0];
                if (!file) return;

                this.loading = true;
                const formData = new FormData();
                formData.append('logo', file);

                try {
                    const response = await fetch('{{ route("qr.upload_logo") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    });

                    const result = await response.json();
                    if (result.success) {
                        this.logoPath = result.path;
                        this.logoUrl = result.url;
                        this.fetchPreview();
                    } else {
                        alert(result.message || 'Logo upload failed');
                    }
                } catch (e) {
                    console.error(e);
                    alert('Error uploading logo.');
                } finally {
                    this.loading = false;
                }
            },

            removeLogo() {
                this.logoPath = '';
                this.logoUrl = '';
                this.fetchPreview();
                document.getElementById('logo-file-input').value = '';
            },

            triggerDownload(format) {
                document.getElementById('download-format-input').value = format;
                document.getElementById('download-form').submit();
            },

            copyData() {
                let textToCopy = '';
                
                // Fetch corresponding active text data
                if (this.type === 'url') textToCopy = this.fields.url;
                else if (this.type === 'text') textToCopy = this.fields.text;
                else if (this.type === 'email') textToCopy = `mailto:${this.fields.email}?subject=${encodeURIComponent(this.fields.subject)}&body=${encodeURIComponent(this.fields.body)}`;
                else if (this.type === 'phone') textToCopy = `tel:${this.fields.phone}`;
                else if (this.type === 'sms') textToCopy = `smsto:${this.fields.phone}:${this.fields.message}`;
                else if (this.type === 'whatsapp') textToCopy = `https://wa.me/${this.fields.phone.replace(/[^0-9]/g, '')}?text=${encodeURIComponent(this.fields.message)}`;
                else if (this.type === 'wifi') textToCopy = `WIFI:S:${this.fields.ssid};T:${this.fields.encryption};P:${this.fields.password};${this.fields.hidden === 'true' ? 'H:true;' : ''};`;
                else if (this.type === 'location') textToCopy = `geo:${this.fields.latitude},${this.fields.longitude}`;
                else if (this.type === 'social') textToCopy = this.fields.social_url;
                else if (this.type === 'vcard') {
                    textToCopy = `BEGIN:VCARD\nVERSION:3.0\nN:${this.fields.last_name};${this.fields.first_name};;;\nFN:${this.fields.first_name} ${this.fields.last_name}\nORG:${this.fields.org}\nTITLE:${this.fields.title}\nTEL;TYPE=CELL:${this.fields.cell}\nTEL;TYPE=WORK:${this.fields.work}\nEMAIL;TYPE=PREF,INTERNET:${this.fields.email}\nURL:${this.fields.url}\nADR;TYPE=WORK:;;${this.fields.address};;;;\nNOTE:${this.fields.note}\nEND:VCARD`;
                }

                navigator.clipboard.writeText(textToCopy).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                });
            },

            openShareModal() {
                // Generate absolute preview link for the modal
                const params = new URLSearchParams({
                    type: this.type,
                    color: this.color,
                    bg_color: this.bgColor,
                    transparent: this.transparent ? 'true' : 'false',
                    size: this.size,
                    margin: this.margin,
                    ecc: this.ecc,
                    logo_path: this.logoPath,
                    ...this.fields
                });
                
                // Direct call endpoint
                this.shareLink = `${window.location.origin}/qr/preview?${params.toString()}`;
                this.showShareModal = true;
            },

            copyShareLink() {
                const copyText = document.getElementById('share-link-input');
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value).then(() => {
                    alert('Share link copied to clipboard!');
                });
            },

            printQR() {
                // Open new window, render SVG, call print
                const printWindow = window.open('', '_blank', 'width=600,height=600');
                printWindow.document.write('<html><head><title>Print QR Code</title>');
                printWindow.document.write('<style>body{display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(this.svgPreview);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                
                // Wait for print resource rendering
                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 250);
            }
        };
    }
</script>
@endsection
