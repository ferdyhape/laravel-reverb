@extends('app.layouts.master')

@section('title', 'Broadcast Notifications')

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- sucess alert --}}
        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <h1 class="text-2xl font-bold mb-2">Broadcast Notifications</h1>
        <p class="mb-4">Receive real-time notifications via Laravel Reverb.</p>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('broadcast-notifications.send') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 mb-1">Target Type</label>
                        <select name="type" id="type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="">Select Type</option>
                            <option value="user" {{ old('type') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="all" {{ old('type') == 'all' ? 'selected' : '' }}>All</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
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
