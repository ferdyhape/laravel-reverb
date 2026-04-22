<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-semibold">Register</h1>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-black">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-black">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-black">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-black">
        </div>

        <button type="submit" class="w-full bg-black text-white py-2 rounded-md hover:bg-gray-800 transition">
            Register
        </button>
    </form>

    <div class="mt-6 text-center text-sm">
        Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
    </div>
</x-guest-layout>
