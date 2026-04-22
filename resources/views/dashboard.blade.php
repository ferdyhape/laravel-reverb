<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
        <h1 class="font-bold text-lg">My App</h1>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-xl font-semibold mb-2">Welcome to your Dashboard!</h2>
                <p class="text-gray-600">You are logged in successfully.</p>
            </div>
        </div>
    </main>
</body>

</html>
