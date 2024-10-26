<div wire:ignore.self id="hs-quotation"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden">
            <div class="absolute top-2 end-2">
                <button type="button"
                    class="flex justify-center items-center size-7 text-sm font-semibold rounded-lg border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
                    data-hs-overlay="#hs-quotation">
                    <span class="sr-only">Close</span>
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-4 sm:p-10 overflow-y-auto">
                <div class="mb-6 text-center">
                    <h3 class="mb-2 text-xl font-bold text-gray-800">
                        Minta Penawaran 👨‍💻
                    </h3>
                    <p class="text-gray-500">
                        Silahkan isi form berikut untuk meminta penawaran!
                    </p>
                </div>

                <!-- Form -->
                <form wire:submit.prevent='save'>
                    <div class="grid gap-y-4">
                        <input type="hidden" wire:model='customer_id'>
                        <!-- subjek -->
                        <div>
                            <label for="subject" class="block text-sm mb-2">Subject</label>
                            <div class="relative">
                                <select id="subject" wire:model.live="subject"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('subject') border border-red-500 @enderror"
                                    autofocus>
                                    <option value="" disabled>Pilih Subjek</option>
                                    <option value="sewa">Sewa Genset</option>
                                    {{-- <option value="pengadaan">Pengadaan Genset Baru</option>
                                    <option value="service">Service Genset</option> --}}
                                </select>
                            </div>
                            @error('subject')
                                <p class="text-xs text-red-600 mt-2" id="subject-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End subjek -->

                        <!-- durasi sewa -->
                        @if ($subject == 'sewa')
                            <!-- Tgl sewa -->
                            <div>
                                <label for="tgl_sewa" class="block text-sm mb-2">Tanggal Sewa</label>
                                <div class="rounded-lg shadow-sm">
                                    <input id="tgl_sewa" type="date" wire:model='tgl_sewa'
                                        class="border-gray-200 border text-gray-800 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 py-2 px-3 pe-11 block w-full"
                                        placeholder="Pilih Tanggal Mulai Sewa" />
                                    @error('tgl_sewa')
                                        <p class="text-xs text-red-600 mt-2" id="tgl_sewa-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- End Tgl sewa -->

                            <!-- Tgl selesai sewa -->
                            <div>
                                <div class="flex items-center mb-2 justify-between">
                                    <label for="tgl_selesai" class="block text-sm">Tanggal Selesai</label>
                                    <span class="text-sm text-gray-500" id="hs-input-helper-text">Opsional</span>
                                </div>
                                <div class="rounded-lg shadow-sm">
                                    <input id="tgl_selesai" type="date" wire:model='tgl_selesai'
                                        class="border-gray-200 border text-gray-800 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 py-2 px-3 pe-11 block w-full"
                                        placeholder="Pilih Tanggal Selesai" />
                                    @error('tgl_selesai')
                                        <p class="text-xs text-red-600 mt-2" id="tgl_selesai-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- End Tgl selesai sewa -->

                            <label for="operator"
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                <input type="checkbox"
                                    class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    id="operator" wire:model='operator'>
                                <span class="ms-3">Operator</span>
                            </label>
                        @endif
                        <!-- End durasi sewa -->

                        <!-- kapasitas -->
                        <div>
                            <label for="kapasitas" class="block text-sm mb-2">Kapasitas Genset</label>
                            <select id="kapasitas" wire:model="kapasitas"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('kapasitas') border border-red-500 @enderror">
                                <option value="" disabled>Pilih Kapasitas Genset</option>
                                <option value="10">10 KVA</option>
                                <option value="12.5">12.5 KVA</option>
                                <option value="15">15 KVA</option>
                                <option value="20">20 KVA</option>
                                <option value="22.5 KVA">22.5 KVA</option>
                                <option value="30">30 KVA</option>
                                <option value="40">40 KVA</option>
                                <option value="45">45 KVA</option>
                                <option value="50">50 KVA</option>
                                <option value="60">60 KVA</option>
                                <option value="80">80 KVA</option>
                                <option value="100">100 KVA</option>
                                <option value="115">115 KVA</option>
                                <option value="120">120 KVA</option>
                                <option value="130">130 KVA</option>
                                <option value="135">135 KVA</option>
                                <option value="140">140 KVA</option>
                                <option value="150">150 KVA</option>
                                <option value="200">200 KVA</option>
                                <option value="250">250 KVA</option>
                                <option value="300">300 KVA</option>
                                <option value="350">350 KVA</option>
                                <option value="400">400 KVA</option>
                                <option value="500">500 KVA</option>
                                <option value="800">800 KVA</option>
                                <option value="1000">1000 KVA</option>
                            </select>
                            @error('kapasitas')
                                <p class="text-xs text-red-600 mt-2" id="kapasitas-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End kapasitas -->

                        <!-- brand -->
                        {{-- <div>
                            <label for="brand_engine" class="block text-sm mb-2">Brand Engine</label>
                            <select id="brand_engine" wire:model="brand_engine"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('brand_engine') border border-red-500 @enderror">
                                <option value="" disabled>Pilih Brand Engine</option>
                                <option value="Cummins">Cummins</option>
                                <option value="Deutz">Deutz</option>
                                <option value="Fawde">Fawde</option>
                                <option value="MWM">MWM</option>
                                <option value="MAN">MAN</option>
                                <option value="Isuzu">Isuzu</option>
                                <option value="Perkins">Perkins</option>
                                <option value="Primero">Primero</option>
                                <option value="Powerol">Powerol Mahindra</option>
                                <option value="Yanmar">Yanmar</option>
                            </select>
                            @error('brand_engine')
                                <p class="text-xs text-red-600 mt-2" id="brand_engine-error">{{ $message }}</p>
                            @enderror
                        </div> --}}
                        <!-- End brand -->

                        <!-- lokasi proyek -->
                        <div>
                            <div class="flex items-center mb-2 justify-between">
                                <div class="inline-flex items-center gap-x-0.5">
                                    <label for="site" class="block text-sm">Lokasi Proyek</label>
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
                                            Lewati jika lokasi proyek sama dengan alamat!
                                        </span>
                                    </div>
                                </div>
                                {{-- <span class="text-sm text-gray-500" id="hs-input-helper-text">Opsional</span> --}}
                                <div class="flex">
                                    <input type="checkbox"
                                        class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        id="validateSite" wire:model.live="validateSite" checked="">
                                    <label for="validateSite" class="text-sm text-gray-500 ms-2">Sama dengan Alamat
                                        Perusahaan</label>
                                </div>
                            </div>
                            @if (!$validateSite)
                                <div class="relative">
                                    <textarea id="site" wire:model="site"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                        aria-describedby="site-error" placeholder="Jl. Pramuka No.19, Banjarmasin"></textarea>
                                </div>
                            @endif
                        </div>
                        <!-- End lokasi proyek -->

                        <!-- keterangan -->
                        <div>
                            <label for="keterangan" class="block text-sm mb-2">Keterangan</label>
                            <div class="relative">
                                <textarea id="keterangan" wire:model="keterangan"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-describedby="keterangan-error" placeholder="Isi pesan (tambahan)"></textarea>
                            </div>
                        </div>
                        <!-- End keterangan -->
                    </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t">
                <button type="button"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                    data-hs-overlay="#hs-quotation">
                    Cancel
                </button>
                <button wire:loading.remove wire:target='save'
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none"
                    type="submit">
                    Kirim
                </button>

                <div wire:loading wire:target='save'>
                    <button type="submit" wire:loading.attr='disabled'
                        class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none">
                        <div
                            class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full">
                            <span class="sr-only">Loading...</span>
                        </div>
                        Loading ...
                    </button>
                </div>
            </div>

            </form>
            <!-- End Form -->
        </div>

    </div>
</div>
</div>
