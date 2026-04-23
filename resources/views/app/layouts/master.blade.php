<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My App')</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    @vite(['resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <h1 class="font-bold text-lg">{{ config('app.name') }}</h1>
            @auth
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('broadcast-notifications') }}"
                        class="text-sm font-medium transition-colors {{ request()->routeIs('broadcast-notifications') ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                        Broadcast
                    </a>
                </div>
            @endauth
        </div>
        <div class="flex items-center gap-4">
            @auth
                <!-- Inbox Component -->
                @include('app.layouts.partials.inbox')

                <div class="flex items-center gap-4 border-l border-gray-100 pl-4 ml-2">
                    <div class="text-sm text-gray-600">
                        <span class="font-medium text-gray-900">{{ ucwords(auth()->user()->name) }}</span>
                        <span class="mx-1 text-gray-400">•</span>
                        <span
                            class="text-xs px-2 py-0.5 bg-gray-100 rounded-full font-bold text-gray-500">{{ strtoupper(auth()->user()->role) }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                        @csrf
                        <button type="submit"
                            class="text-sm bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg font-medium transition-colors cursor-pointer shadow-sm">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}"
                        class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg font-medium transition-colors shadow-sm">Register</a>
                </div>
            @endauth
        </div>
    </nav>

    <main class="p-6">
        <div class="max-w-4xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Modal Component -->
    @include('app.layouts.partials.notification-modal')

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script type="module">
        document.addEventListener("DOMContentLoaded", function() {
            // UI Helpers
            window.showPublicModal = function(title, body) {
                const modal = document.getElementById('public-notification-modal');
                document.getElementById('modal-title').innerText = title;
                document.getElementById('modal-body').innerText = body;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            window.closePublicModal = function() {
                const modal = document.getElementById('public-notification-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            window.markAsRead = function(id, title, body, element) {
                window.showPublicModal(title, body);

                fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (element) {
                                element.classList.remove('bg-blue-50/30');
                                const dot = element.querySelector('.bg-blue-600');
                                if (dot) dot.remove();
                            }

                            const countEl = document.getElementById('notification-count');
                            if (countEl) {
                                const currentCount = parseInt(countEl.innerText) || 0;
                                if (currentCount > 0) {
                                    const newCount = currentCount - 1;
                                    countEl.innerText = newCount + ' New';
                                    if (newCount === 0) {
                                        const badgeEl = document.getElementById('inbox-badge');
                                        if (badgeEl) badgeEl.classList.add('hidden');
                                    }
                                }
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            };

            // Event Listeners
            window.Echo.channel("public-messages")
                .listen(".all.notification", (event) => {
                    window.showPublicModal(event.title, event.body);
                });

            @auth
            window.Echo.private("user.{{ auth()->id() }}")
                .listen(".user.notification", (event) => {
                    const countEl = document.getElementById('notification-count');
                    const listEl = document.getElementById('notification-list');
                    const badgeEl = document.getElementById('inbox-badge');

                    if (countEl) {
                        const currentCount = parseInt(countEl.innerText) || 0;
                        countEl.innerText = (currentCount + 1) + ' New';
                    }

                    if (badgeEl) {
                        badgeEl.classList.remove('hidden');
                    } else {
                        const inboxBtn = document.getElementById('inbox-button');
                        if (inboxBtn) {
                            const newBadge = document.createElement('span');
                            newBadge.id = 'inbox-badge';
                            newBadge.className =
                                'absolute top-1 right-1 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white';
                            inboxBtn.appendChild(newBadge);
                        }
                    }

                    if (listEl) {
                        const newNotif = document.createElement('div');
                        newNotif.className =
                            'p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors cursor-pointer bg-blue-50/30';
                        newNotif.setAttribute('onclick',
                            `markAsRead(${event.id}, '${event.title}', '${event.body}', this)`);

                        newNotif.innerHTML = `
                                <div class="flex justify-between items-start">
                                    <p class="text-sm font-bold text-gray-900">${event.title}</p>
                                    <span class="w-2 h-2 bg-blue-600 rounded-full mt-1.5"></span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">${event.body}</p>
                                <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-wider font-semibold">Just now</p>
                            `;

                        if (listEl.querySelector('.text-center')) {
                            listEl.innerHTML = '';
                        }
                        listEl.insertBefore(newNotif, listEl.firstChild);
                    }
                });
        @endauth
        });
    </script>

    @stack('scripts')
</body>

</html>
