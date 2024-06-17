<div class="w-full mx-auto px-4 sm:px-6 lg:px-24 lg:py-20 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-8 gap-y-8">
        @foreach ($galleries as $gallery)
            <!-- Card -->
            <a wire:navigate href="{{ route('gallery.show', $gallery->slug) }}" class="group block hover:cursor-pointer">
                <div class="aspect-w-16 aspect-h-12 overflow-hidden bg-gray-100 rounded-2xl">
                    <img class="group-hover:scale-105 transition-transform duration-500 ease-in-out object-cover rounded-2xl"
                        src="{{ url('storage', $gallery->images[0]) }}" alt="Image Description">
                </div>

                <div class="pt-4">
                    <h3
                        class="relative inline-block font-medium text-lg text-gray-800 before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 before:transition before:origin-left before:scale-x-0 group-hover:before:scale-x-100">
                        {{ $gallery->title }}
                    </h3>
                    <p class="mt-1 text-gray-600 text-sm truncate">
                        {{ $gallery->description }}
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2">
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
                            {{ $gallery->location }}
                        </span>
                    </div>
                </div>
                </d>
                <!-- End Card -->

            </a>
            <!-- End Card Grid -->
        @endforeach
    </div>

    <!-- pagination start -->
    <div class="flex justify-center mt-6">
        {{ $galleries->links('vendor.pagination.tailwind') }}
    </div>
    <!-- pagination end -->
</div>
