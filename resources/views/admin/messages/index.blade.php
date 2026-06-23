@extends('layouts.admin')

@section('admin_content')
<div class="space-y-6" x-data="messageInbox()">
    
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Inbox Contact Messages</h2>
    </div>

    <!-- Message List Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="p-4">Sender Info</th>
                        <th class="p-4">Subject</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Sent Time</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-650 dark:text-slate-300">
                    @forelse($messages as $msg)
                        <tr :class="{'bg-indigo-50/20 dark:bg-indigo-950/10': !messagesReadStatus[{{ $msg->id }}]}">
                            <!-- Sender -->
                            <td class="p-4">
                                <span class="font-bold text-slate-900 dark:text-white">{{ $msg->name }}</span>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $msg->email }}</p>
                            </td>
                            <!-- Subject -->
                            <td class="p-4 font-semibold">{{ $msg->subject }}</td>
                            <!-- Status -->
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold" 
                                      :class="messagesReadStatus[{{ $msg->id }}] ? 'bg-slate-100 text-slate-600 dark:bg-slate-900 dark:text-slate-400' : 'bg-red-100 text-red-800 dark:bg-red-950/20 dark:text-red-400'">
                                    <span x-text="messagesReadStatus[{{ $msg->id }}] ? 'Read' : 'New'"></span>
                                </span>
                            </td>
                            <!-- Time -->
                            <td class="p-4 text-slate-400">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                            <!-- Actions -->
                            <td class="p-4 text-right space-x-2">
                                <button @click="readMessage({{ $msg->id }})" type="button" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 rounded font-semibold text-[10px]">Read Message</button>
                                
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this message permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-650 dark:text-red-400 rounded font-semibold text-[10px]">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">Inbox is empty. No messages received yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Message Details Modal Backdrop -->
    <div x-show="activeMessage" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak x-transition>
        <div @click.away="activeMessage = null" class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 dark:border-slate-700 flex flex-col space-y-6">
            
            <div class="flex justify-between items-start border-b border-slate-100 dark:border-slate-700/50 pb-4">
                <div>
                    <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Message Details</span>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-1" x-text="activeMessage?.subject"></h3>
                </div>
                <button @click="activeMessage = null" class="p-1 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Details metadata -->
            <div class="grid grid-cols-2 gap-4 text-xs bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl">
                <div>
                    <span class="text-slate-400 block mb-0.5">From Sender</span>
                    <span class="font-bold text-slate-800 dark:text-white" x-text="activeMessage?.name"></span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Email Address</span>
                    <span class="font-bold text-slate-800 dark:text-white" x-text="activeMessage?.email"></span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">IP Address</span>
                    <span class="font-mono text-slate-800 dark:text-white" x-text="activeMessage?.ip_address ?? 'Not recorded'"></span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Sent Time</span>
                    <span class="font-bold text-slate-800 dark:text-white" x-text="formatDate(activeMessage?.created_at)"></span>
                </div>
            </div>

            <!-- Message content -->
            <div class="space-y-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Message Content</span>
                <div class="p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 text-sm text-slate-650 dark:text-slate-300 whitespace-pre-wrap leading-relaxed min-h-[120px]" x-text="activeMessage?.message"></div>
            </div>

            <!-- Close / Reply Actions -->
            <div class="flex justify-end space-x-2 border-t border-slate-100 dark:border-slate-700/50 pt-4">
                <a :href="'mailto:' + activeMessage?.email + '?subject=Re: ' + encodeURIComponent(activeMessage?.subject ?? '')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold">Reply via Email</a>
                <button @click="activeMessage = null" type="button" class="px-4 py-2 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-semibold">Close Dialog</button>
            </div>

        </div>
    </div>

</div>

<script>
    function messageInbox() {
        return {
            activeMessage: null,
            messagesReadStatus: {
                @foreach($messages as $msg)
                    {{ $msg->id }}: {{ $msg->is_read ? 'true' : 'false' }},
                @endforeach
            },

            async readMessage(id) {
                try {
                    const response = await fetch(`/admin/messages/${id}`);
                    const result = await response.json();
                    
                    if (result.success) {
                        this.activeMessage = result.message;
                        this.messagesReadStatus[id] = true;
                    }
                } catch (e) {
                    console.error('Error fetching message details:', e);
                }
            },

            formatDate(isoString) {
                if (!isoString) return '';
                const date = new Date(isoString);
                return date.toLocaleString();
            }
        };
    }
</script>
@endsection
