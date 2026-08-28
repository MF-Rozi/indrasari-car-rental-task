<nav class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur-md dark:border-slate-800 dark:bg-[#0F172A]/90">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('catalog.index') }}" class="flex items-center space-x-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">
                        Indrasari <span class="text-blue-600 dark:text-blue-400">Rent</span>
                    </span>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:ml-8 md:flex md:space-x-4">
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center rounded-lg px-3 py-1.5 text-sm font-medium {{ request()->routeIs('catalog.*') ? 'bg-slate-100 text-blue-600 dark:bg-slate-800 dark:text-blue-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                        Fleet Catalog
                    </a>
                    @auth
                        <a href="{{ route('rentals.my-rentals') }}" class="inline-flex items-center rounded-lg px-3 py-1.5 text-sm font-medium {{ request()->routeIs('rentals.my-rentals') ? 'bg-slate-100 text-blue-600 dark:bg-slate-800 dark:text-blue-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                            My Rentals
                        </a>
                        <a href="{{ route('rentals.return') }}" class="inline-flex items-center rounded-lg px-3 py-1.5 text-sm font-medium {{ request()->routeIs('rentals.return') ? 'bg-slate-100 text-blue-600 dark:bg-slate-800 dark:text-blue-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                            Return Vehicle
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right Controls: Theme Switcher & User Profile -->
            <div class="flex items-center space-x-3">
                <!-- Theme Toggle Button -->
                <button type="button" onclick="window.toggleTheme()" class="rounded-xl border border-slate-200 bg-slate-50 p-2 text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700" title="Toggle Light / Dark Mode">
                    <!-- Sun Icon (Visible in Dark Mode) -->
                    <svg class="hidden h-5 w-5 dark:block text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon Icon (Visible in Light Mode) -->
                    <svg class="block h-5 w-5 dark:hidden text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                @auth
                    <!-- User Dropdown Menu -->
                    <div class="relative">
                        <button type="button" id="user-menu-button" class="flex items-center space-x-2.5 rounded-xl border border-slate-200 bg-white py-1.5 pl-2.5 pr-3 text-sm font-medium text-slate-800 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 font-bold text-blue-700 dark:bg-blue-900/60 dark:text-blue-300">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden max-w-[120px] truncate sm:inline-block">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Panel -->
                        <div id="user-menu-dropdown" class="absolute right-0 mt-2 hidden w-60 origin-top-right rounded-2xl border border-slate-200 bg-white py-2 shadow-xl dark:border-slate-800 dark:bg-[#1E293B]">
                            <div class="border-b border-slate-100 px-4 py-2.5 dark:border-slate-700/60">
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</p>
                                <div class="mt-1.5 flex items-center gap-1.5">
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-[10px] font-semibold text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                                        SIM: {{ auth()->user()->sim_number }}
                                    </span>
                                    @if(auth()->user()->isAdmin())
                                        <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-0.5 text-[10px] font-semibold text-purple-700 dark:bg-purple-950 dark:text-purple-300">
                                            Admin
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-950/40">
                                    <svg class="mr-2.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Admin Dashboard
                                </a>
                            @endif

                            <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800/60">
                                <svg class="mr-2.5 h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>

                            <a href="{{ route('rentals.my-rentals') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800/60">
                                <svg class="mr-2.5 h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                My Rentals
                            </a>

                            <div class="border-t border-slate-100 pt-1 dark:border-slate-700/60">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-4 py-2 text-left text-sm text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/40">
                                        <svg class="mr-2.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden items-center space-x-2 sm:flex">
                        <a href="{{ route('login') }}" class="rounded-xl px-3.5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm shadow-blue-500/20 hover:bg-blue-700">
                            Sign Up
                        </a>
                    </div>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button type="button" id="mobile-menu-button" class="rounded-xl border border-slate-200 p-2 text-slate-600 hover:bg-slate-100 focus:outline-none md:hidden dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="Toggle navigation">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Collapsible Menu Drawer -->
        <div id="mobile-menu" class="hidden border-t border-slate-200 pb-4 pt-3 md:hidden dark:border-slate-800">
            <div class="space-y-1">
                <a href="{{ route('catalog.index') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                    Fleet Catalog
                </a>
                @auth
                    <a href="{{ route('rentals.my-rentals') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        My Rentals
                    </a>
                    <a href="{{ route('rentals.return') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        Return Vehicle
                    </a>
                    <a href="{{ route('profile.show') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-800 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        My Profile
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 text-base font-medium text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-950/40">
                            Admin Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-base font-medium text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/40">
                            Log Out
                        </button>
                    </form>
                @else
                    <div class="mt-3 flex flex-col space-y-2 px-3 pt-2">
                        <a href="{{ route('login') }}" class="w-full rounded-xl border border-slate-200 bg-white py-2 text-center text-sm font-medium text-slate-800 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100">
                            Log In
                        </a>
                        <a href="{{ route('register') }}" class="w-full rounded-xl bg-blue-600 py-2 text-center text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
