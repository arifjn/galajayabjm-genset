<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="overflow-hidden py-11 font-poppins">
        <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="{ mainImage: 'https://galajaya.com/_ph/1/2/347064123.jpg?1715778096' }">
                    <div class="sticky top-0 overflow-hidden">
                        <div class="relative mb-6 lg:mb-10 lg:h-2/4">
                            <img x-bind:src="mainImage" alt="" class="object-cover w-full lg:h-full">
                        </div>
                        <div class="flex-wrap hidden md:flex ">
                            <div class="w-1/2 p-2 sm:w-1/4"
                                x-on:click="mainImage='https://galajaya.com/_ph/1/2/347064123.jpg?1715778096'">
                                <img src="https://galajaya.com/_ph/1/2/347064123.jpg?1715778096" alt=""
                                    class="object-cover w-full lg:h-20 cursor-pointer hover:border hover:border-orange-500">
                            </div>

                            <div class="w-1/2 p-2 sm:w-1/4"
                                x-on:click="mainImage='https://galajaya.com/_ph/1/2/533790915.jpg?1716216269'">
                                <img src="https://galajaya.com/_ph/1/2/533790915.jpg?1716216269" alt=""
                                    class="object-cover w-full lg:h-20 cursor-pointer hover:border hover:border-orange-500">
                            </div>

                            <div class="w-1/2 p-2 sm:w-1/4"
                                x-on:click="mainImage='https://galajaya.com/_ph/1/2/398764716.jpg?1716216308'">
                                <img src="https://galajaya.com/_ph/1/2/398764716.jpg?1716216308" alt=""
                                    class="object-cover w-full lg:h-20 cursor-pointer hover:border hover:border-orange-500">
                            </div>

                        </div>
                        <div class="pb-6 mt-6 border-t border-gray-300">
                            <div class="flex flex-wrap items-center mt-6">
                                <a class="inline-flex items-center gap-x-1 text-sm text-gray-800 hover:text-gray-400 focus:outline-none focus:text-gray-500"
                                    href="{{ route('gallery') }}">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6"></path>
                                    </svg>
                                    Back to Examples
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full px-4 md:w-1/2">
                    <div class="lg:pl-20">
                        <div class="mb-4">
                            <h2 class="max-w-xl mb-6 text-2xl font-bold text-gray-800 md:text-4xl">
                                Cummins 250 kVA
                            </h2>
                            <p class="max-w-md text-gray-700 dark:text-gray-400">
                                Dokumentasi Foto Rental Sewa Genset Cummins 250 KVA di Tempat Customer di lokasi
                                Kalimantan
                                Selatan.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-8">
                            <span
                                class="py-1.5 px-3 bg-white text-gray-600 border border-gray-200 text-xs sm:text-sm rounded-xl dark:border-neutral-700 dark:text-neutral-400 inline-flex items-center gap-x-1">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                Kalimantan Selatan
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <button
                                class="w-full p-4 bg-blue-500 rounded-md lg:w-2/5 dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700">
                                Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
