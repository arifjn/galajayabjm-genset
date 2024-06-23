<div class="w-full py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-4 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
            <div class="flex flex-wrap mb-24 -mx-3">
                <div class="w-full pr-2 lg:w-1/4 lg:block">

                    <!-- SearchBox -->
                    <div class="max-w-sm pb-5">
                        <div class="relative">
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                                    <svg class="flex-shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                </div>
                                <input wire:model.live='search'
                                    class="py-3 ps-10 pe-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    type="text" placeholder="Cari Genset ..." value="">
                            </div>
                        </div>
                    </div>
                    <!-- End SearchBox -->

                    <!-- Filter -->
                    <div class="flex flex-wrap gap-y-4 p-4 bg-white border border-gray-200">
                        <div class="w-full">
                            <label for="brand_engine" class="block text-sm font-medium mb-2">Brand Engine</label>
                            <select id="brand_engine" wire:model.live="selected_brand_engine"
                                class="py-3 px-4 pe-9 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                <option selected value="">Semua Engine</option>
                                <option value="cummins">Cummins</option>
                                <option value="deutz">Deutz</option>
                                <option value="fawde">Fawde</option>
                                <option value="MWM">MWM</option>
                                <option value="MAN">MAN</option>
                                <option value="isuzu">Isuzu</option>
                                <option value="perkins">Perkins</option>
                                <option value="primero">Primero</option>
                                <option value="powerol">Powerol Mahindra</option>
                                <option value="yanmar">Yanmar</option>
                            </select>
                        </div>

                        <div>
                            <label for="brand_engine" class="flex items-center text-sm font-medium mb-2">
                                KVA (Range)
                                <div class="hs-tooltip inline-block">
                                    <button type="button" class="hs-tooltip-toggle ms-1">
                                        <svg class="inline-block size-3 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path
                                                d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                        </svg>
                                    </button>
                                    <span
                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible w-40 text-center z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                        role="tooltip">
                                        Inputkan kapasitas mulai dari 10 - 1000 KVA
                                    </span>
                                </div>
                            </label>
                            <div class="flex gap-x-4 items-center rounded-lg shadow-sm">
                                <input type="number" min="0" max="1000"
                                    wire:model.live='capacity_range_first'
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="0">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>


                                <input type="number" min="0" max="1000"
                                    wire:model.live='capacity_range_last'
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="1000">
                            </div>
                        </div>

                    </div>
                    <!-- End Filter -->

                </div>
                <div class="w-full px-3 lg:w-3/4">

                    <!-- Sort -->
                    <div class="px-3 mb-4">
                        <div class="items-center justify-between hidden px-3 py-2 bg-gray-100 md:flex">
                            <div class="flex items-center justify-between">
                                <select wire:model.live="sort" class="block w-40 text-base bg-gray-100 cursor-pointer">
                                    <option value="latest">Sort by latest</option>
                                    <option value="kapasitas">Sort by capacity</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End Sort -->

                    @if (count($products) > 0)
                        <div
                            class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 items-center justify-center pt-2 lg:px-3 gap-4">
                            @foreach ($products as $product)
                                <div
                                    class="w-full flex flex-col group bg-white border shadow-sm rounded-xl overflow-hidden hover:shadow-lg transition">
                                    <div class="relative pt-[50%] sm:pt-[60%] lg:pt-[80%] rounded-t-xl overflow-hidden">
                                        <img class="size-full absolute top-0 start-0 object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out rounded-t-xl"
                                            src="{{ url('storage', $product->images_genset[0]) }}"
                                            alt="{{ ucwords($product->brand_engine) }} {{ $product->kapasitas }} kVA">
                                    </div>
                                    <div class="p-4 md:p-5">
                                        <h3 class="text-lg font-bold text-gray-800 uppercase">
                                            {{ str()->title($product->brand_engine) }} {{ $product->kapasitas }} kVA
                                        </h3>
                                        <p class="text-gray-500 dark:text-neutral-400 text-sm">
                                            {{ str()->title($product->tipe_genset) }} Type
                                        </p>
                                        <div class="py-2">
                                            <span
                                                class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path
                                                        d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                                    </path>
                                                    <path d="m9 12 2 2 4-4"></path>
                                                </svg>
                                                {{ str()->title($product->status_genset) }}
                                            </span>
                                        </div>
                                        <a wire:navigate
                                            class="mt-2 py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none"
                                            href="{{ route('products.show', $product->no_genset) }}">
                                            Detail Product
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- no product -->
                        <div class="flex flex-col gap-y-2 justify-center text-center text-gray-400">
                            <!-- Icon -->

                            <div>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    class="flex-shrink-0 size-24 inline-flex justify-center"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 17L21 21M21 17L17 21M13 3H8.2C7.0799 3 6.51984 3 6.09202 3.21799C5.71569 3.40973 5.40973 3.71569 5.21799 4.09202C5 4.51984 5 5.0799 5 6.2V17.8C5 18.9201 5 19.4802 5.21799 19.908C5.40973 20.2843 5.71569 20.5903 6.09202 20.782C6.51984 21 7.0799 21 8.2 21H13M13 3L19 9M13 3V7.4C13 7.96005 13 8.24008 13.109 8.45399C13.2049 8.64215 13.3578 8.79513 13.546 8.89101C13.7599 9 14.0399 9 14.6 9H19M19 9V14"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            <!-- End Icon -->

                            <div>
                                <h3 class="text-2xl font-semibold">
                                    No Products Found!
                                </h3>
                            </div>

                        </div>
                        <!-- End no product -->
                    @endif

                    <!-- pagination start -->
                    <div class="flex justify-end mt-6">
                        {{ $products->links('vendor.pagination.tailwind') }}
                    </div>
                    <!-- pagination end -->

                </div>
            </div>
        </div>
    </section>

</div>
