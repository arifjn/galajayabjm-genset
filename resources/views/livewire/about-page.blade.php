<!-- About -->
<div class="max-w-[85rem] min-h-screen px-4 py-10 sm:px-6 lg:px-12 lg:py-20 mx-auto">
    <!-- layanan -->
    <div class="relative p-6 md:p-16">
        <!-- Grid -->
        <div class="relative z-10 lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
            <div class="mb-10 lg:mb-0 lg:col-span-6 lg:col-start-8 lg:order-2">
                <div class="inline-flex gap-x-4 items-center">
                    <img src="{{ url('storage', 'assets/logo/logo_only.png') }}" alt="" width="80"
                        height="80">
                    <h2 class="font-bold text-2xl md:text-4xl text-gray-800 uppercase">
                        Tak Kenal <br> Maka Tak Tau!
                    </h2>
                </div>
                <p class="mt-2 md:mt-4 text-gray-500 text-justify">
                    PT. Gala Jaya Banjarmasin adalah perusahaan yang bergerak di bidang Penjualan, Rental, Part dan
                    Service
                    Generator set dimulai dari kapasitas 10 kVA - 1000 kVA yang berkomitmen
                    untuk selalu dapat memenuhi kebutuhan dan kepuasan pelanggan.
                </p>

                <!-- Tab Navs -->
                <nav class="grid gap-4 mt-5 md:mt-8" aria-label="Tabs" role="tablist">
                    <button type="button"
                        class="hs-tab-active:bg-white hs-tab-active:shadow-md hs-tab-active:hover:border-transparent text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl active"
                        id="tabs-with-card-item-1" data-hs-tab="#tabs-with-card-1" aria-controls="tabs-with-card-1"
                        role="tab">
                        <span class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="flex-shrink-0 mt-2 size-6 md:size-7 hs-tab-active:text-orange-500 text-gray-800"
                                width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>

                            <span class="grow ms-6">
                                <span
                                    class="block text-lg font-semibold hs-tab-active:text-orange-500 text-gray-800">Sales</span>
                                <span class="block mt-1 text-gray-800 text-sm">
                                    Kami menawarkan berbagai pilihan genset dari berbagai merk terkemuka untuk memenuhi
                                    kebutuhan industri dan komersial Anda.
                                </span>
                            </span>
                        </span>
                    </button>

                    <button type="button"
                        class="hs-tab-active:bg-white hs-tab-active:shadow-md hs-tab-active:hover:border-transparent text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl"
                        id="tabs-with-card-item-2" data-hs-tab="#tabs-with-card-2" aria-controls="tabs-with-card-2"
                        role="tab">
                        <span class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="flex-shrink-0 mt-2 size-6 md:size-7 hs-tab-active:text-orange-500 text-gray-800"
                                width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                            </svg>

                            <span class="grow ms-6">
                                <span
                                    class="block text-lg font-semibold hs-tab-active:text-orange-500 text-gray-800">Rental</span>
                                <span class="block mt-1 text-gray-800 text-sm">
                                    Kami menyediakan berbagai tipe genset dengan kapasitas yang berbeda untuk mendukung
                                    acara, proyek konstruksi, atau kebutuhan darurat Anda.
                                </span>
                            </span>
                        </span>
                    </button>

                    <button type="button"
                        class="hs-tab-active:bg-white hs-tab-active:shadow-md hs-tab-active:hover:border-transparent text-start hover:bg-gray-200 p-4 md:p-5 rounded-xl"
                        id="tabs-with-card-item-3" data-hs-tab="#tabs-with-card-3" aria-controls="tabs-with-card-3"
                        role="tab">
                        <span class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="flex-shrink-0 mt-2 size-6 md:size-7 hs-tab-active:text-orange-500 text-gray-800"
                                width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                            </svg>

                            <span class="grow ms-6">
                                <span
                                    class="block text-lg font-semibold hs-tab-active:text-orange-500 text-gray-800">Service</span>
                                <span class="block mt-1 text-gray-800 text-sm">
                                    Pastikan genset Anda beroperasi optimal dengan layanan perawatan dan perbaikan dari
                                    PT Gala Jaya Banjarmasin.
                                </span>
                            </span>
                        </span>
                    </button>
                </nav>
                <!-- End Tab Navs -->
            </div>
            <!-- End Col -->

            <div class="lg:col-span-6">
                <div class="relative">
                    <!-- Tab Content -->
                    <div>
                        <div id="tabs-with-card-1" role="tabpanel" aria-labelledby="tabs-with-card-item-1">
                            <img class="shadow-xl shadow-gray-200 rounded-xl"
                                src="{{ url('storage', 'assets/images/sale_genset.jpg') }}" alt="Image Description">
                        </div>

                        <div id="tabs-with-card-2" class="hidden" role="tabpanel"
                            aria-labelledby="tabs-with-card-item-2">
                            <img class="shadow-xl shadow-gray-200 rounded-xl"
                                src="{{ url('storage', 'assets/images/rent_genset.jpg') }}" alt="Image Description">
                        </div>

                        <div id="tabs-with-card-3" class="hidden" role="tabpanel"
                            aria-labelledby="tabs-with-card-item-3">
                            <img class="shadow-xl shadow-gray-200 rounded-xl"
                                src="{{ url('storage', 'assets/images/service_genset.jpg') }}" alt="Image Description">
                        </div>
                    </div>
                    <!-- End Tab Content -->

                    <!-- SVG Element -->
                    <div class="hidden absolute top-0 end-0 translate-x-20 md:block lg:translate-x-20">
                        <svg class="w-16 h-auto text-orange-500" width="121" height="135" viewBox="0 0 121 135"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 16.4754C11.7688 27.4499 21.2452 57.3224 5 89.0164" stroke="currentColor"
                                stroke-width="10" stroke-linecap="round" />
                            <path d="M33.6761 112.104C44.6984 98.1239 74.2618 57.6776 83.4821 5" stroke="currentColor"
                                stroke-width="10" stroke-linecap="round" />
                            <path d="M50.5525 130C68.2064 127.495 110.731 117.541 116 78.0874" stroke="currentColor"
                                stroke-width="10" stroke-linecap="round" />
                        </svg>
                    </div>
                    <!-- End SVG Element -->
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->

        <!-- Background Color -->
        <div class="absolute inset-0 grid grid-cols-12 size-full">
            <div
                class="col-span-full lg:col-span-7 lg:col-start-6 bg-gray-100 w-full h-5/6 rounded-xl sm:h-3/4 lg:h-full">
            </div>
        </div>
        <!-- End Background Color -->
    </div>
    <!-- End layanan -->

    <!-- Visi misi -->
    <div class="lg:py-20 py-10 grid lg:grid-cols-2 gap-8 lg:gap-12 lg:mt-14 px-4">
        <!-- Icon Block -->
        <div class="flex gap-x-5">
            <div class="grow">
                <h3 class="text-2xl font-semibold text-gray-800 uppercase text-center mb-4">
                    <div
                        class="before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative inline-flex">
                        Visi
                    </div>
                </h3>
                <p class="mt-1 text-gray-800 text-justify">
                    Menjadi Perusahaan yang terus berkembang, Mampu bersaing dengan sehat dan tumbuh
                    kuat untuk memberikan pelayanan dengan berbagai Alternatif pilihan Produk
                    Berkualitas, Ekonomis dan Mudah Perawatan.
                </p>
            </div>
        </div>
        <!-- End Icon Block -->

        <!-- Icon Block -->
        <div class="flex gap-x-5">
            <div class="grow">
                <h3 class="text-2xl font-semibold text-gray-800 uppercase text-center mb-4">
                    <div
                        class="before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-orange-500 relative inline-flex">
                        Misi
                    </div>
                </h3>
                <ul class="mt-1 space-y-3 text-gray-800 text-justify">
                    <li class="flex space-x-3">
                        <svg class="flex-shrink-0 size-4 mt-0.5 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>
                            Pengembangan karyawan yang berkesinambungan, membentuk team work yang solid
                            dan
                            mensejahterakan karyawan.
                        </span>
                    </li>
                    <li class="flex space-x-3">
                        <svg class="flex-shrink-0 size-4 mt-0.5 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Memberikan solusi terbaik atas permasalahan pelanggan.</span>
                    </li>
                    <li class="flex space-x-3">
                        <svg class="flex-shrink-0 size-4 mt-0.5 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>
                            Senantiasa meningkatkan kualitas pelayanan demi tercapainya kepuasan dan
                            kepercayaan pelanggan.
                        </span>
                    </li>
                    <li class="flex space-x-3">
                        <svg class="flex-shrink-0 size-4 mt-0.5 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Menjaga etika bisnis.</span>
                    </li>
                    <li class="flex space-x-3">
                        <svg class="flex-shrink-0 size-4 mt-0.5 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Mengelola dan membangun perusahaan secara profesional.</span>
                    </li>
                    <li class="flex space-x-3">
                        <svg class="flex-shrink-0 size-4 mt-0.5 text-gray-800" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Pertumbuhan modal perusahaan yang konsisten.</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Icon Block -->
        <!-- End Col -->
    </div>
    <!-- End Visi misi -->
</div>
<!-- End About -->
