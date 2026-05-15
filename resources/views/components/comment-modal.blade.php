<template x-if="open">

    <div
        x-cloak
        class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-2 sm:p-4"
    >

        <!-- MODAL -->
        <div class="bg-white w-full max-w-md h-[95vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col">

            <!-- HEADER -->
            <div class="flex items-center justify-between px-4 py-3 border-b bg-white shrink-0">

                <h2 class="font-bold text-lg text-gray-800">
                    Bark Back 💬
                </h2>

                <button
                    @click="open = false"
                    class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500"
                >
                    ✖
                </button>

            </div>

            <!-- SCROLLABLE CONTENT -->
            <div class="flex-1 overflow-y-auto">

                <!-- POST -->
                <div class="border-b bg-gray-50">

                    <!-- USER -->
                    <div class="p-4 flex items-center">

                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-xl mr-3 shrink-0">
                            🐶
                        </div>

                        <div class="min-w-0">
                            <div
                                class="font-semibold text-sm text-gray-800 truncate"
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
                                        :key="'modal-video-' + post.id"
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

                <!-- COMMENTS -->
                <div class="p-3 space-y-3">

                    <template x-if="comments.length === 0">

                        <div class="text-center text-sm text-gray-400 py-10">
                            No comments yet.
                        </div>

                    </template>

                    <template x-for="comment in comments" :key="comment.id">

                        <div class="flex flex-col items-start max-w-[85%]">

                        <!-- COMMENT BUBBLE -->
                        <div
                            class="bg-gray-100 rounded-2xl px-4 py-3 inline-block w-fit min-w-[150px] shadow-sm"
                        >

                            <div class="text-xs font-semibold text-gray-500 mb-1">
                                <span x-text="comment.user.name"></span>
                            </div>

                            <div
                                class="text-sm text-gray-800 whitespace-pre-wrap break-words leading-relaxed"
                                x-text="comment.body"
                            ></div>

                        </div>

                        <!-- DATE -->
                        <div
                            class="text-[10px] text-gray-400 mt-1 px-2"
                            x-text="new Date(comment.created_at).toLocaleString()"
                        ></div>

                    </div>

                    </template>

                </div>

            </div>

            <!-- INPUT -->
            <div class="border-t bg-white p-3 shrink-0">

                <div class="flex items-end gap-2">

                    <textarea
                        x-model="commentBody"
                        rows="1"
                        placeholder="Write a comment..."
                        class="flex-1 border rounded-2xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring focus:ring-green-200"
                    ></textarea>

                    <button
                        @click="submitComment()"
                        class="bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-2xl text-sm font-semibold shrink-0"
                    >
                        Post
                    </button>

                </div>

            </div>

        </div>

    </div>

</template>