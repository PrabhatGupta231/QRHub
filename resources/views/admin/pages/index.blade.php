@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Custom Pages</h2>
    </div>

    <!-- Pages Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="p-4">Page Title</th>
                        <th class="p-4">Slug</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-650 dark:text-slate-300">
                    @forelse($pages as $page)
                        <tr>
                            <!-- Title -->
                            <td class="p-4 font-bold text-slate-900 dark:text-white text-sm">{{ $page->title }}</td>
                            <!-- Slug -->
                            <td class="p-4"><code class="bg-slate-100 dark:bg-slate-900 px-2 py-0.5 rounded text-[10px] text-indigo-650 dark:text-indigo-400">/page/{{ $page->slug }}</code></td>
                            <!-- Status -->
                            <td class="p-4 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $page->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/20 dark:text-emerald-400' : 'bg-red-100 text-red-800 dark:bg-red-950/20 dark:text-red-400' }}">
                                    {{ $page->is_active ? 'Active' : 'Disabled' }}
                                </span>
                            </td>
                            <!-- Actions -->
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="inline-block px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 rounded font-semibold text-[10px]">Edit Page</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">No pages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
