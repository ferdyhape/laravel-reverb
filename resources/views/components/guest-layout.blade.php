<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center p-4">
            <div class="w-full max-w-sm">
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
