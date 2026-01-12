<x-app-layout>
    <div class="min-h-screen bg-white">
        <!-- Main Container -->
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header section -->
            <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-6">
                <h1 class="text-2xl font-bold text-gray-900">Create Pin</h1>
                <div class="flex items-center gap-4">
                    <button form="create-pin-form" type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-all scale-100 active:scale-95 shadow-md">
                        Publish
                    </button>
                </div>
            </div>

            <form id="create-pin-form" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"
                class="flex flex-col lg:flex-row gap-12 bg-white p-2">
                @csrf

                <!-- Left Column: Media Upload -->
                <div class="w-full lg:w-[450px] flex flex-col gap-4">
                    <div id="drop-zone"
                        class="relative aspect-[3/4] rounded-[32px] bg-[#E9E9E9] hover:bg-[#E2E2E2] transition-colors flex flex-col items-center justify-center p-12 text-center cursor-pointer border-2 border-dashed border-transparent hover:border-gray-300 group overflow-hidden">

                        <input type="file" name="media" id="media-input"
                            class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*,video/*" required>

                        <!-- Static View -->
                        <div id="upload-static" class="flex flex-col items-center">
                            <div
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-6 shadow-sm">
                                <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v4a2 2 0 002 2h12a2 2 0 002-2v-4M17 8l-5-5-5 5M12 3v12" />
                                </svg>
                            </div>
                            <p class="text-gray-900 font-bold text-lg mb-4">Choose a file or drag and drop it here</p>
                            <p class="text-gray-600 text-sm leading-relaxed max-w-[280px]">
                                We recommend using high quality .jpg files less than 20 MB or .mp4 files less than 200
                                MB.
                            </p>
                        </div>

                        <!-- Preview View -->
                        <div id="upload-preview"
                            class="hidden absolute inset-0 bg-white z-10 flex items-center justify-center">
                            <img id="preview-image" src="" class="hidden w-full h-full object-contain">
                            <video id="preview-video" src="" class="hidden w-full h-full object-contain"
                                controls></video>

                            <button type="button" id="remove-media"
                                class="absolute top-4 right-4 bg-white/90 hover:bg-white p-2 rounded-full shadow-lg z-30 transition-all">
                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                    </div>

                    <button type="button"
                        class="w-full bg-[#E9E9E9] hover:bg-[#E2E2E2] text-gray-900 font-bold py-4 rounded-full transition-colors">
                        Save from URL
                    </button>

                    <x-input-error :messages="$errors->get('media')" class="mt-2" />
                </div>

                <!-- Right Column: Form Details -->
                <div class="flex-1 space-y-10 pt-4">
                    <!-- Title -->
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 ml-1">Title</label>
                        <input type="text" name="title" placeholder="Add a title"
                            class="w-full bg-[#E9E9E9] border-0 rounded-2xl py-5 px-6 focus:ring-2 focus:ring-blue-500 placeholder:text-gray-500 text-lg font-medium transition-all"
                            value="{{ old('title') }}" required>
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <!-- Description -->
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 ml-1">Description</label>
                        <textarea name="content" rows="4" placeholder="Add a detailed description"
                            class="w-full bg-[#E9E9E9] border-0 rounded-2xl py-5 px-6 focus:ring-2 focus:ring-blue-500 placeholder:text-gray-500 text-lg transition-all resize-none"
                            required>{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-1" />
                    </div>

                    <!-- Link -->
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 ml-1">Link</label>
                        <input type="url" name="link" placeholder="Add a link"
                            class="w-full bg-[#E9E9E9] border-0 rounded-2xl py-5 px-6 focus:ring-2 focus:ring-blue-500 placeholder:text-gray-500 text-lg transition-all">
                    </div>

                    <!-- Board Selection -->
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 ml-1">Board</label>
                        <div class="relative">
                            <select
                                class="w-full bg-[#E9E9E9] border-0 rounded-2xl py-5 px-6 focus:ring-2 focus:ring-blue-500 text-gray-500 text-lg appearance-none cursor-pointer pr-12">
                                <option>Choose a board</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 ml-1">Tagged topics (0)</label>
                        <input type="text" placeholder="Search for a tag"
                            class="w-full bg-[#E9E9E9] border-0 rounded-2xl py-5 px-6 focus:ring-2 focus:ring-blue-500 placeholder:text-gray-500 text-lg transition-all">
                    </div>

                    <!-- More Options (Collapsible) -->
                    <div x-data="{ open: false }" class="pt-4 pb-12">
                        <button type="button" @click="open = !open" class="flex items-center gap-2 group focus:outline-none">
                            <span class="text-xl font-bold text-gray-900">More options</span>
                            <svg class="w-6 h-6 text-gray-900 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-8 space-y-8">
                            <!-- Switch: Allow Comments -->
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-medium text-gray-900">Allow people to comment</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="allow_comments" value="1" class="sr-only peer" checked>
                                    <div class="w-12 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <!-- Switch: Show Similar Products -->
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-medium text-gray-900">Show similar products</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="show_similar" value="1" class="sr-only peer" checked>
                                        <div class="w-12 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed max-w-[500px]">
                                    People can shop products similar to what's shown in this Pin using visual search. Shopping recommendations aren't available for Idea ads and Pins with tagged products or paid partnership label.
                                </p>
                            </div>

                            <!-- Alt Text Section -->
                            <div class="space-y-4">
                                <div class="rounded-[24px] border border-gray-300 p-6 focus-within:border-gray-900 transition-colors">
                                    <label class="block text-sm font-bold text-gray-900 mb-2">Alt Text</label>
                                    <textarea name="alt_text" rows="2" placeholder="Describe your Pin's visual details" 
                                        class="w-full border-0 p-0 focus:ring-0 text-lg text-gray-600 placeholder:text-gray-400 resize-none bg-transparent"></textarea>
                                </div>
                                <p class="text-gray-500 text-[13px] ml-1">
                                    This helps people using screen readers understand what your Pin is about
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const mediaInput = document.getElementById('media-input');
            const dropZone = document.getElementById('drop-zone');
            const staticView = document.getElementById('upload-static');
            const previewView = document.getElementById('upload-preview');
            const previewImage = document.getElementById('preview-image');
            const previewVideo = document.getElementById('preview-video');
            const removeBtn = document.getElementById('remove-media');

            function handleFile(file) {
                if (!file) return;

                const reader = new FileReader();
                const isVideo = file.type.startsWith('video/');

                reader.onload = (e) => {
                    staticView.classList.add('hidden');
                    previewView.classList.remove('hidden');

                    if (isVideo) {
                        previewImage.classList.add('hidden');
                        previewVideo.classList.remove('hidden');
                        previewVideo.src = e.target.result;
                    } else {
                        previewVideo.classList.add('hidden');
                        previewImage.classList.remove('hidden');
                        previewImage.src = e.target.result;
                    }
                };

                reader.readAsDataURL(file);
            }

            mediaInput.addEventListener('change', (e) => {
                handleFile(e.target.files[0]);
            });

            removeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                mediaInput.value = '';
                staticView.classList.remove('hidden');
                previewView.classList.add('hidden');
                previewImage.src = '';
                previewVideo.src = '';
            });

            // Drag and drop handling
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.add('bg-[#E2E2E2]', 'border-gray-300');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => {
                    dropZone.classList.remove('bg-[#E2E2E2]', 'border-gray-300');
                }, false);
            });

            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                mediaInput.files = files;
                handleFile(files[0]);
            }, false);
        </script>
    @endpush
</x-app-layout>