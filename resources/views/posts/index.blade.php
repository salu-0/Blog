<x-app-layout>
    <div class="min-h-screen bg-white">
        @if(session('success'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 max-w-7xl mx-auto mt-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Hero Section -->
        <div class="relative bg-white pt-10 pb-0 px-4 sm:px-6 lg:px-8"
            x-data="{ currentSlide: 0, slides: ['blog idea', 'DIY idea', 'recipe idea', 'design idea'], autoSlide: true }"
            x-init="
                if (autoSlide) {
                    setInterval(() => {
                        currentSlide = (currentSlide + 1) % slides.length;
                    }, 3000);
                }
             ">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="mb-4 sm:mb-5 md:mb-6 leading-tight text-center"
                    style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
                    <span class="block font-black tracking-tight get-your-next-text"
                        style="color: #1a1a1a !important; letter-spacing: -0.03em !important; line-height: 1.1 !important; font-weight: 900 !important; display: block !important; margin-bottom: 0.75rem !important;">Get
                        your next</span>
                    <span class="block font-normal tracking-tight mt-2 sm:mt-3 design-idea-text"
                        style="letter-spacing: -0.02em !important; line-height: 1.2 !important;">
                        <span x-show="currentSlide === 0" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            style="color: #d4a574; font-weight: 400; display: block;">blog idea</span>
                        <span x-show="currentSlide === 1" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            style="color: #d4a574; font-weight: 400; display: block;">DIY idea</span>
                        <span x-show="currentSlide === 2" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            style="color: #d4a574; font-weight: 400; display: block;">recipe idea</span>
                        <span x-show="currentSlide === 3" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            style="color: #d4a574; font-weight: 400; display: block;">design idea</span>
                    </span>
                </h1>


                <p
                    class="text-sm sm:text-base md:text-lg lg:text-xl text-gray-600 mb-4 max-w-none mx-auto leading-relaxed text-center">
                    Discover inspiring posts, share your thoughts, and connect with the community
                </p>
                @auth
                    <a href="{{ route('posts.create') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2.5 sm:py-3 md:py-3.5 px-6 sm:px-8 md:px-10 rounded-full transition-all duration-200 text-sm sm:text-base md:text-lg shadow-sm hover:shadow-md touch-manipulation">
                        Create Post
                    </a>
                @endauth
            </div>

        </div>

        <!-- Image Carousel Section -->
        @php
            // Get all images from the images directory
            $carouselImages = [];
            $imageDir = public_path('images');
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (is_dir($imageDir)) {
                try {
                    // Get all files in the directory
                    $files = scandir($imageDir);

                    foreach ($files as $file) {
                        // Skip . and .. directories
                        if ($file === '.' || $file === '..') {
                            continue;
                        }

                        $filePath = $imageDir . DIRECTORY_SEPARATOR . $file;

                        // Check if it's a file and has an allowed extension
                        if (is_file($filePath)) {
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            if (in_array($extension, $allowedExtensions)) {
                                // Use raw filename - Laravel's asset() will handle encoding
                                $carouselImages[] = asset('images/' . $file);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    // Silently fail if directory can't be read
                }
            }
            // Sort to ensure consistent order
            sort($carouselImages);
        @endphp

        @if(count($carouselImages) > 0)
            <script>
                window.carouselImages = @json($carouselImages);
            </script>
            <div class="bg-white pt-0 pb-12" x-data="{
                                                                    images: window.carouselImages || [],
                                                                    scrollContainer: null,
                                                                    hoveredIndex: null,
                                                                    mouseX: 0,
                                                                    mouseY: 0,
                                                                    isPaused: false,
                                                                    currentIndex: 0,
                                                                    itemWidth: 0,
                                                                    gap: 24,
                                                                    autoPlayInterval: null,
                                                                    init() {
                                                                        const self = this;
                                                                        this.scrollContainer = this.$refs.carouselContainer;

                                                                        // Calculate container and item dimensions to show exactly 4 images
                                                                        if (self.images && self.images.length > 0) {
                                                                            this.$nextTick(() => {
                                                                                setTimeout(() => {
                                                                                    const firstItem = self.scrollContainer.querySelector('.carousel-item');
                                                                                    const wrapper = self.$refs.carouselWrapper;
                                                                                    if (firstItem && wrapper) {
                                                                                        // gap-6 = 24px (1.5rem)
                                                                                        self.gap = 24;
                                                                                        self.itemWidth = firstItem.offsetWidth;

                                                                                        // Calculate wrapper width to show exactly 4 images
                                                                                        const wrapperWidth = (self.itemWidth * 4) + (self.gap * 3);
                                                                                        wrapper.style.width = wrapperWidth + 'px';
                                                                                        wrapper.style.margin = '0 auto';
                                                                                        wrapper.style.maxWidth = '100%';

                                                                                        // Start auto-play: scroll to next image every 3 seconds
                                                                                        self.startAutoPlay();
                                                                                    }
                                                                                }, 100);
                                                                            });
                                                                        }

                                                                        // Pause on hover for better UX
                                                                        this.$refs.carouselContainer.addEventListener('mouseenter', () => {
                                                                            this.isPaused = true;
                                                                            this.stopAutoPlay();
                                                                        });

                                                                        this.$refs.carouselContainer.addEventListener('mouseleave', () => {
                                                                            this.isPaused = false;
                                                                            this.startAutoPlay();
                                                                        });

                                                                        // Track mouse position for parallax effect
                                                                        this.$refs.carouselContainer.addEventListener('mousemove', (e) => {
                                                                            this.mouseX = e.clientX;
                                                                            this.mouseY = e.clientY;
                                                                        });
                                                                    },
                                                                    startAutoPlay() {
                                                                        const self = this;
                                                                        // Clear any existing interval
                                                                        if (self.autoPlayInterval) {
                                                                            clearInterval(self.autoPlayInterval);
                                                                        }
                                                                        // Auto-scroll to next image every 3 seconds
                                                                        self.autoPlayInterval = setInterval(() => {
                                                                            if (!self.isPaused && self.images.length > 0) {
                                                                                self.nextImage();
                                                                            }
                                                                        }, 3000);
                                                                    },
                                                                    stopAutoPlay() {
                                                                        if (this.autoPlayInterval) {
                                                                            clearInterval(this.autoPlayInterval);
                                                                            this.autoPlayInterval = null;
                                                                        }
                                                                    },
                                                                    nextImage() {
                                                                        const self = this;
                                                                        self.currentIndex = (self.currentIndex + 1) % self.images.length;

                                                                        // Calculate scroll position
                                                                        const scrollPosition = self.currentIndex * (self.itemWidth + self.gap);

                                                                        // Smooth scroll to next image
                                                                        if (self.scrollContainer) {
                                                                            self.scrollContainer.scrollTo({
                                                                                left: scrollPosition,
                                                                                behavior: 'smooth'
                                                                            });

                                                                            // Handle seamless loop: if we're at the end, reset without animation
                                                                            const firstSetWidth = (self.itemWidth + self.gap) * self.images.length;
                                                                            if (self.currentIndex === 0) {
                                                                                // After smooth scroll, instantly reset for seamless loop
                                                                                setTimeout(() => {
                                                                                    if (self.scrollContainer.scrollLeft >= firstSetWidth - 50) {
                                                                                        self.scrollContainer.scrollLeft = 0;
                                                                                    }
                                                                                }, 500);
                                                                            }
                                                                        }
                                                                    },
                                                                    getParallaxTransform(index) {
                                                                        if (this.hoveredIndex !== index) return '';
                                                                        const rect = this.$refs[`image-${index}`]?.getBoundingClientRect();
                                                                        if (!rect) return '';
                                                                        const centerX = rect.left + rect.width / 2;
                                                                        const centerY = rect.top + rect.height / 2;
                                                                        const deltaX = (this.mouseX - centerX) / 20;
                                                                        const deltaY = (this.mouseY - centerY) / 20;
                                                                        return `translate(${deltaX}px, ${deltaY}px) rotateY(${deltaX / 10}deg) rotateX(${-deltaY / 10}deg)`;
                                                                    }
                                                                 }">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="image-carousel-section">
                    <!-- Advanced Pinterest-Style Horizontal Carousel -->
                    <div class="relative overflow-hidden" x-ref="carouselWrapper">
                        <!-- Carousel Container - Shows exactly 4 images -->
                        <div x-ref="carouselContainer" class="flex gap-6 overflow-x-auto scrollbar-hide pb-4 carousel-3d"
                            style="scrollbar-width: none; -ms-overflow-style: none; perspective: 1000px; overflow-x: auto; overflow-y: hidden; scroll-snap-type: x mandatory;">
                            <!-- First set of images -->
                            <template x-for="(image, index) in images" :key="'first-' + index">
                                <div class="flex-shrink-0 group cursor-pointer carousel-item"
                                    @mouseenter="hoveredIndex = index" @mouseleave="hoveredIndex = null"
                                    :style="`scroll-snap-align: start; ${hoveredIndex === index ? 'transform: scale(1.05); z-index: 10;' : 'transform: scale(1); z-index: 1;'}`">
                                    <div x-ref="`image-${index}`"
                                        class="relative overflow-hidden rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 carousel-image-wrapper flex-shrink-0"
                                        :style="`width: 280px; min-width: 280px; max-width: 280px; height: 400px; min-height: 400px; max-height: 400px; transform: ${getParallaxTransform(index)}; transition: transform 0.3s ease-out;`">

                                        <!-- Main Image with Multiple Effects -->
                                        <img :src="image" :alt="'Carousel image ' + (index + 1)"
                                            class="w-full h-full object-cover transition-all duration-700 carousel-image"
                                            :class="hoveredIndex === index ? 'scale-110 brightness-110' : 'scale-100 brightness-100'"
                                            style="filter: blur(0px); width: 280px; height: 400px; object-fit: cover; object-position: center;"
                                            loading="lazy">

                                        <!-- Animated Gradient Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 carousel-overlay">
                                        </div>

                                        <!-- Shine Effect -->
                                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 carousel-shine"
                                            style="background: linear-gradient(110deg, transparent 40%, rgba(255,255,255,0.3) 50%, transparent 60%); transform: translateX(-100%); animation: shine 1.5s ease-in-out;">
                                        </div>

                                        <!-- Image Number Badge with Animation -->
                                        <div
                                            class="absolute top-3 right-3 bg-white/95 backdrop-blur-md rounded-full px-3 py-1.5 text-xs font-bold text-gray-800 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 shadow-lg carousel-badge">
                                            <span x-text="index + 1"></span> / <span x-text="images.length"></span>
                                        </div>

                                        <!-- Zoom Icon -->
                                        <div
                                            class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-md rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-0 group-hover:scale-100 shadow-lg carousel-zoom-icon">
                                            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                            </svg>
                                        </div>

                                        <!-- Border Glow Effect -->
                                        <div class="absolute inset-0 rounded-xl sm:rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 carousel-glow"
                                            style="box-shadow: 0 0 30px rgba(37, 99, 235, 0.5), inset 0 0 30px rgba(37, 99, 235, 0.2); pointer-events: none;">
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <!-- Duplicate set for seamless infinite loop -->
                            <template x-for="(image, index) in images" :key="'second-' + index">
                                <div class="flex-shrink-0 group cursor-pointer carousel-item"
                                    @mouseenter="hoveredIndex = index" @mouseleave="hoveredIndex = null"
                                    :style="`scroll-snap-align: start; ${hoveredIndex === index ? 'transform: scale(1.05); z-index: 10;' : 'transform: scale(1); z-index: 1;'}`">
                                    <div x-ref="`image-dup-${index}`"
                                        class="relative overflow-hidden rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 carousel-image-wrapper flex-shrink-0"
                                        :style="`width: 280px; min-width: 280px; max-width: 280px; height: 400px; min-height: 400px; max-height: 400px; transform: ${getParallaxTransform(index)}; transition: transform 0.3s ease-out;`">

                                        <!-- Main Image with Multiple Effects -->
                                        <img :src="image" :alt="'Carousel image ' + (index + 1)"
                                            class="w-full h-full object-cover transition-all duration-700 carousel-image"
                                            :class="hoveredIndex === index ? 'scale-110 brightness-110' : 'scale-100 brightness-100'"
                                            style="filter: blur(0px); width: 280px; height: 400px; object-fit: cover; object-position: center;"
                                            loading="lazy">

                                        <!-- Animated Gradient Overlay -->
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 carousel-overlay">
                                        </div>

                                        <!-- Shine Effect -->
                                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 carousel-shine"
                                            style="background: linear-gradient(110deg, transparent 40%, rgba(255,255,255,0.3) 50%, transparent 60%); transform: translateX(-100%); animation: shine 1.5s ease-in-out;">
                                        </div>

                                        <!-- Image Number Badge with Animation -->
                                        <div
                                            class="absolute top-3 right-3 bg-white/95 backdrop-blur-md rounded-full px-3 py-1.5 text-xs font-bold text-gray-800 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 shadow-lg carousel-badge">
                                            <span x-text="index + 1"></span> / <span x-text="images.length"></span>
                                        </div>

                                        <!-- Zoom Icon -->
                                        <div
                                            class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-md rounded-full p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-0 group-hover:scale-100 shadow-lg carousel-zoom-icon">
                                            <svg class="w-5 h-5 text-gray-800" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                            </svg>
                                        </div>

                                        <!-- Border Glow Effect -->
                                        <div class="absolute inset-0 rounded-xl sm:rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 carousel-glow"
                                            style="box-shadow: 0 0 30px rgba(37, 99, 235, 0.5), inset 0 0 30px rgba(37, 99, 235, 0.2); pointer-events: none;">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Placeholder when no images found -->
            <div class="bg-white py-8 sm:py-12 md:py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-gray-100 rounded-2xl p-12 text-center">
                        <p class="text-gray-600 mb-4">No images found in <code
                                class="bg-white px-2 py-1 rounded">public/images/</code> directory</p>
                        <p class="text-sm text-gray-500 mb-2">Images found: {{ count($carouselImages) }}</p>
                        <p class="text-xs text-gray-400">Supported formats: JPG, PNG, GIF, WEBP</p>
                        @if(config('app.debug'))
                            <p class="text-xs text-red-500 mt-4">Debug: Image directory = {{ public_path('images') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif


        <!-- Footer Section -->
        <div class="bg-white border-t border-gray-200 py-8 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div x-data="{ open: false }" class="text-center">
                    <button @click="open = ! open"
                        class="inline-flex items-center space-x-2 text-gray-700 hover:text-gray-900 font-medium transition-colors touch-manipulation focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md px-4 py-2">
                        <span class="text-base sm:text-lg">Here's how it works</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-4"
                        class="mt-6 max-w-3xl mx-auto text-left" style="display: none;">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Create</h3>
                                <p class="text-sm text-gray-600">Share your ideas, thoughts, and inspiration with the
                                    community</p>
                            </div>
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Explore</h3>
                                <p class="text-sm text-gray-600">Discover amazing content from creators around the world
                                </p>
                            </div>
                            <div class="text-center">
                                <div
                                    class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Engage</h3>
                                <p class="text-sm text-gray-600">Connect with others through comments and discussions
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bring Your Ideas to Life Section -->
        <div class="bg-white py-16 sm:py-20 md:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 lg:gap-16 items-center">
                    <!-- Left Side: Text and Button -->
                    <div class="text-center md:text-left">
                        <h3 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                            Search visually with images
                        </h3>
                        <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                            Search for objects within an image to find more styles you'll love
                        </p>
                        <a href="{{ route('posts.index') }}"
                            class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-10 py-4 rounded-xl text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Learn more
                        </a>
                    </div>

                    <!-- Right Side: Card-style Image -->
                    <div class="flex justify-center md:justify-end">
                        <div class="w-full max-w-sm">
                            <div
                                class="bg-gradient-to-br from-gray-50 via-gray-100 to-gray-50 rounded-3xl p-6 sm:p-8 shadow-2xl">
                                <div class="relative w-full">
                                    <!-- Main Image Card -->
                                    <div class="rounded-2xl overflow-hidden shadow-xl bg-white relative"
                                        style="width: 100%; padding-bottom: 133.33%; position: relative;">
                                        <img src="{{ asset('images/Inclusivity Ad.jpg') }}"
                                            alt="Search visually with images"
                                            class="absolute inset-0 w-full h-full object-cover"
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: block;">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Collaborate with Group Boards Section -->
        <div class="bg-[#FFE2EB] py-16 sm:py-20 md:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">

                    <!-- Left Side: Graphic Card -->
                    <div class="flex justify-center md:justify-start">
                        <div class="relative w-full max-w-sm">
                            <!-- Main Card -->
                            <div
                                class="bg-white rounded-[32px] p-4 shadow-xl relative z-10 transform rotate-1 hover:rotate-0 transition-transform duration-500">
                                <!-- Image Grid -->
                                <!-- Single Main Image -->
                                <div class="mb-4 h-64 rounded-2xl overflow-hidden shadow-sm">
                                    <img src="{{ isset($carouselImages[0]) ? $carouselImages[0] : asset('images/Inclusivity Ad.jpg') }}"
                                        class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700">
                                </div>

                                <!-- Card Info -->
                                <div class="px-2 flex items-center justify-between">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">Earthy space inspo</h4>
                                        <p class="text-sm text-gray-500">80 Pins</p>
                                    </div>
                                    <!-- Avatars -->
                                    <div class="flex -space-x-4">
                                        <div
                                            class="w-10 h-10 rounded-full border-2 border-white overflow-hidden bg-gray-200">
                                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="User"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div
                                            class="w-10 h-10 rounded-full border-2 border-white overflow-hidden bg-gray-300">
                                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Aneka" alt="User"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <div
                                            class="w-10 h-10 rounded-full border-2 border-white overflow-hidden bg-gray-400">
                                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Zoe" alt="User"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Text -->
                    <div class="text-center md:text-left">
                        <h2 class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#4B0014] mb-6 leading-tight">
                            Collaborate with group boards
                        </h2>
                        <p class="text-xl text-[#8E3B4E] mb-10 leading-relaxed max-w-lg mx-auto md:mx-0">
                            Visualise your ideas with others using a Freshwave account
                        </p>
                        <a href="{{ route('posts.index') }}"
                            class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-full text-lg transition-all shadow-sm active:scale-95 whitespace-nowrap">
                            See an example
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign up to get your ideas Section -->
    <div class="relative w-full overflow-hidden bg-gray-900 min-h-[700px]">
        <!-- Background Collage -->
        <div class="absolute inset-0 z-0 opacity-40 top-[-100px] left-[-50px] right-[-50px]">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 transform -rotate-2 scale-105">
                <!-- Loop through images multiple times to fill the grid -->
                @for ($i = 0; $i < 4; $i++)
                    @foreach($carouselImages as $index => $image)
                        <div class="overflow-hidden rounded-2xl aspect-[2/3]">
                            <img src="{{ $image }}"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-700"
                                loading="lazy">
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-black/60 z-0"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/40 z-0"></div>

        <!-- Content -->
        <div
            class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col lg:flex-row items-center justify-center lg:justify-between gap-8 sm:gap-12">
            <!-- Left Text -->
            <div class="text-center lg:text-left max-w-3xl pt-12 lg:pt-0">
                <h2
                    class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold text-white leading-tight mb-4 tracking-tight">
                    Sign up to get<br>your ideas
                </h2>
            </div>

            <!-- Right Form Card -->
            <div
                class="relative bg-white rounded-[32px] p-8 w-full max-w-[480px] shadow-2xl mx-auto lg:mr-0 transform transition-transform hover:scale-[1.01] duration-300">
                <div class="text-center mb-8">
                    <!-- Logo Placeholder -->
                    <div class="w-10 h-10 bg-blue-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0a12 12 0 0 0-4.37 23.17c-.07-.63-.13-1.6.03-2.3 1.15-4.88 2.45-8.54 2.45-8.54s-.6-.89-.6-2.2c0-2.06 1.2-3.6 2.7-3.6 1.27 0 1.88.95 1.88 2.09 0 1.27-.8 3.17-1.2 4.93-.34 1.47.74 2.67 2.2 2.67 2.64 0 4.67-2.78 4.67-6.8 0-3.55-2.55-6.03-6.2-6.03-4.52 0-7.17 3.39-7.17 6.9 0 1.36.52 2.82 1.17 3.61.13.16.15.3.11.46l-.43 1.78c-.07.28-.23.34-.53.2-1.97-.91-3.2-3.78-3.2-6.1 0-4.96 3.6-9.5 10.38-9.5 5.45 0 9.68 3.89 9.68 9.07 0 5.42-3.41 9.77-8.15 9.77-1.59 0-3.09-.83-3.6-1.8l-1 3.8c-.35 1.35-1.29 3.04-1.92 4.06A11.97 11.97 0 0 0 12 24c6.63 0 12-5.37 12-12S18.63 0 12 0z" />
                        </svg>
                    </div>
                    <h3 class="text-3xl font-semibold text-gray-900 mb-2 mt-2">Welcome to Freshwave</h3>
                    <p class="text-gray-600">Find new ideas to try</p>
                </div>

                <form class="space-y-3" onsubmit="event.preventDefault();">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">Email address</label>
                        <input type="email" placeholder="Email address"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-gray-500 focus:ring-0 transition-all placeholder:text-gray-400 hover:border-gray-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">Password</label>
                        <input type="password" placeholder="Create a password"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-gray-500 focus:ring-0 transition-all placeholder:text-gray-400 hover:border-gray-400">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 ml-1">Date of birth</label>
                        <input type="date"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-gray-500 focus:ring-0 transition-all text-gray-500 hover:border-gray-400">
                    </div>

                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-bold py-3.5 rounded-full transition-all mt-3 text-base shadow-sm">
                        Continue
                    </button>

                    <div class="relative flex items-center gap-2 py-3">
                        <div class="h-px bg-gray-200 flex-1"></div>
                        <span class="text-xs font-bold text-gray-900">OR</span>
                        <div class="h-px bg-gray-200 flex-1"></div>
                    </div>

                    <button
                        class="w-full bg-white border border-gray-300 hover:bg-gray-50 active:bg-gray-100 text-gray-900 font-bold py-3 rounded-full transition-all flex items-center justify-center gap-3 relative">
                        <!-- Google Icon -->
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
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
                        Continue as User
                    </button>

                    <p class="text-[11px] text-center text-gray-500 mt-5 leading-tight px-4">
                        By continuing, you agree to Freshwave's <a href="#"
                            class="font-bold text-gray-900 hover:underline">Terms of Service</a> and acknowledge
                        you've read our <a href="#" class="font-bold text-gray-900 hover:underline">Privacy
                            Policy</a>.
                    </p>
                </form>

                <div
                    class="mt-4 pt-4 border-t border-gray-100 text-center bg-gray-50 -mx-8 -mb-8 pb-4 rounded-b-[32px]">
                    <a href="#" class="text-sm font-bold text-gray-900 hover:underline">Already a member? Log in</a>
                </div>
            </div>
        </div>



    </div>

    <style>
        /* Prevent flash of unstyled content for Alpine.js */
        [x-cloak] {
            display: none !important;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        .get-your-next-text {
            font-size: 2.5rem !important;
            /* 40px */
        }

        @media (min-width: 640px) {
            .get-your-next-text {
                font-size: 3rem !important;
                /* 48px */
            }
        }

        @media (min-width: 768px) {
            .get-your-next-text {
                font-size: 4rem !important;
                /* 64px */
            }
        }

        @media (min-width: 1024px) {
            .get-your-next-text {
                font-size: 5.5rem !important;
                /* 88px */
            }
        }

        @media (min-width: 1280px) {
            .get-your-next-text {
                font-size: 7rem !important;
                /* 112px */
            }
        }

        /* Font sizes for "design idea" */
        .design-idea-text {
            font-size: 1.5rem !important;
            /* 24px */
        }

        @media (min-width: 640px) {
            .design-idea-text {
                font-size: 2rem !important;
                /* 32px */
            }
        }

        @media (min-width: 768px) {
            .design-idea-text {
                font-size: 2.5rem !important;
                /* 40px */
            }
        }

        @media (min-width: 1024px) {
            .design-idea-text {
                font-size: 3rem !important;
                /* 48px */
            }
        }

        @media (min-width: 1280px) {
            .design-idea-text {
                font-size: 4rem !important;
                /* 64px */
            }
        }

        /* Hide scrollbar for carousel */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Advanced Carousel Effects */
        .carousel-3d {
            transform-style: preserve-3d;
        }

        .carousel-item {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), z-index 0.3s;
        }

        .carousel-image-wrapper {
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }

        .carousel-image {
            will-change: transform, filter;
            backface-visibility: hidden;
        }

        /* Shine Animation */
        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(200%) translateY(200%) rotate(45deg);
            }
        }

        .carousel-shine {
            animation: shine 1.5s ease-in-out;
        }

        /* Glow Pulse Effect */
        @keyframes glow-pulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(37, 99, 235, 0.4), inset 0 0 20px rgba(37, 99, 235, 0.1);
            }

            50% {
                box-shadow: 0 0 40px rgba(37, 99, 235, 0.6), inset 0 0 40px rgba(37, 99, 235, 0.3);
            }
        }

        .carousel-item:hover .carousel-glow {
            animation: glow-pulse 2s ease-in-out infinite;
        }

        /* Fade In Animation for Images */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .carousel-image-wrapper {
            animation: fadeInScale 0.6s ease-out;
        }

        /* Smooth Hover Transitions */
        .carousel-image-wrapper:hover {
            transform: translateY(-5px) scale(1.02);
        }

        /* Navigation Button Hover Effects */
        .carousel-nav-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .carousel-nav-btn:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Badge Animation */
        .carousel-badge {
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Zoom Icon Animation */
        .carousel-zoom-icon {
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Parallax Effect Enhancement */
        .carousel-item:hover .carousel-image-wrapper {
            transition: transform 0.1s ease-out;
        }

        /* Smooth Scroll Snap */
        .carousel-3d {
            scroll-snap-type: x proximity;
        }

        .carousel-item {
            scroll-snap-align: center;
        }

        /* Custom styles for Pinterest-style layout */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth column breaks */
        .break-inside-avoid {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        /* Prevent flash of unstyled content for Alpine.js */
        [x-cloak] {
            display: none !important;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Better touch targets for mobile */
        @media (max-width: 1023px) {
            .touch-manipulation {
                touch-action: manipulation;
                -webkit-tap-highlight-color: transparent;
            }
        }

        /* Responsive text sizing for extra small screens */
        @media (min-width: 475px) {
            .xs\:columns-1 {
                columns: 1;
            }
        }

        /* Optimize grid for different screen sizes */
        @media (min-width: 1280px) {
            .xl\:columns-5 {
                columns: 5;
            }
        }

        /* Improve card hover on desktop */
        @media (hover: hover) {
            .group:hover .group-hover\:text-blue-600 {
                color: #2563eb;
            }
        }
    </style>
</x-app-layout>