<!-- Collaborate with Group Boards Section -->
<div class="bg-[#f0f0f0] py-16 sm:py-20 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">

            <!-- Left Side: Text -->
            <div class="text-center md:text-left order-2 md:order-1">
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Collaborate with group boards
                </h2>
                <p class="text-xl text-gray-600 mb-10 leading-relaxed max-w-lg mx-auto md:mx-0">
                    Visualise your ideas with others using a Freshwave account
                </p>
                <a href="{{ route('posts.index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-full text-lg transition-all shadow-sm active:scale-95">
                    See an example
                </a>
            </div>

            <!-- Right Side: Graphic Card -->
            <div class="flex justify-center md:justify-end order-1 md:order-2">
                <div class="relative w-full max-w-md">
                    <!-- Background Shape -->

                    <!-- Main Card -->
                    <div
                        class="bg-white rounded-[32px] p-4 shadow-xl relative z-10 transform rotate-1 hover:rotate-0 transition-transform duration-500">
                        <!-- Image Grid -->
                        <div class="grid grid-cols-2 gap-2 mb-4 h-64">
                            <!-- Large Left Image -->
                            <div class="rounded-2xl overflow-hidden h-full">
                                <img src="{{ isset($carouselImages[0]) ? $carouselImages[0] : asset('images/Inclusivity Ad.jpg') }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <!-- Right Column Images -->
                            <div class="flex flex-col gap-2 h-full">
                                <div class="rounded-2xl overflow-hidden h-1/2">
                                    <img src="{{ isset($carouselImages[1]) ? $carouselImages[1] : asset('images/Inclusivity Ad.jpg') }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="rounded-2xl overflow-hidden h-1/2">
                                    <img src="{{ isset($carouselImages[2]) ? $carouselImages[2] : asset('images/Inclusivity Ad.jpg') }}"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>

                        <!-- Card Info -->
                        <div class="px-2 flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Earthy space inspo</h4>
                                <p class="text-sm text-gray-500">80 Pins</p>
                            </div>
                            <!-- Avatars -->
                            <div class="flex -space-x-4">
                                <div class="w-10 h-10 rounded-full border-2 border-white overflow-hidden bg-gray-200">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="User"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="w-10 h-10 rounded-full border-2 border-white overflow-hidden bg-gray-300">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aneka" alt="User"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="w-10 h-10 rounded-full border-2 border-white overflow-hidden bg-gray-400">
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Zoe" alt="User"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>