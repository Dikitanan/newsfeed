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

    {{-- Header --}}
    <div class="p-4 flex items-center">
        <div class="w-12 h-12 bg-green-100 rounded-full mr-3 flex items-center justify-center text-2xl border-2 border-white shadow-sm">
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

    {{-- Image / Video --}}
    @if($post->media)
        <div class="px-5 pb-4">
            <div class="rounded-xl overflow-hidden border border-gray-100 bg-black">

                @php
                    $ext = strtolower(pathinfo($post->media, PATHINFO_EXTENSION));
                    // Map extensions to correct MIME types
                    $typeMap = [
                        'mp4' => 'video/mp4',
                        'webm' => 'video/webm',
                        'mov' => 'video/mp4', // .mov works best as video/mp4 in browsers
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
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $post->media) }}"
                        class="w-full h-auto block object-contain max-h-[600px]"
                        alt="Post image">
                @endif

            </div>
        </div>
    @endif

    {{-- Like/Comment Actions --}}
    <div class="bg-gray-50/50 px-4 py-2 flex justify-between items-center border-t border-orange-50">
        
        <div class="flex space-x-2">
           @php
                $userId = auth()->id();
                $liked = $userId ? $post->likedByUser($userId) : false;
            @endphp

            <button 
                onclick="toggleLike({{ $post->id }}, this)"
                class="flex items-center p-2 rounded-lg transition 
                {{ $liked ? 'text-red-500' : 'text-gray-400' }}">

                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                    2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09 
                    C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 
                    22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>

                <span class="ml-1 text-xs font-bold">
                    {{ $post->likes }}
                </span>

                <span class="ml-1 text-xs font-bold">Love</span>
            </button>

            <button 
                @click="open = true"
                class="flex items-center hover:bg-white p-2 rounded-lg text-gray-500 transition">
                
                💬 <span class="ml-1 text-xs font-bold">Bark Back</span>
            </button>
        </div>

        <button 
    @click="shareOpen = true" class="text-gray-400 hover:text-green-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                </path>
            </svg>
        </button>

    </div>
   @include('components.comment-modal') 
   @include('components.share-modal')
</div>

<script>
function toggleLike(postId, btn) {
    fetch(`/posts/${postId}/like`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.liked) {
            btn.classList.remove('text-gray-400');
            btn.classList.add('text-red-500');
        } else {
            btn.classList.remove('text-red-500');
            btn.classList.add('text-gray-400');
        }
        const countSpan = btn.querySelectorAll('span')[0];
        countSpan.innerText = data.likes;
    });
}
</script>

<script>
function commentBox(postId, initialComments, post) {

    return {

        open: false,
        shareOpen: false,
        sharedSuccess: false, // <-- 1. Added success state variable

        commentBody: '',
        shareCaption: '',

        comments: initialComments,

        post: post,

        submitComment() {

            if (!this.commentBody.trim()) return;

            fetch(`/posts/${postId}/comments`, {

                method: "POST",

                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({
                    body: this.commentBody
                })

            })

            .then(res => res.json())

            .then(data => {

                this.comments.unshift({

                    id: Date.now(),

                    body: this.commentBody,

                    user: data.comment.user,

                    created_at: new Date().toISOString()

                });

                this.commentBody = '';

            });

        },

        submitShare() {

            fetch(`/posts/${postId}/share`, {

                method: "POST",

                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({
                    caption: this.shareCaption
                })

            })

            .then(res => res.json())

            .then(data => {

                this.shareCaption = '';
                this.sharedSuccess = true; // <-- 2. Set success state to true instead of closing immediately

                // <-- 3. Wait 2 seconds before closing modal and resetting states
                setTimeout(() => {
                    this.shareOpen = false;
                    
                    // Reset the success overlay after the modal closing transition ends
                    setTimeout(() => {
                        this.sharedSuccess = false;
                    }, 400);
                }, 2000);

            });

        }

    }

}
</script>

<script>
// (Kept identical to the function inside your commentBox state object for consistency)
submitShare() {

    fetch(`/posts/${postId}/share`, {

        method: "POST",

        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },

        body: JSON.stringify({
            caption: this.shareCaption
        })

    })

    .then(res => res.json())

    .then(data => {

        this.shareCaption = '';
        this.sharedSuccess = true;

        setTimeout(() => {
            this.shareOpen = false;
            
            setTimeout(() => {
                this.sharedSuccess = false;
            }, 400);
        }, 2000);

    });

}
</script>

<script>
function linkifyText(text) {
    const urlRegex = /(https?:\/\/[^\s]+|www\.[^\s]+)/g;

    return text.replace(urlRegex, function(url) {
        let href = url;

        if (url.startsWith('www.')) {
            href = 'https://' + url;
        }

        return `<a href="${href}" target="_blank" class="text-blue-500 underline hover:text-blue-700">${url}</a>`;
    });
}
</script>