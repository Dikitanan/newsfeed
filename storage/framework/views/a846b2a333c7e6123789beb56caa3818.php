<template x-if="shareOpen">

    <div
        x-cloak
        class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-2 sm:p-4"
    >

        <!-- MODAL -->
        <div class="bg-white w-full max-w-md h-[95vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col">

            <!-- HEADER -->
            <div class="flex items-center justify-between px-4 py-3 border-b bg-white shrink-0">

                <h2 class="font-bold text-lg text-gray-800">
                    Share Post 
                </h2>

                <button
                    @click="shareOpen = false"
                    class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500"
                >
                    ✖
                </button>

            </div>

            <!-- MAIN BODY CONTAINER -->
            <div class="flex-1 overflow-y-auto relative flex flex-col">

                <!-- SUCCESS OVERLAY -->
                <!-- This will slide/fade in beautifully over the content when sharedSuccess is true -->
                <div 
                    x-show="sharedSuccess"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute inset-0 bg-white z-10 flex flex-col items-center justify-center p-6 text-center"
                >
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-3xl mb-4 animate-bounce">
                        ✓
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Successfully Shared!</h3>
                    <p class="text-sm text-gray-500">Your post has been shared to your feed.</p>
                </div>

                <!-- CONTENT -->
                <div class="flex-1 bg-gray-50">

                    <!-- CAPTION -->
                    <div class="p-4 bg-white border-b">

                        <textarea
                            x-model="shareCaption"
                            rows="3"
                            placeholder="Write something about this..."
                            class="w-full border rounded-2xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring focus:ring-green-200"
                        ></textarea>

                    </div>

                <!-- POST PREVIEW -->
                <div class="p-4">

                    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">

                        <!-- USER -->
                        <div class="p-4 flex items-center">

                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-xl mr-3 shrink-0">
                                🐶
                            </div>

                            <div>

                                <div
                                    class="font-semibold text-sm text-gray-800"
                                    x-text="post.user.name"
                                ></div>

                                <div
                                    class="text-xs text-gray-400"
                                    x-text="post.created_at_human"
                                ></div>

                            </div>

                        </div>

                        <!-- BODY -->
                        <div
                            class="px-4 pb-3 text-sm text-gray-700 whitespace-pre-wrap break-words"
                            x-text="post.body"
                        ></div>

                        <!-- MEDIA -->
                        <template x-if="post.media">

                            <div class="px-2 pb-3">

                                <!-- VIDEO -->
                                <template x-if="post.is_video">

                                    <div class="bg-black rounded-2xl overflow-hidden">

                                        <video
                                            class="w-full max-h-[45vh] object-contain"
                                            controls
                                            playsinline
                                            preload="metadata"
                                        >
                                            <source
                                                :src="post.media_url"
                                                :type="post.mime_type"
                                            >
                                        </video>

                                    </div>

                                </template>

                                <!-- IMAGE -->
                                <template x-if="!post.is_video">

                                    <div class="bg-black rounded-2xl overflow-hidden">

                                        <img
                                            :src="post.media_url"
                                            class="w-full max-h-[45vh] object-contain"
                                        >

                                    </div>

                                </template>

                            </div>

                        </template>

                    </div>

                </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="border-t bg-white p-3 shrink-0">

                <button
                    @click="submitShare()"
                    :disabled="sharedSuccess"
                    class="w-full bg-green-500 hover:bg-green-600 disabled:bg-gray-300 text-white py-3 rounded-2xl font-semibold transition"
                >
                    <span x-text="sharedSuccess ? 'Shared!' : 'Share Post'"></span>
                </button>

            </div>

        </div>

    </div>

</template><?php /**PATH C:\Users\dikit\Desktop\projects\newsfeedfacebook\resources\views/components/share-modal.blade.php ENDPATH**/ ?>