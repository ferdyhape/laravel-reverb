<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-semibold">Sign In</h1>
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-black">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-black">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between mb-4">
            <label class="flex items-center text-sm">
                <input type="checkbox" name="remember" class="mr-2"> Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="w-full bg-black text-white py-2 rounded-md hover:bg-gray-800 transition">
            Login
        </button>
    </form>

    <div class="mt-6 text-center text-sm">
        Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
    </div>
</x-guest-layout>
