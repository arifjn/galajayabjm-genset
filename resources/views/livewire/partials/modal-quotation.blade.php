<div id="hs-quotation" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto">
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
                <form>
                    <div class="grid gap-y-4">
                        <!-- subjek -->
                        <div>
                            <label for="subject" class="block text-sm mb-2">Subject</label>
                            <div class="relative">
                                <input type="text" id="subject" name="subject"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="subject-error" placeholder="Rental Genset" autofocus>
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="hidden text-xs text-red-600 mt-2" id="subject-error">Please include a valid email
                                address so we can get back to you</p>
                        </div>
                        <!-- End subjek -->

                        <!-- nama -->
                        <div>
                            <label for="name" class="block text-sm mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" id="name" wire:model="name"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="name-error" placeholder="John Doe">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="hidden text-xs text-red-600 mt-2" id="name-error">Please include a valid email
                                address so we can get back to you</p>
                        </div>
                        <!-- End nama -->

                        <!-- perusahaan -->
                        <div>
                            <label for="perusahaan" class="block text-sm mb-2">Perusahaan</label>
                            <div class="relative">
                                <input type="text" id="perusahaan" wire:model="perusahaan"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="perusahaan-error"
                                    placeholder="PT. Gala Jaya Banjarmasin">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="hidden text-xs text-red-600 mt-2" id="perusahaan-error">Please include a valid
                                email
                                address so we can get back to you</p>
                        </div>
                        <!-- End perusahaan -->

                        <!-- alamat -->
                        <div>
                            <label for="alamat" class="block text-sm mb-2">Alamat</label>
                            <div class="relative">
                                <textarea id="alamat" wire:model="alamat"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="alamat-error" placeholder="Jl. Pramuka No.19, Banjarmasin"></textarea>
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="hidden text-xs text-red-600 mt-2" id="alamat-error">Please include a valid
                                email
                                address so we can get back to you</p>
                        </div>
                        <!-- End alamat -->

                        <!-- email -->
                        <div>
                            <label for="email" class="block text-sm mb-2">Email</label>
                            <div class="relative">
                                <input type="email" id="email" wire:model="email"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="email-error" placeholder="mail@domain.com">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="hidden text-xs text-red-600 mt-2" id="email-error">Please include a valid
                                email
                                address so we can get back to you</p>
                        </div>
                        <!-- End email -->

                        <!-- telp -->
                        <div>
                            <label for="no_telp" class="block text-sm mb-2">No. Telp</label>
                            <div class="relative">
                                <input type="tel" id="no_telp" wire:model="no_telp"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="no_telp-error" placeholder="08xx xxx xxxx">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="hidden text-xs text-red-600 mt-2" id="no_telp-error">Please include a valid
                                email
                                address so we can get back to you</p>
                        </div>
                        <!-- End telp -->

                        <!-- kapasitas -->
                        <div>
                            <label for="kapasitas" class="block text-sm mb-2">Kapasitas Genset</label>
                            <select id="kapasitas" name="kapasitas"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                required>
                                <option selected disabled>Pilih Kapasitas Genset</option>
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
                            <p class="hidden text-xs text-red-600 mt-2" id="kapasitas-error">Please include a valid
                                email
                                address so we can get back to you</p>
                        </div>
                        <!-- End kapasitas -->

                        <!-- brand -->
                        <div>
                            <label for="brand" class="block text-sm mb-2">Brand Engine</label>
                            <select id="brand" name="brand"
                                class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                required>
                                <option selected disabled>Pilih Brand Engine</option>
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
                            </select>
                            <p class="hidden text-xs text-red-600 mt-2" id="brand-error">Please include a valid
                                email
                                address so we can get back to you</p>
                        </div>
                        <!-- End brand -->

                        <!-- keterangan -->
                        <div>
                            <label for="keterangan" class="block text-sm mb-2">Keterangan</label>
                            <div class="relative">
                                <textarea id="keterangan" name="keterangan"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-orange-500 focus:ring-orange-500 disabled:opacity-50 disabled:pointer-events-none"
                                    required aria-describedby="keterangan-error" placeholder="Isi pesan (tambahan)"></textarea>
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="hidden text-xs text-red-600 mt-2" id="keterangan-error">Please include a valid
                                email
                                address so we can get back to you</p>
                        </div>
                        <!-- End keterangan -->
                    </div>
                </form>
                <!-- End Form -->
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t">
                <button type="button"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                    data-hs-overlay="#hs-quotation">
                    Cancel
                </button>
                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none"
                    href="#">
                    Kirim
                </a>
            </div>
        </div>

    </div>
</div>
</div>
