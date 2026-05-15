@php
    $post = $shared->post;
@endphp

<div
    x-data="commentBox(
        {{ $post->id }},
        {{ Js::from($post->comments->load('user')) }},
        {{ Js::from([
            'id' => $post->id,
            'body' => $post->body,
            'media' => $post->media,
            'media_url' => $post->media ? asset('storage/' . $post->media) : null,
            'user' => [
                'name' => $post->user->name
            ],
            'created_at_human' => $post->created_at->diffForHumans(),
            'is_video' => in_array(
                strtolower(pathinfo($post->media ?? '', PATHINFO_EXTENSION)),
                ['mp4', 'mov', 'avi', 'webm']
            ),
            'mime_type' => match(strtolower(pathinfo($post->media ?? '', PATHINFO_EXTENSION))) {
                'webm' => 'video/webm',
                'mov' => 'video/mp4',
                'avi' => 'video/x-msvideo',
                default => 'video/mp4'
            }
        ]) }}
    )"
    class="bg-white rounded-2xl shadow-sm border border-orange-100 mb-6 overflow-hidden"
>

    {{-- SHARE HEADER --}}
    <div class="p-4 flex items-center">

        <div class="w-12 h-12 bg-blue-100 rounded-full mr-3 flex items-center justify-center text-2xl border-2 border-white shadow-sm">
            🔁
        </div>

        <div>

            <h5 class="font-bold text-gray-800">
                {{ $shared->user->name }}
            </h5>

            <div class="text-xs text-gray-500">
                shared a post • {{ $shared->created_at->diffForHumans() }}
            </div>

        </div>

    </div>

    {{-- SHARE CAPTION --}}
    @if($shared->caption)
        <div class="px-5 pb-4 text-gray-700">
            {{ $shared->caption }}
        </div>
    @endif

    {{-- ORIGINAL POST --}}
    <div class="mx-4 mb-4 border rounded-2xl overflow-hidden border-gray-200 bg-gray-50">

        {{-- ORIGINAL HEADER --}}
        <div class="p-4 flex items-center">

            <div class="w-10 h-10 bg-green-100 rounded-full mr-3 flex items-center justify-center text-xl border border-white shadow-sm">
                🐶
            </div>

            <div>

                <h5 class="font-bold text-gray-800">
                    {{ $post->user->name }}
                </h5>

                <div class="flex items-center text-xs text-orange-400 font-medium">

                    <span class="uppercase tracking-wider">
                        {{ $post->created_at->diffForHumans() }}
                    </span>

                    @if($post->habitat)
                        <span class="mx-1">•</span>

                        <span class="text-green-600">
                            📍 {{ $post->habitat }}
                        </span>
                    @endif

                </div>

            </div>

        </div>

        {{-- BODY --}}
        @php
            $body = preg_replace(
                '/(https?:\/\/[^\s]+)/',
                '<a href="$1" target="_blank" class="text-blue-500 underline hover:text-blue-700">$1</a>',
                e($post->body)
            );
        @endphp

        <div class="px-5 pb-3 text-gray-700 leading-relaxed">
            {!! nl2br($body) !!}
        </div>

        {{-- MEDIA --}}
        @if($post->media)

            <div class="px-5 pb-4">

                <div class="rounded-xl overflow-hidden border border-gray-100 bg-black">

                    @php
                        $ext = strtolower(pathinfo($post->media, PATHINFO_EXTENSION));

                        $typeMap = [
                            'mp4' => 'video/mp4',
                            'webm' => 'video/webm',
                            'mov' => 'video/mp4',
                            'avi' => 'video/x-msvideo'
                        ];

                        $mimeType = $typeMap[$ext] ?? 'video/mp4';
                    @endphp

                    @if(in_array($ext, ['mp4', 'mov', 'avi', 'webm']))

                        <video
                            class="w-full h-auto block object-contain max-h-[600px]"
                            controls
                            playsinline
                            preload="metadata"
                        >
                            <source src="{{ asset('storage/' . $post->media) }}" type="{{ $mimeType }}">
                        </video>

                    @else

                        <img
                            src="{{ asset('storage/' . $post->media) }}"
                            class="w-full h-auto block object-contain max-h-[600px]"
                            alt="Post image"
                        >

                    @endif

                </div>

            </div>

        @endif

    </div>

    {{-- ACTIONS --}}
    <div class="bg-gray-50/50 px-4 py-2 flex justify-between items-center border-t border-orange-50">

        <div class="flex space-x-2">

            @php
                $userId = auth()->id();
                $liked = $userId ? $post->likedByUser($userId) : false;
            @endphp

            <button
                onclick="toggleLike({{ $post->id }}, this)"
                class="flex items-center p-2 rounded-lg transition
                {{ $liked ? 'text-red-500' : 'text-gray-400' }}"
            >

                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                    2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09
                    C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42
                    22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>

                <span class="ml-1 text-xs font-bold">
                    {{ $post->likes }}
                </span>

                <span class="ml-1 text-xs font-bold">
                    Love
                </span>

            </button>

            <button
                @click="open = true"
                class="flex items-center hover:bg-white p-2 rounded-lg text-gray-500 transition"
            >
                💬 <span class="ml-1 text-xs font-bold">Bark Back</span>
            </button>

        </div>

    </div>

    @include('components.comment-modal')

</div>