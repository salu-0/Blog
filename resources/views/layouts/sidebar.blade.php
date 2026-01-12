<div
    class="fixed left-0 top-0 h-full w-20 bg-white border-r border-gray-200 z-[60] flex flex-col items-center py-6 pb-4">
    <!-- Logo -->
    <a href="{{ route('posts.index') }}"
        class="mb-8 p-3 hover:bg-gray-100 rounded-full transition-colors flex-shrink-0">
        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
            <span class="text-white font-bold text-lg">F</span>
        </div>
    </a>

    <!-- Nav Icons -->
    <div class="flex-1 flex flex-col gap-6 w-full items-center overflow-y-auto no-scrollbar">
        <!-- Home -->
        <a href="{{ route('posts.index') }}"
            class="p-3 {{ request()->routeIs('posts.index') ? 'bg-black text-white' : 'text-gray-900 hover:bg-gray-100' }} rounded-xl transition-all group relative">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.09l-10 9.27L3.45 13 12 5.09 20.55 13l1.45-1.64-10-9.27zM6 10v9h12v-9H6z" />
            </svg>
            <span
                class="absolute left-14 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">Home</span>
        </a>

        <!-- Explore (Compass) -->
        <a href="#" class="p-3 text-gray-900 hover:bg-gray-100 rounded-xl transition-all group relative">
            <div class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                </svg>
                <!-- Red Dot Notification Mock -->
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full border-2 border-white"></span>
            </div>
            <span
                class="absolute left-14 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">Explore</span>
        </a>

        <!-- Create (Plus) - Dropdown -->
        <div x-data="{ open: false }" class="relative group w-full flex justify-center">
            <button @click="open = !open"
                class="p-3 text-gray-900 hover:bg-gray-100 rounded-xl transition-all relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span
                    class="absolute left-14 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">Create</span>

                <!-- Active Indicator -->
                <div x-show="open" class="absolute -right-3 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-black rounded-full">
                </div>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="fixed left-24 bg-white rounded-2xl shadow-2xl border border-gray-200 w-[400px] z-[70] overflow-hidden"
                style="top: 50%; transform: translateY(-50%);">

                <p class="text-xs font-semibold text-gray-500 px-4 py-3 border-b border-gray-100">Create</p>

                <!-- Pin Option -->
                <a href="{{ route('posts.create') }}"
                    class="flex items-start gap-4 px-4 py-4 hover:bg-gray-50 transition-colors border-b border-gray-100">
                    <div class="p-3 bg-gray-100 rounded-xl flex-shrink-0">
                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 text-base mb-1">Pin</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Post your photos or videos and add links,
                            stickers, effects and more</p>
                    </div>
                </a>

                <!-- Board Option -->
                <a href="#"
                    class="flex items-start gap-4 px-4 py-4 hover:bg-gray-50 transition-colors border-b border-gray-100">
                    <div class="p-3 bg-gray-100 rounded-xl flex-shrink-0">
                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 text-base mb-1">Board</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Organize a collection of your favorite Pins
                            by creating a board</p>
                    </div>
                </a>

                <!-- Collage Option -->
                <a href="#" class="flex items-start gap-4 px-4 py-4 hover:bg-gray-50 transition-colors">
                    <div class="p-3 bg-gray-100 rounded-xl flex-shrink-0">
                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 text-base mb-1">Collage</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Mix and match ideas to build your vision
                            and create something new</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Notifications (Bell) -->
        <a href="#" class="p-3 text-gray-900 hover:bg-gray-100 rounded-xl transition-all group relative">
            <div class="relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-0 right-0.5 w-2.5 h-2.5 bg-red-600 rounded-full border-2 border-white"></span>
            </div>
            <span
                class="absolute left-14 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">Updates</span>
        </a>

        <!-- Messages (Bubble) -->
        <a href="#" class="p-3 text-gray-900 hover:bg-gray-100 rounded-xl transition-all group relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span
                class="absolute left-14 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">Messages</span>
        </a>
    </div>

    <!-- Bottom Settings -->
    <a href="{{ route('profile.edit') }}"
        class="p-3 text-gray-900 hover:bg-gray-100 rounded-xl transition-all group relative mt-auto">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span
            class="absolute left-14 bg-black text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none">Settings</span>
    </a>
</div>