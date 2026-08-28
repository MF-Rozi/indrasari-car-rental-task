<footer class="mt-auto border-t border-slate-200 bg-white py-8 dark:border-slate-800 dark:bg-[#0B0F19]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
            <div class="flex items-center space-x-2.5">
                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4zM4 9h16l-1.5 6H5.5L4 9zm1.5-4h13l1 3H4.5l1-3z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-900 dark:text-white">
                    Indrasari Car Rental
                </span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} Indrasari Car Rental. Professional, reliable vehicle rental services.
            </p>
            <div class="flex space-x-6 text-xs text-slate-500 dark:text-slate-400">
                <a href="{{ route('catalog.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Fleet Catalog</a>
                <a href="{{ route('login') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Sign In</a>
                <a href="{{ route('register') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Register</a>
            </div>
        </div>
    </div>
</footer>
