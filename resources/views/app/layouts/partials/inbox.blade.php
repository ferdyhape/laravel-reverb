<div class="relative" x-data="{ open: false }">
    <button id="inbox-button" @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600 relative focus:outline-none cursor-pointer">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-1 right-1 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white" id="inbox-badge"></span>
        @endif
    </button>

    <!-- Inbox Dropdown -->
    <div x-show="open" @click.away="open = false" 
        class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden"
        style="display: none;">
        <div class="p-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-900">Notifications</h3>
            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full" id="notification-count">
                {{ auth()->user()->unreadNotifications->count() }} New
            </span>
        </div>
        <div class="max-h-96 overflow-y-auto" id="notification-list">
            @forelse(auth()->user()->notifications->take(10) as $notification)
                <div onclick="markAsRead({{ $notification->id }}, '{{ $notification->title }}', '{{ $notification->body }}', this)" 
                    class="p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors cursor-pointer {{ !$notification->read_at ? 'bg-blue-50/30' : '' }}"
                    data-id="{{ $notification->id }}">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-bold text-gray-900">{{ $notification->title }}</p>
                        @if(!$notification->read_at)
                            <span class="w-2 h-2 bg-blue-600 rounded-full mt-1.5"></span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $notification->body }}</p>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider font-semibold">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-sm">No notifications yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
