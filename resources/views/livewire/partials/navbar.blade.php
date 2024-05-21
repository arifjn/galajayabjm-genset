<!-- ========== HEADER ========== -->
<header class="flex flex-wrap sticky top-0 bg-slate-900 md:justify-start md:flex-nowrap z-50 w-full py-5">
    <nav class="relative max-w-7xl w-full flex flex-wrap md:grid md:grid-cols-12 basis-full items-center px-4 md:px-6 mx-auto"
        aria-label="Global">
        <div class="md:col-span-3">
            <!-- Logo -->
            <a wire:navigate class="inline-flex items-center gap-x-4 text-xl font-semibold dark:text-white" href="/"
                aria-label="Preline">
                <img class="w-8 h-auto" src="{{ url('storage', 'assets/logo/gjb.png') }}" alt="Logo">
                <span class="uppercase">GalaJaya</span>
            </a>
            <!-- End Logo -->
        </div>

        <!-- Button Group -->
        <div class="flex items-center gap-x-2 ms-auto py-1 md:ps-6 md:order-3 md:col-span-3">
            <a wire:navigate href="#"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-gray-200 text-black hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:hover:bg-white/10 dark:text-white dark:hover:text-white">

                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>

                Login
            </a>
            <a wire:navigate href="#"
                class="py-2 px-3 lg:inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-transparent bg-orange-500 text-black hover:bg-orange-600 transition disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-orange-500 hidden">
                Register
            </a>

            <div class="md:hidden">
                <button type="button"
                    class="hs-collapse-toggle size-[38px] flex justify-center items-center text-sm font-semibold rounded-xl border disabled:opacity-50 disabled:pointer-events-none text-white border-neutral-700 hover:bg-neutral-700"
                    data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation"
                    aria-label="Toggle navigation">
                    <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                    <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- End Button Group -->

        <!-- Collapse -->
        <div id="navbar-collapse-with-animation"
            class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block md:w-auto md:basis-auto md:order-2 md:col-span-6">
            <div
                class="flex flex-col gap-y-4 gap-x-0 mt-5 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
                <div>
                    <a wire:navigate
                        class="inline-block text-white hover:text-neutral-300 {{ request()->is('/') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="/" aria-current="page">Home</a>
                </div>
                <div>
                    <a wire:navigate
                        class="inline-block text-white hover:text-neutral-300 {{ request()->is('products*') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="/products">Products</a>
                </div>
                <div>
                    <a wire:navigate
                        class="inline-block text-white hover:text-neutral-300 {{ request()->is('rent') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="/rent">Rent</a>
                </div>
                <div>
                    <a wire:navigate
                        class="inline-block text-white hover:text-neutral-300 {{ request()->is('gallery*') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="{{ route('gallery') }}">Gallery</a>
                </div>
                <div>
                    <a wire:navigate
                        class="inline-block text-white hover:text-neutral-300 {{ request()->is('about') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="{{ route('about') }}">About</a>
                </div>
                <div>
                    <a wire:navigate
                        class="inline-block text-white hover:text-neutral-300 {{ request()->is('contact') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="{{ route('contact') }}">Contact</a>
                </div>
                <div>
                    <a wire:navigate
                        class="inline-block text-white hover:text-neutral-300 rounded-xl border border-transparent bg-orange-500 hover:bg-orange-600 transition disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-orange-500 py-2 px-3 lg:hidden w-full text-center"
                        href="#">Register</a>
                </div>
            </div>
        </div>
        <!-- End Collapse -->
    </nav>
</header>
<!-- ========== END HEADER ========== -->
