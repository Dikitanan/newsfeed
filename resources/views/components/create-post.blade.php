<div class="bg-white rounded-2xl shadow-sm border border-orange-100 p-5 mb-6">

    <form action="{{ route('posts.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="flex items-start space-x-3 mb-4">

            <div class="w-11 h-11 bg-orange-100 rounded-full flex-shrink-0 flex items-center justify-center text-lg">
                🦊
            </div>

            <div class="w-full">

                <textarea
                    name="body"
                    rows="3"
                    placeholder="Share a tail, {{ Auth::user()->name ?? 'friend' }}..."
                    class="bg-gray-50 hover:bg-gray-100 text-gray-800 rounded-2xl py-3 px-5 w-full transition border border-gray-100 focus:outline-none focus:ring-2 focus:ring-green-400"
                    required
                ></textarea>

                {{-- Media Preview --}}
                <div id="preview-container"
                    class="hidden mt-3 relative inline-block">

                    <img id="image-preview"
                        class="hidden rounded-xl max-h-[400px] w-auto border border-orange-100 shadow-sm">

                    <video id="video-preview"
                        class="hidden rounded-xl max-h-[400px] w-auto border border-orange-100 shadow-sm"
                        controls>
                    </video>

                    <button type="button"
                            onclick="removeMedia()"
                            class="absolute top-2 right-2 bg-black/50 text-white rounded-full p-1 hover:bg-black/70 transition">
                        ✖
                    </button>
                </div>

                <div id="extra-fields" class="mt-2 space-y-2">

                    <input type="file"
                           name="media"
                           id="media-upload"
                           class="hidden"
                           accept="image/*,video/*"
                           onchange="previewMedia(this)">

                    <input type="text"
                           name="habitat"
                           placeholder="Which habitat?"
                           class="hidden w-full text-sm bg-orange-50 border-orange-100 rounded-lg px-3 py-1 focus:outline-none"
                           id="habitat-input">
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center pt-2 border-t border-orange-50">

            <div class="flex space-x-2">

                <button type="button"
                        onclick="document.getElementById('media-upload').click()"
                        class="flex items-center hover:bg-green-50 px-3 py-2 rounded-xl text-green-600 font-bold transition">

                    📸 <span class="ml-2 text-sm">Photo / Video</span>
                </button>

                <button type="button"
                        onclick="document.getElementById('habitat-input').classList.toggle('hidden')"
                        class="flex items-center hover:bg-orange-50 px-3 py-2 rounded-xl text-orange-600 font-bold transition">

                    📍 <span class="ml-2 text-sm">Habitat</span>
                </button>
            </div>

            <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded-full font-bold hover:bg-green-700 transition shadow-md shadow-green-100">

                Post
            </button>
        </div>
    </form>
</div>

<script>
    function previewMedia(input) {
        const file = input.files[0];

        const container = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        const videoPreview = document.getElementById('video-preview');

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function(e) {

            container.classList.remove('hidden');

            if (file.type.startsWith('image/')) {

                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');

                videoPreview.classList.add('hidden');
                videoPreview.src = "";

            } else if (file.type.startsWith('video/')) {

                videoPreview.src = e.target.result;
                videoPreview.classList.remove('hidden');

                imagePreview.classList.add('hidden');
                imagePreview.src = "";
            }
        };

        reader.readAsDataURL(file);
    }

    function removeMedia() {
        const input = document.getElementById('media-upload');

        input.value = "";

        document.getElementById('preview-container').classList.add('hidden');

        const img = document.getElementById('image-preview');
        const vid = document.getElementById('video-preview');

        img.classList.add('hidden');
        img.src = "";

        vid.classList.add('hidden');
        vid.src = "";
    }
</script>