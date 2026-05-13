<header
    class="sticky top-0 bg-white/80 backdrop-blur-lg border-b border-gray-100 z-30 shadow-[0_4px_20px_-10px_rgba(0,0,0,0.05)]">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 -mb-px">

            <div class="flex items-center">
                <button
                    class="text-gray-400 hover:text-onpc-orange focus:outline-none focus:ring-2 focus:ring-onpc-orange/50 rounded-lg p-2 transition-colors bg-gray-50/50"
                    @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                    <span class="sr-only">Menu</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>

                <h2 class="ml-4 text-xl font-bold text-gray-800 hidden sm:block">
                    Espace Groupe
                </h2>
            </div>

            <div class="flex items-center space-x-4">
                <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>

                <div class="relative inline-flex" x-data="{ open: false }">
                    <button class="inline-flex justify-center items-center group focus:outline-none"
                        aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                        @if (Auth::user()->logo)
                            <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-100 group-hover:border-onpc-orange transition-colors shadow-sm"
                                src="{{ asset('storage/' . Auth::user()->logo) }}" alt="Groupe" />
                        @else
                            <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-100 group-hover:border-onpc-orange transition-colors shadow-sm"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0000cc&color=fff&bold=true"
                                alt="Groupe" />
                        @endif
                        <div class="items-center truncate ml-3 hidden md:flex">
                            <span
                                class="truncate text-sm font-semibold text-gray-700 group-hover:text-onpc-orange transition-colors max-w-[140px]">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 shrink-0 ml-1 text-gray-400 group-hover:text-onpc-orange transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div class="origin-top-right z-10 absolute top-full right-0 min-w-[220px] bg-white border border-gray-100 py-2 rounded-2xl shadow-xl overflow-hidden mt-2"
                        x-show="open" x-transition:enter="transition ease-out duration-200 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false"
                        style="display: none;">
                        <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                            <p class="text-sm font-medium text-gray-900 truncate">Groupe</p>
                            <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="border-t border-gray-100 pt-1">
                            <form method="POST" action="{{ route('admin.logout') }}" x-data>
                                @csrf
                                <a class="group flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors"
                                    href="#" @click.prevent="$root.submit();">
                                    <svg class="mr-3 h-4 w-4 text-red-500 group-hover:text-red-700 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Se deconnecter
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
