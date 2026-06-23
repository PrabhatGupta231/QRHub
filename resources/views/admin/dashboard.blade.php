@extends('layouts.admin')

@section('admin_content')
<div class="space-y-8">
    
    <!-- Top Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total Generated -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Generated</span>
                <h3 class="text-3xl font-extrabold mt-1 text-slate-900 dark:text-white">{{ $totalGenerations }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
            </div>
        </div>
        <!-- Card 2: Generated Today -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Generated Today</span>
                <h3 class="text-3xl font-extrabold mt-1 text-slate-900 dark:text-white">{{ $generationsToday }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
        </div>
        <!-- Card 3: Total Posts -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Blog Articles</span>
                <h3 class="text-3xl font-extrabold mt-1 text-slate-900 dark:text-white">{{ $totalPosts }}</h3>
            </div>
            <div class="p-3 bg-purple-50 dark:bg-purple-950/30 text-purple-600 dark:text-purple-400 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6M7 12h6" /></svg>
            </div>
        </div>
        <!-- Card 4: Unread Inbox -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Unread Messages</span>
                <h3 class="text-3xl font-extrabold mt-1 text-slate-900 dark:text-white">{{ $unreadMessages }}</h3>
            </div>
            <div class="p-3 bg-pink-50 dark:bg-pink-950/30 text-pink-600 dark:text-pink-400 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5" /></svg>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daily Generations (Line Chart) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-6">Daily QR Generations (Last 10 Days)</h3>
            <div class="relative h-64 w-full">
                <canvas id="dailyStatsChart"></canvas>
            </div>
        </div>
        <!-- Types Distribution (Pie Chart) -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col">
            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-6">QR Code Types Distribution</h3>
            <div class="relative h-64 w-full flex-grow">
                <canvas id="typesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Recent QR Code Generations -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Recent QR Code Generations</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="pb-3">Type</th>
                            <th class="pb-3">Size/Margin</th>
                            <th class="pb-3 text-center">Logo</th>
                            <th class="pb-3 text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-650 dark:text-slate-300">
                        @forelse($recentGenerations as $rg)
                            <tr>
                                <td class="py-3 font-semibold capitalize text-indigo-600 dark:text-indigo-400">{{ $rg->qr_type }}</td>
                                <td class="py-3">{{ $rg->size }}px (m: {{ $rg->margin }})</td>
                                <td class="py-3 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $rg->logo_uploaded ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/20 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-900 dark:text-slate-400' }}">
                                        {{ $rg->logo_uploaded ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="py-3 text-right text-slate-400">{{ $rg->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-slate-400">No QR codes generated yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Contact Messages -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Recent Messages</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="pb-3">Sender</th>
                            <th class="pb-3">Subject</th>
                            <th class="pb-3 text-center">Status</th>
                            <th class="pb-3 text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-650 dark:text-slate-300">
                        @forelse($recentMessages as $rm)
                            <tr>
                                <td class="py-3">
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $rm->name }}</span>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $rm->email }}</p>
                                </td>
                                <td class="py-3 truncate max-w-[150px]">{{ $rm->subject }}</td>
                                <td class="py-3 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ !$rm->is_read ? 'bg-red-100 text-red-800 dark:bg-red-950/20 dark:text-red-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-900 dark:text-slate-400' }}">
                                        {{ !$rm->is_read ? 'New' : 'Read' }}
                                    </span>
                                </td>
                                <td class="py-3 text-right text-slate-400">{{ $rm->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-slate-400">No contact messages received.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. Daily Stats Chart (Line/Bar Chart)
        const dailyLabels = @json($dailyStats->pluck('date_label'));
        const dailyCounts = @json($dailyStats->pluck('count'));
        
        const ctxDaily = document.getElementById('dailyStatsChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'QR Codes Generated',
                    data: dailyCounts,
                    borderColor: 'rgb(79, 70, 229)', // indigo-600
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });

        // 2. Types Distribution Chart (Doughnut)
        const typeLabels = @json($typeDistribution->pluck('qr_type'));
        const typeCounts = @json($typeDistribution->pluck('total'));

        const ctxTypes = document.getElementById('typesChart').getContext('2d');
        new Chart(ctxTypes, {
            type: 'doughnut',
            data: {
                labels: typeLabels.map(t => t.toUpperCase()),
                datasets: [{
                    data: typeCounts,
                    backgroundColor: [
                        '#4F46E5', // indigo
                        '#7C3AED', // purple
                        '#EC4899', // pink
                        '#10B981', // emerald
                        '#F59E0B', // amber
                        '#EF4444', // red
                        '#3B82F6', // blue
                        '#6B7280'  // gray
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            font: { size: 10 }
                        }
                    }
                }
            }
        });

    });
</script>
@endsection
