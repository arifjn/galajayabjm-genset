<!-- ========== HEADER ========== -->
<header class="flex flex-wrap sticky top-0 bg-slate-900 md:justify-start md:flex-nowrap z-50 w-full py-5">
    <nav class="relative max-w-7xl w-full flex flex-wrap md:grid md:grid-cols-12 basis-full items-center px-4 md:px-6 mx-auto"
        aria-label="Global">

        <div class="md:col-span-3 flex items-center justify-between w-full">
            <!-- Logo -->
            <a class="inline-flex items-center gap-x-4 text-xl font-semibold text-white" href="/"
                aria-label="Preline">
                <img class="w-8 h-auto" src="{{ url('storage', 'assets/logo/gjb.png') }}" alt="Logo">
                <span class="uppercase">GalaJaya</span>
            </a>
            <!-- End Logo -->

            <!-- Btn Collapsi -->
            <div class="md:hidden mb-2">
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
            <!-- End Btn Collapsi -->
        </div>

        @if (!Auth::guard('customer')->user())
            <!-- Button Group -->
            <div class="flex items-center gap-x-2 ms-auto py-1 md:ps-6 md:order-3 md:col-span-3">
                <a href="{{ route('login') }}"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-gray-200 text-white hover:bg-gray-800 disabled:opacity-50 disabled:pointer-events-none">

                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-transparent bg-orange-500 text-black hover:bg-orange-600 transition disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-orange-500">
                    Register
                </a>
            </div>
            <!-- End Button Group -->
        @endif

        @if (Auth::guard('customer')->user())
            <!-- Profil Group -->
            <div class="md:flex hidden items-center ms-auto md:ps-6 md:order-3 md:col-span-3">
                <div
                    class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover]">
                    <button id="hs-mega-menu-basic-dr" type="button"
                        class="flex items-center w-full text-gray-600 hover:text-gray-400 font-medium">
                        <div class="flex-shrink-0 group block">
                            <div class="flex items-center">
                                <div class="relative inline-block">
                                    <img class="inline-block flex-shrink-0 size-8 rounded-full object-cover"
                                        src="{{ auth()->guard('customer')->user()->profile_img ? url('storage', auth()->guard('customer')->user()->profile_img) : asset('assets/images/no-image.jpg') }}"
                                        alt="Image Description">
                                    @if (count($orders) > 0)
                                        <span
                                            class="absolute animate-ping bottom-0 end-0 block size-2 rounded-full ring-2 ring-white bg-green-500"></span>
                                        <span
                                            class="absolute bottom-0 end-0 block size-2 rounded-full ring-2 ring-white bg-green-500"></span>
                                    @endif
                                </div>
                                <div class="ms-3 text-start">
                                    <p class="font-medium text-sm text-white">
                                        {{ auth()->guard('customer')->user()->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <svg class="flex-shrink-0 ms-2 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div
                        class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 z-10 bg-white sm:shadow-md rounded-lg p-2 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden">
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-200"
                            href="{{ route('customer-profile.show', auth()->guard('customer')->user()->id) }}">
                            Profile
                        </a>
                        <a class="flex items-center justify-between gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-200"
                            href="{{ route('order', auth()->guard('customer')->user()->id) }}">
                            My Orders
                            <span
                                class="inline-flex items-center gap-x-1.5 py-1 px-2.5 rounded-lg text-sm font-medium border border-teal-500 text-teal-500">
                                {{ count($orders) }}
                            </span>
                        </a>
                        <button
                            class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-gray-200 w-full"
                            type="button" data-hs-overlay="#hs-sign-out-alert">
                            Logout
                        </button>

                    </div>
                </div>

            </div>
            <!-- End Profile Group -->
        @endif

        <!-- Collapse -->
        <div id="navbar-collapse-with-animation"
            class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block md:w-auto md:basis-auto md:order-2 md:col-span-6">
            <div
                class="flex flex-col gap-y-4 gap-x-0 mt-5 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
                <div>
                    <a class="inline-block text-white hover:text-neutral-300 {{ request()->is('/') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="/" aria-current="page">Home</a>
                </div>
                <div>
                    <a class="inline-block text-white hover:text-neutral-300 {{ request()->is('products*') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="/products">Products</a>
                </div>
                <div>
                    <a class="inline-block text-white hover:text-neutral-300 {{ request()->is('gallery*') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="{{ route('gallery') }}">Gallery</a>
                </div>
                <div>
                    <a class="inline-block text-white hover:text-neutral-300 {{ request()->is('about') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="{{ route('about') }}">About</a>
                </div>
                <div>
                    <a class="inline-block text-white hover:text-neutral-300 {{ request()->is('contact') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative before:scale-x-100' : '' }} before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 hover:before:scale-x-100 relative"
                        href="{{ route('contact') }}">Contact</a>
                </div>

                @if (Auth::guard('customer')->user())
                    <!-- Profil Collapse -->
                    <div class="md:hidden flex items-center">
                        <div
                            class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover] w-full">
                            <button id="hs-mega-menu-basic-dr" type="button"
                                class="flex items-center w-full text-white hover:text-neutral-300 font-medium">
                                <p class="font-medium">
                                    {{ auth()->guard('customer')->user()->name }}
                                </p>
                                <svg class="flex-shrink-0 ms-2 size-4" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div
                                class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] sm:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 sm:w-48 z-10 p-2 before:absolute top-full sm:border before:-top-5 before:start-0 before:w-full before:h-5 hidden">
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-800"
                                    href="{{ route('customer-profile.show', auth()->guard('customer')->user()->id) }}">
                                    Profile
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-800"
                                    href="{{ route('order', auth()->guard('customer')->user()->id) }}">
                                    My Orders
                                </a>
                                <button type="button" data-hs-overlay="#hs-sign-out-alert"
                                    class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:bg-gray-700 focus:ring-2 focus:ring-gray-800 w-full">
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End Profil Collapse -->
                @endif

            </div>
        </div>
        <!-- End Collapse -->

    </nav>
</header>
<!-- ========== END HEADER ========== -->
