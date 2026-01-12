<x-app-layout>
    <div class="min-h-screen bg-white">
        <!-- Top Toolbar -->
        <div class="sticky top-0 z-40 bg-white px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('posts.index') }}" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <div class="flex-1"></div>

            <div class="flex items-center gap-3">
                <!-- Actions like Save could go here if needed, but keeping it clean for now -->
            </div>
        </div>

        <div class="max-w-[1400px] mx-auto px-4 py-6">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Content Pin Card -->
                <div class="flex-1" x-data="{ 
                    lightbox: false, 
                    isLiked: {{ $isLiked ? 'true' : 'false' }}, 
                    likeCount: {{ $post->likes_count ?? 0 }},
                    showBoardDropdown: false,
                    showCreateBoardModal: false,
                    newBoardName: '',
                    selectedBoard: '{{ $userBoards->first()->name ?? 'Select Board' }}',
                    selectedBoardId: '{{ $userBoards->first()->id ?? '' }}',
                    async toggleLike() {
                        try {
                            const response = await fetch('{{ route('posts.like', $post) }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await response.json();
                            this.isLiked = data.liked;
                            this.likeCount = data.count;
                        } catch (e) {
                            console.error('Like failed', e);
                        }
                    },
                    scrollToComments() {
                        document.getElementById('comments-section').scrollIntoView({ behavior: 'smooth' });
                    },
                    async saveToBoard() {
                        if (!this.selectedBoardId) {
                            alert('Please select or create a board first');
                            return;
                        }
                        try {
                            const response = await fetch('{{ route('posts.save-to-board', $post) }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ board_id: this.selectedBoardId })
                            });
                            const data = await response.json();
                            alert(data.message);
                        } catch (e) {
                            console.error('Save failed', e);
                        }
                    },
                    async createBoard() {
                        if (!this.newBoardName) return;
                        try {
                            const response = await fetch('{{ route('boards.store') }}', {
                                method: 'POST',
                                headers: { 
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ name: this.newBoardName })
                            });
                            const board = await response.json();
                            this.showCreateBoardModal = false;
                            this.newBoardName = '';
                            location.reload(); // Simple reload to refresh the board list
                        } catch (e) {
                            console.error('Create board failed', e);
                        }
                    }
                }">
                    <div class="bg-white rounded-[32px] shadow-lg border border-gray-100 overflow-hidden">
                        <!-- Card Header Actions -->
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <!-- Like Button -->
                                <button @click="toggleLike()"
                                    class="p-2 hover:bg-gray-100 rounded-full transition-colors flex items-center gap-2 group">
                                    <svg class="w-6 h-6 transition-colors"
                                        :class="isLiked ? 'fill-red-600 text-red-600' : 'text-gray-900 group-hover:text-red-500'"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="font-bold text-sm" x-text="likeCount"></span>
                                </button>

                                <!-- Comment Button -->
                                <button @click="scrollToComments()"
                                    class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>

                                <!-- More Options (Download) -->
                                <div class="relative" x-data="{ openMore: false }">
                                    <button @click="openMore = !openMore"
                                        class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                        </svg>
                                    </button>
                                    <div x-show="openMore" @click.outside="openMore = false"
                                        class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                        <a href="{{ route('posts.download', $post) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 font-bold text-gray-900">
                                            Download image
                                        </a>
                                        <button
                                            class="w-full text-left px-4 py-2 hover:bg-gray-100 font-bold text-gray-900">
                                            Copy link
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <!-- Board Selection Dropdown -->
                                <div class="relative">
                                    <button @click="showBoardDropdown = !showBoardDropdown"
                                        class="flex items-center gap-1 font-bold text-gray-900 hover:bg-gray-100 px-3 py-2 rounded-lg transition-colors">
                                        <span x-text="selectedBoard"></span>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div x-show="showBoardDropdown" @click.outside="showBoardDropdown = false"
                                        class="absolute right-0 mt-2 w-64 bg-white rounded-[24px] shadow-2xl border border-gray-100 overflow-hidden z-50">
                                        <div class="p-4 border-b border-gray-100">
                                            <p class="text-sm font-bold text-gray-900 mb-4 text-center">Save to board
                                            </p>
                                        </div>
                                        <div class="max-h-60 overflow-y-auto p-2">
                                            @forelse($userBoards as $board)
                                                <button
                                                    @click="selectedBoard = '{{ $board->name }}'; selectedBoardId = '{{ $board->id }}'; showBoardDropdown = false"
                                                    class="w-full text-left px-3 py-2 hover:bg-gray-100 rounded-lg font-semibold text-gray-900 transition-colors">
                                                    {{ $board->name }}
                                                </button>
                                            @empty
                                                <p class="text-center text-gray-500 py-4">No boards yet</p>
                                            @endforelse
                                        </div>
                                        <div class="p-3 bg-gray-50 border-t border-gray-100">
                                            <button @click="showCreateBoardModal = true; showBoardDropdown = false"
                                                class="w-full bg-gray-200 hover:bg-gray-300 py-2 rounded-full font-bold text-gray-900 transition-colors">
                                                Create board
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <button @click="saveToBoard()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full transition-all scale-100 active:scale-95 shadow-md">
                                    Save
                                </button>
                            </div>
                        </div>

                        <!-- Create Board Modal -->
                        <template x-teleport="body">
                            <div x-show="showCreateBoardModal" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-black/60">

                                <div @click.outside="showCreateBoardModal = false"
                                    class="bg-white w-full max-w-md rounded-[32px] overflow-hidden shadow-2xl">
                                    <div class="p-6 text-center border-b border-gray-100">
                                        <h3 class="text-2xl font-bold text-gray-900">Create board</h3>
                                    </div>
                                    <div class="p-8">
                                        <label class="block text-sm font-medium text-gray-700 mb-2 ml-1">Name</label>
                                        <input type="text" x-model="newBoardName"
                                            placeholder='Like "Places to Go" or "Recipes"'
                                            class="w-full bg-white border-2 border-gray-200 rounded-2xl py-4 px-6 focus:border-blue-500 focus:ring-0 text-lg transition-all"
                                            @keydown.enter="createBoard()">
                                    </div>
                                    <div class="p-6 bg-gray-50 flex justify-end gap-3">
                                        <button @click="showCreateBoardModal = false"
                                            class="px-6 py-3 rounded-full font-bold text-gray-900 hover:bg-gray-200 transition-colors">
                                            Cancel
                                        </button>
                                        <button @click="createBoard()"
                                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-bold transition-all shadow-md active:scale-95"
                                            :disabled="!newBoardName"
                                            :class="!newBoardName ? 'opacity-50 cursor-not-allowed' : ''">
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Main Image Display -->
                        <div class="px-6 pb-6 flex justify-center bg-white">
                            <div class="relative max-w-2xl w-full group">
                                @if($post->image_path)
                                    <img @click="lightbox = true" src="{{ asset('storage/' . $post->image_path) }}"
                                        class="w-full h-auto rounded-[32px] shadow-sm cursor-zoom-in hover:opacity-95 transition-opacity"
                                        alt="{{ $post->title }}">
                                @elseif($post->video_path)
                                    <video src="{{ asset('storage/' . $post->video_path) }}"
                                        class="w-full h-auto rounded-[32px] shadow-sm bg-black" controls></video>
                                @endif

                                <button @click="lightbox = true"
                                    class="absolute bottom-6 right-6 bg-white/90 hover:bg-white p-3 rounded-full shadow-lg transition-all opacity-0 group-hover:opacity-100 scale-90 group-hover:scale-100">
                                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Lightbox Modal -->
                        <template x-teleport="body">
                            <div x-show="lightbox" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4">

                                <button @click="lightbox = false"
                                    class="absolute top-6 right-6 text-white hover:bg-white/10 p-3 rounded-full transition-colors z-[110]">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <div class="max-w-[90vw] max-h-[90vh] flex flex-col items-center">
                                    @if($post->image_path)
                                        <img src="{{ asset('storage/' . $post->image_path) }}"
                                            class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
                                    @endif
                                    <div class="mt-4 text-white text-center">
                                        <h3 class="text-xl font-bold">{{ $post->title }}</h3>
                                        <p class="text-gray-400">By {{ $post->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Info Footer -->
                        <div class="p-8 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center font-bold text-orange-700">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $post->user->name }}</p>
                                    <p class="text-xs text-gray-500">6.2k followers</p>
                                </div>
                            </div>
                            <button
                                class="bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold py-3 px-6 rounded-full transition-colors">
                                Follow
                            </button>
                        </div>
                    </div>

                    <!-- Bottom Titles/Comments Section -->
                    <div id="comments-section" class="mt-8 px-4">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                        <p class="text-gray-700 text-lg leading-relaxed mb-8">{{ $post->content }}</p>

                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Comments</h2>
                            <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <form action="{{ route('comments.store', $post) }}" method="POST"
                            class="flex gap-3 items-start mb-8">
                            @csrf
                            <div
                                class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-gray-600">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <input type="text" name="content" placeholder="Add a comment"
                                    class="w-full bg-transparent border-0 border-b border-gray-200 py-3 focus:border-gray-900 focus:ring-0 placeholder:text-gray-400">
                            </div>
                        </form>

                        <!-- Display Comments -->
                        <div class="space-y-6 pb-12">
                            @foreach($post->comments as $comment)
                                <div class="flex gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $comment->user->name }}</p>
                                        <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- More Like This Sidebar -->
                <div class="w-full lg:w-[450px]">
                    <div class="flex items-center justify-between mb-6 px-2">
                        <h2 class="text-xl font-bold text-gray-900">More like this</h2>
                    </div>

                    <div class="columns-2 gap-4">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('posts.show', $related) }}" class="block mb-4 group">
                                <div class="relative rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                                    @if($related->image_path)
                                        <img src="{{ asset('storage/' . $related->image_path) }}" class="w-full h-auto"
                                            alt="{{ $related->title }}">
                                    @elseif($related->video_path)
                                        <video src="{{ asset('storage/' . $related->video_path) }}"
                                            class="w-full h-auto bg-black"></video>
                                    @else
                                        <img src="https://picsum.photos/400/{{ rand(300, 500) }}?random={{ $related->id }}"
                                            class="w-full h-auto" alt="{{ $related->title }}">
                                    @endif

                                    <!-- Hover Overlay -->
                                    <div
                                        class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity p-3 flex flex-col justify-between items-end">
                                        <button
                                            class="bg-blue-600 text-white font-bold py-2 px-4 rounded-full text-xs shadow-lg">Save</button>
                                        <div class="flex gap-2">
                                            <div class="bg-white/90 p-1.5 rounded-full shadow-lg">
                                                <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                                </svg>
                                            </div>
                                            <div class="bg-white/90 p-1.5 rounded-full shadow-lg">
                                                <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>