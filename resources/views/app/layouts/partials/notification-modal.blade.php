<div id="public-notification-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-blue-50 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-center text-gray-900 mb-2" id="modal-title">Notification</h3>
            <p class="text-gray-500 text-center text-sm" id="modal-body"></p>
            <div class="mt-6">
                <button onclick="closePublicModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-colors shadow-lg cursor-pointer">
                    Understood
                </button>
            </div>
        </div>
    </div>
</div>
