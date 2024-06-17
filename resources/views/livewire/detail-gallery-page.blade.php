<div class="max-w-[85rem] px-4 sm:px-6 lg:px-14 pb-16 mx-auto">
    <section class="grid lg:grid-cols-3 gap-y-8 lg:gap-y-0 lg:gap-x-6">

        <div class="lg:col-span-2 pt-12 lg:py-12 lg:pe-8" x-data="{ mainImage: '{{ url('storage', $gallery->images[0]) }}' }">

            <div class="space-y-5 mb-6">
                <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline"
                    href="{{ route('gallery') }}">
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    Back to Gallery
                </a>
                <h2 class="text-3xl font-bold lg:text-5xl text-gray-800"> {{ $gallery->title }}
                </h2>

                <div class="flex flex-wrap gap-x-5 mb-8 items-center">
                    <span
                        class="py-1.5 px-3 bg-white text-gray-600 border border-gray-200 text-xs sm:text-sm rounded-xl inline-flex items-center gap-x-1">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        {{ $gallery->location }}
                    </span>
                    <p class="text-xs sm:text-sm text-gray-500">
                        {{ $gallery->created_at->format('j F Y') }}
                    </p>
                </div>

                <p class="text-base text-gray-500">{{ $gallery->description }}</p>
            </div>

            <div class="sticky top-0 overflow-hidden">
                <div class="relative mb-6 lg:mb-10 lg:h-2/4">
                    <img x-bind:src="mainImage" alt="" class="object-cover w-full lg:h-full">
                </div>
                @if (count($gallery->images) > 1)
                    <div class="flex flex-wrap">
                        @foreach ($gallery->images as $image)
                            <div class="w-1/2 p-2 sm:w-1/4" x-on:click="mainImage='{{ url('storage', $image) }}'">
                                <img src="{{ url('storage', $image) }}" alt="{{ $gallery->title }}"
                                    class="object-cover w-full lg:h-20 cursor-pointer hover:border hover:border-orange-500">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1 lg:py-12">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl p-4 md:p-5">

                <!-- Title sidebar -->
                <div class="group flex items-center gap-x-3 border-b border-gray-200 pb-4 mb-6">
                    <h1 class="text-lg text-gray-800 font-semibold">Lihat Proyek kami lainnya :</h1>
                </div>
                <!-- End Title sidebar -->

                <div class="space-y-6">
                    @foreach ($galleries as $gallery)
                        <!-- Galeri -->
                        <a wire:navigate class="group flex items-center gap-x-6"
                            href="{{ url('gallery', $gallery->slug) }}">
                            <div class="grow">
                                <span
                                    class="text-sm font-semibold text-gray-700 group-hover:text-gray-800 group-hover:underline">
                                    {{ $gallery->title }}
                                </span>
                                <p class="text-sm text-gray-400">
                                    {{ str()->limit($gallery->description, 35) }}
                                </p>
                            </div>

                            <div class="flex-shrink-0 relative rounded-lg overflow-hidden size-20">
                                <img class="size-full absolute top-0 start-0 object-cover rounded-lg"
                                    src="{{ url('storage', $gallery->images[0]) }}" alt="Image Description">
                            </div>
                        </a>
                        <!-- End Galeri -->
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
