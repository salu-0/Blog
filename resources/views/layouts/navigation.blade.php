<nav x-data="{ open: false }" @keydown.escape.window="open = false"
    class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <!-- Desktop Navigation (lg and above) -->
    <div class="hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 lg:h-16">
                <!-- Left Side: Logo, Explore, and Navigation Links -->
                <!-- Left Side: Logo, Explore/Home, and Search -->
                <!-- Left Side: Logo, Explore/Home, and Search -->
                <div class="flex items-center gap-6 flex-1">
                    @auth
                        <!-- Auth Nav: Search Bar Only (Logo/Nav is in Sidebar) -->
                        <div class="flex-1 max-w-4xl">
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-500 group-focus-within:text-gray-900" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text"
                                    class="block w-full pl-10 pr-3 py-2.5 border-none leading-5 bg-gray-100 text-gray-900 placeholder-gray-500 focus:outline-none focus:bg-gray-200 focus:ring-0 rounded-full sm:text-sm transition-colors"
                                    placeholder="Search">
                            </div>
                        </div>
                    @else
                        <!-- Guest Nav: Logo + Explore + Links -->
                        <!-- Logo -->
                        <a href="{{ route('posts.index') }}"
                            class="flex items-center space-x-2 hover:opacity-90 transition-opacity flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-lg">F</span>
                            </div>
                            <span class="text-blue-600 font-bold text-xl hidden md:block">Freshwave</span>
                            <!-- Hidden text on mobile/small desktop if needed -->
                        </a>

                        <!-- Explore -->
                        <a href="{{ route('posts.index') }}"
                            class="text-black font-bold text-base lg:text-lg hover:opacity-80 transition-opacity">
                            Explore
                        </a>

                        <!-- Navigation Links -->
                        <div class="hidden xl:flex items-center space-x-6">
                            <a href="#"
                                class="text-black hover:text-gray-700 font-medium text-sm lg:text-base transition-colors">About</a>
                            <a href="#"
                                class="text-black hover:text-gray-700 font-medium text-sm lg:text-base transition-colors">Businesses</a>
                            <a href="#"
                                class="text-black hover:text-gray-700 font-medium text-sm lg:text-base transition-colors">News</a>
                        </div>
                    @endauth
                </div>

                <!-- Right Side: Auth Buttons or User Menu -->
                <div class="flex items-center space-x-3 flex-shrink-0">
                    @auth
                        <!-- User Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 xl:px-4 py-1.5 xl:py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-semibold text-gray-900 transition-colors">
                                    <div
                                        class="w-7 h-7 lg:w-8 lg:h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mr-2 flex-shrink-0">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden xl:inline">{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 xl:ml-2 h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('posts.create')">
                                    {{ __('Create Post') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.index')">
                                    {{ __('Admin Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <!-- Log in Button (Blue background, white text) -->
                        <a href="{{ route('login') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm lg:text-base">
                            Log in
                        </a>
                        <!-- Sign up Button (Gray background, black text) -->
                        <a href="{{ route('register') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-900 font-semibold py-2 px-4 rounded-lg transition-colors text-sm lg:text-base">
                            Sign up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile/Tablet Navigation (below lg) -->
    <div class="block lg:hidden">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6">
            <div class="flex justify-between items-center h-14 sm:h-16">
                <!-- Logo and Explore -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center space-x-2 hover:opacity-90 transition-opacity flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">F</span>
                        </div>
                        <span class="text-blue-600 font-bold text-base sm:text-lg md:text-xl">Freshwave</span>
                    </a>
                    <a href="{{ route('posts.index') }}"
                        class="text-black font-bold text-base sm:text-lg hover:opacity-80 transition-opacity hidden sm:block">
                        Explore
                    </a>
                </div>

                <!-- Hamburger Menu Button -->
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition duration-150 ease-in-out touch-manipulation"
                    aria-label="Toggle menu" aria-expanded="false" :aria-expanded="open">
                    <svg class="h-6 w-6 sm:h-7 sm:w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 bg-black bg-opacity-50 z-40"
            style="display: none;">
        </div>

        <!-- Mobile Menu Sidebar -->
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-72 sm:w-80 bg-white shadow-2xl z-50 overflow-y-auto overscroll-contain"
            style="display: none;">

            <!-- Mobile Menu Header -->
            <div
                class="flex items-center justify-between px-4 py-4 border-b border-gray-200 sticky top-0 bg-white z-10">
                <a href="{{ route('posts.index') }}" class="flex items-center space-x-2" @click="open = false">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">F</span>
                    </div>
                    <span class="text-blue-600 font-bold text-xl">Freshwave</span>
                </a>
                <button @click="open = false"
                    class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 touch-manipulation"
                    aria-label="Close menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Content -->
            <div class="px-4 py-6">
                <!-- Navigation Links -->
                <div class="space-y-1 mb-6">
                    <a href="{{ route('posts.index') }}" @click="open = false"
                        class="block px-3 py-3 text-gray-900 font-medium hover:bg-gray-50 active:bg-gray-100 rounded-md transition-colors touch-manipulation text-base">
                        Explore
                    </a>
                    <a href="#" @click="open = false"
                        class="block px-3 py-3 text-gray-900 font-medium hover:bg-gray-50 active:bg-gray-100 rounded-md transition-colors touch-manipulation text-base">
                        About
                    </a>
                    <a href="#" @click="open = false"
                        class="block px-3 py-3 text-gray-900 font-medium hover:bg-gray-50 active:bg-gray-100 rounded-md transition-colors touch-manipulation text-base">
                        Businesses
                    </a>
                    @auth
                        <a href="{{ route('posts.create') }}" @click="open = false"
                            class="block px-3 py-3 text-gray-900 font-medium hover:bg-gray-50 active:bg-gray-100 rounded-md transition-colors touch-manipulation text-base">
                            Create
                        </a>
                    @endauth
                    <a href="#" @click="open = false"
                        class="block px-3 py-3 text-gray-900 font-medium hover:bg-gray-50 active:bg-gray-100 rounded-md transition-colors touch-manipulation text-base">
                        News
                    </a>
                </div>

                <!-- Auth Section -->
                @auth
                    <!-- User Info -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3 mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold flex-shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-medium text-base text-gray-900 truncate">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- User Actions -->
                    <div class="space-y-2">
                        <a href="{{ route('posts.create') }}" @click="open = false"
                            class="block w-full text-center bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3 px-4 rounded-full transition-colors touch-manipulation text-base">
                            Create Post
                        </a>
                        <a href="{{ route('admin.index') }}" @click="open = false"
                            class="block w-full text-center bg-gray-200 hover:bg-gray-300 active:bg-gray-400 text-gray-900 font-semibold py-3 px-4 rounded-full transition-colors touch-manipulation text-base">
                            Admin Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" @click="open = false"
                            class="block w-full text-center text-gray-700 font-medium py-3 hover:bg-gray-50 active:bg-gray-100 rounded-md transition-colors touch-manipulation text-base">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" @click="open = false"
                                class="block w-full text-center text-gray-700 font-medium py-3 hover:bg-gray-50 active:bg-gray-100 rounded-md transition-colors touch-manipulation text-base">
                                Log Out
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest Actions -->
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" @click="open = false"
                            class="block w-full text-center bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors touch-manipulation text-base">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" @click="open = false"
                            class="block w-full text-center bg-gray-200 hover:bg-gray-300 active:bg-gray-400 text-gray-900 font-semibold py-3 px-4 rounded-lg transition-colors touch-manipulation text-base">
                            Sign up
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    /* Prevent flash of unstyled content for Alpine.js */
    [x-cloak] {
        display: none !important;
    }

    /* Ensure mobile nav is completely hidden on desktop */
    @media (min-width: 1024px) {
        .lg\:hidden {
            display: none !important;
        }
    }

    /* Better touch targets for mobile */
    @media (max-width: 1023px) {
        .touch-manipulation {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }
    }
</style>