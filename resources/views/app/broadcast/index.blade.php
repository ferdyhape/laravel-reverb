@extends('app.layouts.master')

@section('title', 'Broadcast Notifications')

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- sucess alert --}}
        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        <h1 class="text-2xl font-bold mb-2">Broadcast Notifications</h1>
        <p class="mb-4">Receive real-time notifications via Laravel Reverb.</p>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200" x-data="{ targetType: '{{ old('type', '') }}' }" x-init="$watch('targetType', value => { if (value === 'user') initUserSelect() });
        if (targetType === 'user') initUserSelect();">
            <form action="{{ route('broadcast-notifications.send') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Target Type</label>
                        <select name="type" id="type" x-model="targetType"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select Type</option>
                            <option value="user">Specific User</option>
                            <option value="role">By Role</option>
                            <option value="all">All Users</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="targetType === 'role'" x-transition>
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Target Role</label>
                        <select name="role" id="role"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="targetType === 'user'" x-transition>
                        <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-1">Target User</label>
                        <div class="tom-select-wrapper">
                            <select name="user_id" id="user_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                <option value="">Search user...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ ucfirst($user->role) }}) - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Notification
                            Title</label>
                        <input type="text" name="title" id="title" placeholder="e.g. New Update Available"
                            value="{{ old('title') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="body" class="block text-sm font-semibold text-gray-700 mb-1">Notification
                            Body</label>
                        <textarea name="body" id="body" rows="3" placeholder="Describe the notification..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button id="sendMessageBtn"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg font-bold transition-all transform active:scale-[0.98] shadow-md">
                        Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .ts-control {
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            border: 1px solid #d1d5db !important;
        }

        .ts-wrapper.focus .ts-control {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important;
        }

        .ts-dropdown {
            border-radius: 0.5rem !important;
            margin-top: 4px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            // We'll initialize TomSelect via a watcher to ensure it only happens when visible
        });

        // Cleanup function for TomSelect instance
        window.initUserSelect = function() {
            if (window.userSelect) return;

            setTimeout(() => {
                const el = document.getElementById('user_id');
                if (el) {
                    window.userSelect = new TomSelect(el, {
                        create: false,
                        sortField: {
                            field: 'text',
                            order: 'asc'
                        },
                        placeholder: 'Search user...',
                        dropdownParent: 'body' // Important to avoid clipping issues
                    });
                }
            }, 50);
        };
    </script>
@endpush
