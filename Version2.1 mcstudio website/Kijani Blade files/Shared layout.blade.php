{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'modus chora studio')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        {{-- Top nav --}}
        <header class="border-b bg-white/90 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-8">
                    <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight text-blue-900">
                        modus chora studio
                    </a>
                    <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-700">
                        <a href="{{ route('legal.healthcheck.landing') }}" class="hover:text-blue-600">Legal Health Check</a>
                        <a href="{{ route('partners.index') }}" class="hover:text-blue-600">Partners</a>
                        <a href="{{ route('services.index') }}" class="hover:text-blue-600">Services</a>
                        <a href="{{ route('faq') }}" class="hover:text-blue-600">FAQ</a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    @yield('primary-cta')
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="border-t bg-gray-900 text-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="grid gap-8 md:grid-cols-4">
                    <div>
                        <div class="font-semibold text-white mb-2">modus chora studio</div>
                        <p class="text-sm text-gray-400">
                            Your partner in legal clarity and business growth.
                        </p>
                    </div>

                    <div class="text-sm space-y-1">
                        <div class="font-semibold text-white mb-2">Company</div>
                        <a href="#" class="block text-gray-400 hover:text-white">About Us</a>
                        <a href="#" class="block text-gray-400 hover:text-white">Contact</a>
                        <a href="#" class="block text-gray-400 hover:text-white">Careers</a>
                    </div>

                    <div class="text-sm space-y-1">
                        <div class="font-semibold text-white mb-2">Legal & Services</div>
                        <a href="{{ route('legal.healthcheck.landing') }}" class="block text-gray-400 hover:text-white">Legal Health Check</a>
                        <a href="{{ route('partners.index') }}" class="block text-gray-400 hover:text-white">Partners</a>
                        <a href="{{ route('services.index') }}" class="block text-gray-400 hover:text-white">Services</a>
                        <a href="#" class="block text-gray-400 hover:text-white">Privacy Policy</a>
                        <a href="#" class="block text-gray-400 hover:text-white">Terms of Service</a>
                    </div>

                    <div class="flex items-end md:items-center">
                        <p class="text-xs text-gray-500">
                            © 2026 Modus Chora Studio x OW Advocates. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>