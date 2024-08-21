<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mt-5">
    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl">
        <div class="p-4 md:p-5 flex gap-x-4">
            <div class="flex-shrink-0 flex justify-center items-center size-[46px] rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24" height="24"
                    stroke-width="2" stroke="currentColor" class="flex-shrink-0 size-5 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                </svg>
            </div>

            <div class="grow">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        Order ID
                    </p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <div>{{ $order->order_id }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl">
        <div class="p-4 md:p-5 flex gap-x-4">
            <div class="flex-shrink-0 flex justify-center items-center size-[46px] rounded-lg">
                <svg class="flex-shrink-0 size-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 22h14" />
                    <path d="M5 2h14" />
                    <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                    <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
                </svg>
            </div>

            <div class="grow">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        Order Date
                    </p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <h3 class="text-xl font-medium text-gray-800">
                        {{ $order->created_at->format('d-m-Y') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl">
        <div class="p-4 md:p-5 flex gap-x-4">
            <div class="flex-shrink-0 flex justify-center items-center size-[46px] rounded-lg">
                <svg class="flex-shrink-0 size-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
                    <path d="m12 12 4 10 1.7-4.3L22 16Z" />
                </svg>
            </div>

            <div class="grow">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500">
                        Order Status
                    </p>
                </div>
                @if ($plan && $plan->status == 'pending')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-cyan-100 text-cyan-800 rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>

                            {{ $plan->status == 'pending' ? 'Delivery' : '' }}
                        </span>
                    </div>
                @elseif ($plan && $plan->status == 'delivery')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full ">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24"
                                height="24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>


                            {{ $plan->status == 'delivery' ? 'Delivery' : '' }}
                        </span>
                    </div>
                @elseif ($plan && $plan->status == 'rent')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full ">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" width="24"
                                height="24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                            </svg>


                            {{ $plan->status == 'rent' ? 'Rental' : '' }}
                        </span>
                    </div>
                @elseif ($plan && $plan->status == 'success')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-green-100 text-green-800 rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            {{ $plan->status == 'success' ? 'Success' : '' }}
                        </span>
                    </div>
                @elseif ($order->status_transaksi == 'penawaran')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full ">
                            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24"
                                height="24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            {{ $order->status_transaksi == 'penawaran' ? 'Proses Penawaran' : '' }}
                        </span>
                    </div>
                @elseif ($order->status_transaksi == 'pembayaran')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>

                            {{ $order->status_transaksi == 'pembayaran' ? 'Proses Pembayaran' : '' }}
                        </span>
                    </div>
                @elseif ($order->status_transaksi == 'dibayar')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>


                            {{ $order->status_transaksi == 'dibayar' ? 'Dibayar' : '' }}
                        </span>
                    </div>
                @elseif ($order->status_transaksi == 'cancel')
                    <div class="mt-1 flex items-center gap-x-2">
                        <span
                            class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                            {{ $order->status_transaksi == 'cancel' ? 'Cancel' : '' }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End Card -->

</div>
