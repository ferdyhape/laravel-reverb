@extends('app.layouts.master')

@section('title', 'Learning Laravel Reverb')

@section('content')
<div class="py-16">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Learning <span class="text-blue-600">Laravel Reverb</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-xl mx-auto mb-8">
            A simple project to learn WebSocket implementation and Real-time Broadcasting in Laravel using Reverb.
        </p>

        @guest
            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Login to Try
                </a>
                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
                    Register Account
                </a>
            </div>
        @else
            <a href="{{ route('home') }}" class="inline-block px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                Open Dashboard
            </a>
        @endguest
    </div>

    <div class="mt-16 border-t border-gray-100 pt-12">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest text-center mb-8">Features Learned</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-2">Public Channel</h3>
                <p class="text-sm text-gray-500">Send broadcasts to all users anonymously (Guest). Notifications will appear automatically on this page.</p>
            </div>
            <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-2">Private Channel</h3>
                <p class="text-sm text-gray-500">Send secure messages to specific users based on their Role. Data is stored in the database and sent to the Inbox.</p>
            </div>
        </div>
    </div>

    <div class="mt-12 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-center justify-center gap-3">
        <span class="relative flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
        </span>
        <span class="text-sm font-medium text-blue-700">Reverb Server is listening...</span>
    </div>
</div>
@endsection
