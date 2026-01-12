@php
    // Get all images from the images directory for the background collage
    $carouselImages = [];
    $imageDir = public_path('images');
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (is_dir($imageDir)) {
        try {
            $files = scandir($imageDir);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..')
                    continue;
                $filePath = $imageDir . DIRECTORY_SEPARATOR . $file;
                if (is_file($filePath)) {
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (in_array($extension, $allowedExtensions)) {
                        $carouselImages[] = asset('images/' . $file);
                    }
                }
            }
        } catch (\Exception $e) {
        }
    }
    sort($carouselImages);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-black overflow-hidden relative h-screen w-screen">

    <!-- Background Collage -->
    <div class="absolute inset-0 z-0 opacity-40 top-[-100px] left-[-50px] right-[-50px] bottom-[-100px]">
        <div
            class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 transform -rotate-2 scale-105 h-full overflow-hidden">
            @for ($i = 0; $i < 4; $i++)
                @foreach($carouselImages as $index => $image)
                    <div class="overflow-hidden rounded-2xl aspect-[2/3]">
                        <img src="{{ $image }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                @endforeach
            @endfor
        </div>
    </div>

    <!-- Dark Gradient Overlay -->
    <div class="absolute inset-0 bg-black/60 z-0"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/40 z-0"></div>

    <!-- Main Container -->
    <div class="relative z-10 w-full h-full flex items-center justify-center p-4">

        <!-- Login Modal Card -->
        <div
            class="bg-white rounded-[32px] w-full max-w-[480px] shadow-2xl overflow-hidden flex flex-col min-h-[550px]">

            <!-- Close Button (Mock) -->
            <a href="/" class="absolute top-4 right-4 md:top-6 md:right-6 z-50 text-white/80 hover:text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </a>

            <!-- Login Form -->
            <div class="w-full p-8 md:p-10 flex flex-col justify-center relative">
                <div class="text-center mb-6">
                    <div class="w-10 h-10 bg-blue-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0a12 12 0 0 0-4.37 23.17c-.07-.63-.13-1.6.03-2.3 1.15-4.88 2.45-8.54 2.45-8.54s-.6-.89-.6-2.2c0-2.06 1.2-3.6 2.7-3.6 1.27 0 1.88.95 1.88 2.09 0 1.27-.8 3.17-1.2 4.93-.34 1.47.74 2.67 2.2 2.67 2.64 0 4.67-2.78 4.67-6.8 0-3.55-2.55-6.03-6.2-6.03-4.52 0-7.17 3.39-7.17 6.9 0 1.36.52 2.82 1.17 3.61.13.16.15.3.11.46l-.43 1.78c-.07.28-.23.34-.53.2-1.97-.91-3.2-3.78-3.2-6.1 0-4.96 3.6-9.5 10.38-9.5 5.45 0 9.68 3.89 9.68 9.07 0 5.42-3.41 9.77-8.15 9.77-1.59 0-3.09-.83-3.6-1.8l-1 3.8c-.35 1.35-1.29 3.04-1.92 4.06A11.97 11.97 0 0 0 12 24c6.63 0 12-5.37 12-12S18.63 0 12 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Welcome to Freshwave</h1>
                    <p class="text-sm text-gray-600">Find new ideas to try</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">Name</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus
                            placeholder="Full name"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-gray-400 hover:border-gray-400">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">Email address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required placeholder="Email"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-gray-400 hover:border-gray-400">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="Create a password"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-gray-400 hover:border-gray-400">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            placeholder="Confirm password"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-gray-400 hover:border-gray-400">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-bold py-3 rounded-full transition-all text-base shadow-sm mt-2">
                        Continue
                    </button>

                    <div class="relative flex items-center gap-2 py-2">
                        <span class="text-xs font-semibold text-gray-900 mx-auto">OR</span>
                    </div>

                    <a href="{{ route('google.login') }}"
                        class="w-full bg-white border border-gray-300 hover:bg-gray-50 active:bg-gray-100 text-gray-900 font-bold py-2.5 rounded-full transition-all flex items-center justify-center gap-3 relative">
                        <!-- Google Icon -->
                        <div class="w-5 h-5 flex-shrink-0">
                            <svg class="w-full h-full" viewBox="0 0 24 24">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                        </div>
                        <span class="truncate">Continue as User</span>
                    </a>

                    <div class="text-[10px] text-center text-gray-500 leading-tight pt-2">
                        By continuing, you agree to Freshwave's <a href="#"
                            class="font-bold text-gray-900 hover:underline">Terms of Service</a> and acknowledge that
                        you've read our <a href="#" class="font-bold text-gray-900 hover:underline">Privacy Policy</a>.
                    </div>
                </form>
            </div>
        </div>

        <!-- Bottom Link (Absolute, similar to footer) -->
        <div class="fixed bottom-0 w-full z-20 bg-black/80 backdrop-blur-sm text-center py-3">
            <a href="{{ route('login') }}" class="text-white font-bold text-sm tracking-wide hover:underline">Already
                a member? Log in</a>
        </div>
    </div>

</body>

</html>