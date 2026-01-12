<x-app-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-lg">
            <!-- Modal Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="px-6 py-5 border-b border-gray-100">
                    <h1 class="text-2xl font-bold text-gray-900">Create</h1>
                </div>

                <!-- Options -->
                <div class="p-4 space-y-3">
                    <!-- Pin Option (Selected by default) -->
                    <button type="button" onclick="window.location.href='{{ route('posts.create.pin') }}'"
                        class="w-full flex items-start gap-4 p-4 rounded-2xl border-2 border-blue-600 bg-blue-50 hover:bg-blue-100 transition-all group">
                        <div class="p-3 bg-white rounded-xl shadow-sm flex-shrink-0">
                            <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">Pin</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Post your photos or videos and add links,
                                stickers, effects and more</p>
                        </div>
                    </button>

                    <!-- Board Option -->
                    <button type="button"
                        class="w-full flex items-start gap-4 p-4 rounded-2xl border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all group">
                        <div class="p-3 bg-gray-100 rounded-xl flex-shrink-0">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">Board</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Organize a collection of your favorite Pins
                                by creating a board</p>
                        </div>
                    </button>

                    <!-- Collage Option -->
                    <button type="button"
                        class="w-full flex items-start gap-4 p-4 rounded-2xl border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all group">
                        <div class="p-3 bg-gray-100 rounded-xl flex-shrink-0">
                            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">Collage</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Mix and match ideas to build your vision
                                and create something new</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>