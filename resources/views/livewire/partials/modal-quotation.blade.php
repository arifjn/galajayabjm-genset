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
                        <!-- subjek -->
                        <div>
                            <label for="subject" class="block text-sm mb-2">Subject</label>
                            <div class="relative">
                                <select id="subject" wire:model="subject"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('subject') border border-red-500 @enderror"
                                    autofocus>
                                    <option value="" disabled>Pilih Subjek</option>
                                    <option value="rental">Sewa Genset</option>
                                    <option value="pengadaan">Pengadaan Genset Baru</option>
                                    <option value="service">Service Genset</option>
                                </select>
                            </div>
                            @error('subject')
                                <p class="text-xs text-red-600 mt-2" id="subject-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End subjek -->

                        <!-- durasi sewa -->
                        <div>
                            <div class="flex items-center mb-2 justify-between">
                                <div class="inline-flex items-center gap-x-0.5">
                                    <label for="durasi_sewa" class="block text-sm">Durasi Sewa</label>
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
                                            Lewati jika bukan penawaran Rental Genset!
                                        </span>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500" id="hs-input-helper-text">Opsional</span>
                            </div>
                            <div class="relative">
                                <input type="text" id="durasi_sewa" wire:model="durasi_sewa"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-describedby="durasi_sewa-error" placeholder="7">
                                <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-4">
                                    <span class="text-gray-500">Hari</span>
                                </div>
                            </div>
                        </div>
                        <!-- End durasi sewa -->

                        <!-- nama -->
                        <div>
                            <label for="name" class="block text-sm mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" id="name" wire:model="name"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none  @error('name') border border-red-500 @enderror"
                                    aria-describedby="name-error" placeholder="John Doe">
                                @error('name')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="flex-shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12">
                                            </line>
                                            <line x1="12" x2="12.01" y1="16" y2="16">
                                            </line>
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('name')
                                <p class="text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End nama -->

                        <!-- perusahaan -->
                        <div>
                            <div class="flex items-center mb-2 justify-between">
                                <div class="inline-flex items-center gap-x-0.5">
                                    <label for="perusahaan" class="block text-sm">Perusahaan</label>
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
                                            Lewati jika atas nama Perorangan!
                                        </span>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500" id="hs-input-helper-text">Opsional</span>
                            </div>
                            <div class="relative">
                                <input type="text" id="perusahaan" wire:model="perusahaan"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-describedby="perusahaan-error" placeholder="PT. Gala Jaya Banjarmasin">
                            </div>
                        </div>
                        <!-- End perusahaan -->

                        <!-- alamat -->
                        <div>
                            <label for="alamat" class="block text-sm mb-2">Alamat</label>
                            <div class="relative">
                                <textarea id="alamat" wire:model="alamat"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none  @error('alamat') border border-red-500 @enderror"
                                    aria-describedby="alamat-error" placeholder="Jl. Pramuka No.19, Banjarmasin"></textarea>
                                @error('alamat')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="flex-shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12">
                                            </line>
                                            <line x1="12" x2="12.01" y1="16" y2="16">
                                            </line>
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('alamat')
                                <p class="text-xs text-red-600 mt-2" id="alamat-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End alamat -->

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
                                            Lewati jika lokasi proyek sama dengan alamat perusahaan!
                                        </span>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500" id="hs-input-helper-text">Opsional</span>
                            </div>
                            <div class="relative">
                                <textarea id="site" wire:model="site"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    aria-describedby="site-error" placeholder="Jl. Pramuka No.19, Banjarmasin"></textarea>
                            </div>
                        </div>
                        <!-- End lokasi proyek -->

                        <!-- email -->
                        <div>
                            <label for="email" class="block text-sm mb-2">Email</label>
                            <div class="relative">
                                <input type="email" id="email" wire:model="email"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('email') border border-red-500 @enderror"
                                    aria-describedby="email-error" placeholder="mail@domain.com">
                                @error('email')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="flex-shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12">
                                            </line>
                                            <line x1="12" x2="12.01" y1="16" y2="16">
                                            </line>
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('email')
                                <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End email -->

                        <!-- telp -->
                        <div>
                            <label for="no_telp" class="block text-sm mb-2">No. Telp</label>
                            <div class="relative">
                                <input type="tel" id="no_telp" wire:model="no_telp"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('no_telp') border border-red-500 @enderror"
                                    aria-describedby="no_telp-error" placeholder="08xx xxx xxxx">
                                @error('no_telp')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="flex-shrink-0 size-4 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" x2="12" y1="8" y2="12">
                                            </line>
                                            <line x1="12" x2="12.01" y1="16" y2="16">
                                            </line>
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('no_telp')
                                <p class="text-xs text-red-600 mt-2" id="no_telp-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End telp -->

                        <!-- kapasitas -->
                        <div>
                            <label for="kapasitas" class="block text-sm mb-2">Kapasitas Genset</label>
                            <select id="kapasitas" wire:model="kapasitas"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none @error('kapasitas') border border-red-500 @enderror">
                                <option value="" disabled>Pilih Kapasitas Genset</option>
                                <option value="10 KVA">10 KVA</option>
                                <option value="12.5 KVA">12.5 KVA</option>
                                <option value="15 KVA">15 KVA</option>
                                <option value="20 KVA">20 KVA</option>
                                <option value="22.5 KVA">22.5 KVA</option>
                                <option value="30 KVA">30 KVA</option>
                                <option value="45 KVA">45 KVA</option>
                                <option value="50 KVA">50 KVA</option>
                                <option value="60 KVA">60 KVA</option>
                                <option value="80 KVA">80 KVA</option>
                                <option value="100 KVA">100 KVA</option>
                                <option value="115 KVA">115 KVA</option>
                                <option value="120 KVA">120 KVA</option>
                                <option value="130 KVA">130 KVA</option>
                                <option value="135 KVA">135 KVA</option>
                                <option value="140 KVA">140 KVA</option>
                                <option value="150 KVA">150 KVA</option>
                                <option value="200 KVA">200 KVA</option>
                                <option value="250 KVA">250 KVA</option>
                                <option value="300 KVA">300 KVA</option>
                                <option value="350 KVA">350 KVA</option>
                                <option value="400 KVA">400 KVA</option>
                                <option value="500 KVA">500 KVA</option>
                                <option value="800 KVA">800 KVA</option>
                                <option value="1000 KVA">1000 KVA</option>
                            </select>
                            @error('kapasitas')
                                <p class="text-xs text-red-600 mt-2" id="kapasitas-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- End kapasitas -->

                        <!-- brand -->
                        <div>
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
                        </div>
                        <!-- End brand -->

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
                <button
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none"
                    type="submit">
                    Kirim
                </button>
            </div>

            </form>
            <!-- End Form -->
        </div>

    </div>
</div>
</div>
