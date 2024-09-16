<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-4 rounded-lg">
        <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">

            <!-- produk -->
            <div class="grid lg:grid-cols-2 grid-cols-1 gap-4" x-data="{ mainImage: '{{ url('storage', $genset->images_genset[0]) }}' }">

                <div class="lg:px-8">

                    <div class="flex flex-col bg-white border shadow-sm rounded-xl border-neutral-300">
                        <img class="w-full h-auto rounded-xl object-cover" x-bind:src="mainImage"
                            alt="{{ ucwords($genset->brand_engine) }} {{ $genset->kapasitas }} kVA">
                    </div>

                </div>

                <div class="lg:pe-8">
                    <h1 class="text-4xl text-gray-800 font-bold uppercase">{{ $genset->brand_engine }}
                        {{ $genset->kapasitas }} kva
                    </h1>
                    <div class="py-2 flex items-center gap-x-2">
                        <span
                            class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full">
                            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z">
                                </path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            {{ str()->title($genset->status_genset) }} to rent
                        </span>
                        <span
                            class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                            {{ ucwords($genset->tipe_genset) }} Type
                        </span>
                    </div>
                    <p class="text-sm text-gray-400 text-justify mt-2">Setiap Genset yang kami jual dan sewakan selalu
                        kami
                        cek terlebih
                        dahulu
                        sebelum dikirim ke pelanggan,
                        sehingga pelanggan yang sewa ataupun beli genset kami tidak perlu khawatir dalam hal kualitas
                        produk
                        kami.</p>
                    <ul class="mt-4 space-y-3 text-gray-400 text-justify text-sm">
                        <li class="flex space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24"
                                height="24" stroke-width="1.5" stroke="currentColor"
                                class="flex-shrink-0 size-4 mt-0.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            <p>
                                Waranty Engine 1 (satu) tahun atau 2.000 Jam.
                            </p>
                        </li>
                        <li class="flex space-x-3">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 size-4 mt-0.5"
                                width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                            </svg>

                            <p>
                                Free Jasa Instalasi dan Commisioning
                            </p>
                        </li>
                        <li class="flex space-x-3">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 size-4 mt-0.5"
                                width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                            </svg>

                            <p>
                                Free Jasa Troubleshooting / Maintenance 1x Kunjungan (S&K)
                            </p>
                        </li>
                        <li class="flex space-x-3">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24"
                                height="24" stroke-width="1.5" stroke="currentColor"
                                class="size-4 mt-0.5 flex-shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 0 1-.657.643 48.39 48.39 0 0 1-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 0 1-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 0 0-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 0 1-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 0 0 .657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 0 1-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 0 0 5.427-.63 48.05 48.05 0 0 0 .582-4.717.532.532 0 0 0-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 0 0 .658-.663 48.422 48.422 0 0 0-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 0 1-.61-.58v0Z" />
                            </svg>


                            <p>
                                Jaminan Spare Parts & After Sales Service
                            </p>
                        </li>
                    </ul>

                    @if (count($genset->images_genset) > 1)
                        <div class="flex flex-wrap">
                            @foreach ($genset->images_genset as $image)
                                <div class="w-1/2 sm:w-1/4 mt-6 pe-2"
                                    x-on:click="mainImage='{{ url('storage', $image) }}'">
                                    <img src="{{ url('storage', $image) }}"
                                        alt="{{ $genset->brand_engine }} {{ $genset->kapasitas }} kVA"
                                        class="object-cover w-full rounded-md lg:h-28 cursor-pointer hover:border hover:border-orange-500">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <!-- End produk -->

            <!-- table spek -->
            <div class="mt-12 grid lg:grid-cols-3 grid-cols-1  gap-4 lg:px-8 gap-y-8">
                <div class="col-span-2">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="border rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th scope="col" colspan="3"
                                                class="px-6 py-2 text-start font-medium text-gray-800 uppercase">
                                                Spesifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                Brand Engine</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                :</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ ucfirst($genset->brand_engine) }}</td>
                                        </tr>

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                Tipe Engine</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                :</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ ucfirst($genset->tipe_engine) }}</td>
                                        </tr>


                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                KVA</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                :</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ $genset->kapasitas }}</td>
                                        </tr>

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                KW</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                :</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ $genset->kapasitas * 0.8 }}</td>
                                        </tr>

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                Brand Generator</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                :</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ ucfirst($genset->brand_generator) }}</td>
                                        </tr>

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                Tipe Generator</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                :</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ ucfirst($genset->tipe_generator) }}</td>
                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50">
                                            <th scope="col"
                                                class="px-6 py-2 text-start font-medium text-gray-800 uppercase">
                                                Perkiraan Harga Sewa</th>
                                            <th scope="col"
                                                class="px-6 py-2 text-start font-medium text-gray-800 uppercase">
                                                :</th>
                                            <th scope="col"
                                                class="px-6 py-2 text-start font-medium text-gray-800 uppercase">
                                                {{ Number::currency($genset->harga, 'IDR', 'ID') }}/Hari
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4 lg:ps-4">
                    @if ($genset->spek_genset)
                        <a href="{{ url('storage', $genset->spek_genset) }}" target="_blank"
                            class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 transition-all disabled:opacity-50 disabled:pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Lihat Detail Spesifikasi
                        </a>
                    @endif

                    <button type="button"
                        data-hs-overlay="{{ Auth::guard('customer')->user() ? '#hs-quotation' : '#hs-auth-check' }}"
                        class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-green-500 text-white hover:bg-green-600 transition-all disabled:opacity-50 disabled:pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        Minta Penawaran
                    </button>

                    <a wire:navigate href="{{ route('products') }}"
                        class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-400 text-white hover:bg-gray-500 transition-all disabled:opacity-50 disabled:pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                        Kembali Lihat Produk Lainnya
                    </a>
                </div>
            </div>
            <!-- End table spek -->
        </div>
    </section>

</div>
