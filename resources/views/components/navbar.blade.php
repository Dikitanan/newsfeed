<!-- Navbar -->
    <nav class="bg-white border-b border-orange-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <div class="bg-green-500 p-2 rounded-xl text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                    </div>
                    <span class="ml-3 text-2xl font-bold text-green-700 tracking-tight hidden sm:block">Pet House</span>
                    <div class="ml-6 relative hidden md:block">
                        <input type="text" placeholder="Search for paws or claws..." class="bg-orange-50 border border-orange-100 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-green-400 w-64 transition-all">
                        <svg class="w-5 h-5 text-orange-300 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Right: Auth Buttons -->
                <div class="flex items-center space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/') }}" class="text-sm font-semibold text-gray-600 hover:text-green-600 px-3 py-2">My Sanctuary</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-orange-600 hover:bg-orange-50 px-3 py-2 rounded-lg">Log Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-green-700 hover:bg-green-50 px-4 py-2 rounded-full border-2 border-green-600 transition">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-green-600 hover:bg-green-700 px-5 py-2 rounded-full shadow-md shadow-green-100 transition">Join the Pack</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>