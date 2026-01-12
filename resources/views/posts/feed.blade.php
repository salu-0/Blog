<x-app-layout>
    <div class="min-h-screen bg-white">
        
        <!-- Categories / Pills -->
        <div class="sticky top-16 z-40 bg-white border-b border-gray-100 shadow-sm py-3 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto overflow-x-auto no-scrollbar">
                <div class="flex space-x-2 sm:space-x-4">
                    <button class="bg-black text-white px-4 py-2 rounded-full font-semibold text-sm whitespace-nowrap">All</button>
                    @foreach(['Sketching', 'My saves', 'Life quotes', 'Refashion clothes', 'Art drawings', 'Graduation', 'Hair styles', 'My artwork', 'Paper crafts'] as $category)
                        <button class="bg-gray-100 text-gray-900 hover:bg-gray-200 px-4 py-2 rounded-full font-semibold text-sm whitespace-nowrap transition-colors">{{ $category }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Masonry Grid Feed -->
        <div class="max-w-[2000px] mx-auto p-4 sm:p-6 lg:p-8">
            @if($posts->count() > 0)
                <div class="columns-2 md:columns-3 lg:columns-4 xl:columns-5 gap-4 space-y-4">
                    @foreach($posts as $post)
                        <a href="{{ route('posts.show', $post) }}" class="break-inside-avoid relative group cursor-pointer mb-4 block">
                            <!-- Card Container -->
                            <div class="rounded-2xl overflow-hidden relative">
                                <!-- Image/Video -->
                                @php
                                    $randomHeight = rand(300, 600); 
                                @endphp
                                @if($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover rounded-2xl group-hover:brightness-75 transition-all duration-300">
                                @elseif($post->video_path)
                                    <video src="{{ asset('storage/' . $post->video_path) }}" class="w-full h-auto object-cover rounded-2xl group-hover:brightness-75 transition-all duration-300" muted loop onmouseover="this.play()" onmouseout="this.pause()"></video>
                                @else
                                    <img src="https://picsum.photos/400/{{ $randomHeight }}?random={{ $post->id }}" alt="{{ $post->title }}" class="w-full h-auto object-cover rounded-2xl group-hover:brightness-75 transition-all duration-300">
                                @endif
                                
                                <!-- Hover Overlay Labels (Optional Pinterest style) -->
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between p-4 flex-shrink-0">
                                    <div class="flex justify-end">
                                        <button type="button" class="bg-blue-600 text-white px-4 py-2.5 rounded-full font-bold text-sm hover:bg-blue-700 transition-colors shadow-sm">Save</button>
                                    </div>
                                    <div class="flex justify-end space-x-2">
                                        <div class="bg-white/90 p-2 rounded-full hover:bg-white text-gray-900 shadow-sm transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                        </div>
                                        <div class="bg-white/90 p-2 rounded-full hover:bg-white text-gray-900 shadow-sm transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Caption -->
                            @if($post->title)
                                <h3 class="mt-2 font-semibold text-gray-900 text-sm leading-tight truncate px-1">{{ $post->title }}</h3>
                            @endif
                            
                        </a>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center min-h-[50vh] w-full text-center">
                    <a href="{{ route('posts.create') }}" class="mt-4 inline-block bg-black text-white px-6 py-2 rounded-full font-bold">Create Pin</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
