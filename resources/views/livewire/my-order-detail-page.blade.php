<div class="w-full max-w-[85rem] py-20 px-4 sm:px-6 lg:px-24 mx-auto">
    <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline mb-6"
        href="{{ route('order', auth()->guard('customer')->user()->id) }}">
        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"></path>
        </svg>
        Back to Orders
    </a>
    <div class="flex flex-col gap-y-4 lg:flex-row justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-slate-500">Order Details</h1>
        @if ($order->status_transaksi != 'cancel')
            <button type="button" data-hs-overlay="#hs-cancelled-order-modal"
                class="py-1.5 px-3 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                Cancel
            </button>
        @endif
    </div>

    <div class="p-10 bg-white shadow-sm justify-center items-center border border-dashed border-gray-200 rounded-xl">
        <!-- Stepper -->
        <div data-hs-stepper='{"currentIndex": {{ $currentStep }}}'>
            <!-- Stepper Nav -->
            <ol class="flex items-center w-full text-sm font-medium justify-center text-gray-500 sm:text-base">
                <li
                    class="flex md:w-full items-center sm:after:content-[''] after:w-full after:h-1 after:border-b {{ $currentStep > 1 ? 'after:border-teal-200' : 'after:border-gray-200' }} after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    @if ($order->status_transaksi == 'penawaran' && $currentStep == 1)
                        <span
                            class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-indigo-200 text-indigo-500">
                            <span
                                class="me-2 text-sm bg-indigo-200 rounded-full size-6 flex items-center justify-center">1</span>
                            <span class="hidden sm:inline-flex sm:ms-2">Penawaran</span>
                        </span>
                    @elseif($order->status_transaksi != 'penawaran' && $order->status_transaksi != 'cancel')
                        <span
                            class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-teal-500 text-teal-500">
                            <svg class="size-6 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="hidden sm:inline-flex sm:ms-2">Penawaran</span>
                        </span>
                    @else
                        <span
                            class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                            <span
                                class="me-2 text-sm bg-gray-200 rounded-full size-6 flex items-center justify-center">2</span>
                            <span class="hidden sm:inline-flex sm:ms-2">Penawaran</span>
                        </span>
                    @endif
                </li>
                <li
                    class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b {{ $currentStep > 2 ? 'after:border-teal-200' : 'after:border-gray-200' }} after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                    @if ($order->status_transaksi == 'pembayaran' && $currentStep == 2)
                        <span
                            class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-indigo-200 text-indigo-500">
                            <span
                                class="me-2 text-sm bg-indigo-200 rounded-full size-6 flex items-center justify-center">2</span>
                            <span class="hidden sm:inline-flex sm:ms-2">Pembayaran</span>
                        </span>
                    @elseif(
                        $order->status_transaksi != 'penawaran' &&
                            $order->status_transaksi != 'pembayaran' &&
                            $order->status_transaksi != 'cancel')
                        <span
                            class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-teal-500 text-teal-500">
                            <svg class="size-6 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="hidden sm:inline-flex sm:ms-2">Pembayaran</span>
                        </span>
                    @else
                        <span
                            class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200">
                            <span
                                class="me-2 text-sm bg-gray-200 rounded-full size-6 flex items-center justify-center">2</span>
                            <span class="hidden sm:inline-flex sm:ms-2">Pembayaran</span>
                        </span>
                    @endif
                </li>
                <li class="flex items-center">
                    @if ($order->status_transaksi == 'dibayar' || ($order->status_transaksi == 'delivery' && $currentStep == 3))
                        <span class="flex items-cente text-indigo-500">
                            <span
                                class="me-2 text-sm bg-indigo-200 rounded-full size-6 flex items-center justify-center">3</span>
                            <span class="hidden sm:inline-flex sm:ms-2">Pengiriman</span>
                        </span>
                    @elseif ($order->status_transaksi == 'success' && $order->status_transaksi != 'cancel')
                        <span class="flex items-center text-teal-500">
                            <svg class="size-6 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="hidden sm:inline-flex sm:ms-2">Pengiriman</span>
                        </span>
                    @else
                        <span class="flex items-center">
                            <span
                                class="me-2 text-sm bg-gray-200 rounded-full size-6 flex items-center justify-center">3</span>
                            <span class="hidden sm:inline-flex sm:ms-2">Pengiriman</span>
                        </span>
                    @endif
                </li>
            </ol>
            <!-- End Stepper Nav -->

            <!-- Stepper Content -->
            <div class="mt-8 sm:mt-12">
                @if ($currentStep == 1)
                    <!-- First Contnet -->
                    <div data-hs-stepper-content-item='{"index": 1}'>
                        <!-- Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mt-5">
                            <!-- Card -->
                            <div class="flex flex-col bg-white border shadow-sm rounded-xl">
                                <div class="p-4 md:p-5 flex gap-x-4">
                                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            width="24" height="24" stroke-width="2" stroke="currentColor"
                                            class="flex-shrink-0 size-5 text-gray-600">
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
                                        <svg class="flex-shrink-0 size-5 text-gray-600"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 22h14" />
                                            <path d="M5 2h14" />
                                            <path
                                                d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                                            <path
                                                d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
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
                                        <svg class="flex-shrink-0 size-5 text-gray-600"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                        @if ($order->status_transaksi == 'penawaran')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full ">
                                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" width="24" height="24">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'pembayaran' ? 'Proses Pembayaran' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'dibayar')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                    </svg>


                                                    {{ $order->status_transaksi == 'dibayar' ? 'Dibayar' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'delivery')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-cyan-100 text-cyan-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'delivery' ? 'Delivery' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'success')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-green-100 text-green-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'success' ? 'Success' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'cancel')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
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
                        <!-- End Grid -->

                        <!-- Table -->
                        <div class="flex flex-col md:flex-row gap-8 mt-4">
                            <div class="md:w-3/4">
                                <div class="flex flex-col bg-white rounded-lg shadow-sm p-4 border mb-4">
                                    <div class="-m-1.5 overflow-x-auto">
                                        <div class="p-1.5 min-w-full inline-block align-middle">
                                            <div class="overflow-hidden">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                Penawaran</th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                Brand Engine</th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                Kapasitas</th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                Perusahaan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                @if ($order->subject == 'sewa')
                                                                    Sewa Genset
                                                                @elseif ($order->subject == 'pengadaan')
                                                                    Pengadaan Genset Baru
                                                                @elseif ($order->subject == 'service')
                                                                    Service Genset
                                                                @endif
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ $order->brand_engine }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ $order->kapasitas }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ $order->perusahaan ? $order->perusahaan : '-' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col bg-white rounded-lg shadow-sm p-4 border">
                                    <div class="-m-1.5 overflow-x-auto">
                                        <div class="p-1.5 min-w-full inline-block align-middle">
                                            <div class="overflow-hidden">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" colspan="2"
                                                                class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                Lokasi Proyek</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ $order->site }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                <span class="font-semibold">Phone:</span>
                                                                {{ $order->customer->no_telp }} -
                                                                {{ $order->customer->name }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:w-1/4">
                                @if ($order->status_transaksi == 'cancel')
                                    <!-- order cancel -->
                                    <div class="bg-white rounded-lg shadow-sm border p-6 text-red-500">

                                        <div class="flex flex-col gap-y-2 justify-center items-center">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-12">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>

                                            <h4 class="text-lg text-center leading-6">
                                                Pesanan sudah dibatalkan!
                                            </h4>

                                        </div>

                                    </div>
                                    <!-- End order cancel -->
                                @else
                                    @if ($order->penawaran == null)
                                        <!-- no quotation yet -->
                                        <div class="bg-white rounded-lg shadow-sm border p-6">

                                            <div class="flex flex-col gap-y-2 justify-center items-center">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-12 text-yellow-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                </svg>


                                                <h4 class="text-lg text-center leading-6 text-gray-500">
                                                    Penawaran harga masih dibuat!
                                                    <br>
                                                    <span class="text-xs">Tunggu beberapa saat lagi 😁</span>
                                                </h4>

                                            </div>

                                        </div>
                                        <!-- End no quotation yet -->
                                    @else
                                        <!-- penawaran -->
                                        <div class="bg-white rounded-lg shadow-sm border p-6">
                                            <div class="flex justify-between mb-2">
                                                <h2 class="font-semibold mb-4">File Penawaran</h2>
                                                <a href="{{ url('storage', $order->penawaran) }}" target="_blank">
                                                    <svg class="size-6 text-red-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                                    </svg>

                                                </a>
                                            </div>

                                            <div
                                                class="flex flex-col justify-center items-center max-w-sm mb-4 rounded-lg overflow-hidden">
                                                <iframe class="max-w-full"
                                                    src="{{ url('storage', $order->penawaran) }}">
                                                </iframe>
                                                <a href="{{ url('storage', $order->penawaran) }}" target="_blank"
                                                    class="bg-red-500 text-center text-white hover:bg-red-600 p-1.5 w-full">Lihat
                                                    PDF</a>
                                            </div>

                                            @if ($order->status_transaksi == 'penawaran')
                                                <div class="flex justify-between">
                                                    <button type="button" data-hs-overlay="#hs-revisi-order-modal"
                                                        class="py-1 px-2 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-yellow-500 text-white hover:bg-yellow-600 disabled:opacity-50 disabled:pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" width="24" height="24"
                                                            stroke-width="1.5" stroke="currentColor"
                                                            class="flex-shrink-0 size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                        </svg>
                                                        Revisi
                                                    </button>
                                                    <button type="button" data-hs-overlay="#hs-confirm-order-modal"
                                                        class="py-1 px-2 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-green-500 text-white hover:bg-green-600 disabled:opacity-50 disabled:pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" width="24" height="24"
                                                            stroke-width="1.5" stroke="currentColor"
                                                            class="flex-shrink-0 size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m4.5 12.75 6 6 9-13.5" />
                                                        </svg>
                                                        Konfirmasi
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        @if ($order->status_transaksi == 'penawaran')
                                            <p
                                                class="flex items-center justify-center gap-x-1 text-[0.6rem] bg-gray-100 p-2 rounded-lg text-center mt-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                </svg>

                                                Konfirmasi untuk ke tahap
                                                selanjutnya!
                                            </p>
                                        @endif
                                        <!-- End penawaran -->
                                    @endif
                                @endif
                            </div>

                        </div>
                        <!-- End Table -->

                        <!-- Button Group -->
                        <div class="mt-5 flex justify-end items-center gap-x-2">
                            <button type="button"
                                wire:click="{{ $order->status_transaksi == 'penawaran' || $order->status_transaksi == 'cancel' ? '' : 'firstStepSubmit' }}"
                                {{ $order->status_transaksi == 'penawaran' || $order->status_transaksi == 'cancel' ? 'disabled' : '' }}
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-indigo-500 text-white hover:bg-indigo-600 disabled:opacity-50 disabled:pointer-events-none">
                                Next
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- End Button Group -->
                    </div>
                    <!-- End First Contnet -->
                @elseif ($currentStep == 2)
                    <!-- Second Content -->
                    <div data-hs-stepper-content-item='{"index": 2}'>
                        <!-- Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mt-5">
                            <!-- Card -->
                            <div class="flex flex-col bg-white border shadow-sm rounded-xl">
                                <div class="p-4 md:p-5 flex gap-x-4">
                                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            width="24" height="24" stroke-width="2" stroke="currentColor"
                                            class="flex-shrink-0 size-5 text-gray-600">
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
                                        <svg class="flex-shrink-0 size-5 text-gray-600"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 22h14" />
                                            <path d="M5 2h14" />
                                            <path
                                                d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                                            <path
                                                d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
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
                                        <svg class="flex-shrink-0 size-5 text-gray-600"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                        @if ($order->status_transaksi == 'penawaran')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full ">
                                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" width="24" height="24">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'pembayaran' ? 'Proses Pembayaran' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'dibayar')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                    </svg>


                                                    {{ $order->status_transaksi == 'dibayar' ? 'Dibayar' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'delivery')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-cyan-100 text-cyan-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'delivery' ? 'Delivery' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'success')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-green-100 text-green-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'success' ? 'Success' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'cancel')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
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
                        <!-- End Grid -->

                        <div class="flex flex-col md:flex-row gap-8 mt-4">
                            <div class="md:w-3/4">
                                <div
                                    class="flex flex-col gap-y-4 md:justify-between md:flex-row bg-gray-100 border border-gray-200 shadow-sm rounded-xl p-5 md:px-8 md:py-5 mb-4">
                                    <div>
                                        <p class="text-sm">Nama Bank :</p>
                                        <p class="font-semibold text-sm md:text-base uppercase">Bank Central Asia (BCA)
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm">Atas Nama :</p>
                                        <p class="font-semibold text-sm md:text-base uppercase">PT. Gala Jaya
                                            Banjarmasin
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm">No. Rekening :</p>
                                        <p class="font-semibold text-sm md:text-base uppercase">0511-788-578</p>
                                    </div>
                                </div>
                                <div class="flex flex-col bg-white rounded-lg shadow-sm p-4 border">
                                    <div class="-m-1.5 overflow-x-auto">
                                        <div class="p-1.5 min-w-full inline-block align-middle">
                                            <div class="overflow-hidden">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 uppercase">
                                                            Harga {{ $order->subject }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                            :
                                                            {{ $order->harga ? Number::currency($order->harga, 'IDR', 'id') : 0 }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 uppercase">
                                                            Mob Demob
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                            :
                                                            {{ $order->mob_demob ? Number::currency($order->mob_demob, 'IDR', 'id') : 0 }}
                                                        </td>
                                                    </tr>
                                                    <tr class="border-b border-b-gray-200">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 uppercase">
                                                            Operator
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                            :
                                                            {{ $order->biaya_operator ? Number::currency($order->biaya_operator, 'IDR', 'id') : 0 }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 uppercase">
                                                            Sub Total
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                            :
                                                            {{ $order->sub_total ? Number::currency($order->sub_total, 'IDR', 'id') : 0 }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 uppercase">
                                                            PPN {{ $order->ppn }}%
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                            :
                                                            {{ $order->ppn ? Number::currency(($order->sub_total * $order->ppn) / 100, 'IDR', 'id') : 0 }}
                                                        </td>
                                                    </tr>
                                                    <tfoot class="bg-gray-100 font-semibold">
                                                        <tr>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 uppercase">
                                                                Grand Total
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                :
                                                                {{ $order->grand_total ? Number::currency($order->grand_total, 'IDR', 'id') : 0 }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- bukti bayar -->
                            <div class="md:w-1/4" wire:ignore>
                                <div
                                    class="max-w-sm mx-auto bg-white rounded-lg shadow-sm border overflow-hidden items-center">
                                    @if ($order->bukti_tf == null)
                                        <form wire:submit.prevent='save'>
                                            <div class="px-4 py-6">
                                                <div id="file-preview"
                                                    class="max-w-sm p-6 mb-4 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-center mx-auto text-center cursor-pointer">
                                                    <input id="bukti_tf" type="file" class="hidden"
                                                        wire:model="bukti_tf" required />
                                                    <label for="bukti_tf" class="cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="w-8 h-8 text-gray-700 mx-auto mb-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                                        </svg>
                                                        <h5
                                                            class="mb-2 text-xl font-bold tracking-tight text-gray-700">
                                                            Upload
                                                            Bukti Pembayaran</h5>
                                                        <p class="font-normal text-sm text-gray-400 md:px-6">Pilih file
                                                            berukuran
                                                            minimal <b class="text-gray-600">2mb</b> dengan format <b
                                                                class="text-gray-600">PDF</b>.</p>
                                                        <span id="filename"
                                                            class="text-gray-500 bg-gray-200 z-50"></span>
                                                    </label>
                                                </div>
                                                <div class="flex items-center justify-center">
                                                    <div class="w-full" wire:loading.remove wire:target='save'>
                                                        <button type="submit"
                                                            class="w-full text-white bg-green-500 hover:bg-green-500/90 focus:ring-4 focus:outline-none focus:ring-green-500/50 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center mr-2 mb-2 cursor-pointer">
                                                            <span class="text-center ml-2">Kirim</span>
                                                        </button>
                                                    </div>
                                                    <div class="w-full" wire:loading wire:target='save'>
                                                        <label
                                                            class="w-full text-white bg-green-500/75 font-medium rounded-lg text-sm px-5 py-2.5 justify-center mr-2 mb-2 inline-flex items-center gap-x-2">
                                                            <div
                                                                class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-white rounded-full">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            Uploading ...
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <div class="bg-white rounded-lg shadow-sm border p-6">
                                            <div class="flex justify-between mb-2">
                                                <h2 class="font-semibold mb-4">Bukti Pembayaran</h2>
                                                <a href="{{ url('storage', $order->bukti_tf) }}" target="_blank">
                                                    <svg class="size-6 text-red-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                                    </svg>

                                                </a>
                                            </div>

                                            <div
                                                class="flex flex-col justify-center items-center max-w-sm mb-4 rounded-lg overflow-hidden">
                                                <iframe class="max-w-full"
                                                    src="{{ url('storage', $order->bukti_tf) }}">
                                                </iframe>
                                                <a href="{{ url('storage', $order->bukti_tf) }}" target="_blank"
                                                    class="bg-orange-500 text-center text-white hover:bg-orange-600 p-1.5 w-full">Lihat
                                                    PDF</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if ($order->status_transaksi == 'pembayaran' && $order->bukti_tf != null)
                                    <p
                                        class="flex items-center justify-center gap-x-1 text-[0.6rem] bg-gray-100 p-2 rounded-lg text-center mt-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                        </svg>

                                        Tunggu konfirmasi dari admin untuk lanjut!
                                    </p>
                                @endif
                            </div>
                            <!-- End bukti bayar -->
                        </div>

                        <!-- Button Group -->
                        <div class="mt-5 flex justify-between items-center gap-x-2">
                            <button type="button" wire:click='backStep(1)'
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg>
                                Back
                            </button>
                            <button type="button"
                                onclick="{{ $order->status_transaksi == 'pembayaran' ? '' : 'window.location.reload();' }}"
                                {{ $order->status_transaksi == 'pembayaran' ? 'disabled' : '' }}
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-indigo-500 text-white hover:bg-indigo-600 disabled:opacity-50 disabled:pointer-events-none">
                                Next
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- End Button Group -->
                    </div>
                    <!-- End Second Content -->
                @elseif ($currentStep == 3)
                    <!-- Third Content -->
                    <div data-hs-stepper-content-item='{"index": 3}'>
                        <!-- Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mt-5">
                            <!-- Card -->
                            <div class="flex flex-col bg-white border shadow-sm rounded-xl">
                                <div class="p-4 md:p-5 flex gap-x-4">
                                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            width="24" height="24" stroke-width="2" stroke="currentColor"
                                            class="flex-shrink-0 size-5 text-gray-600">
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
                                        <svg class="flex-shrink-0 size-5 text-gray-600"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 22h14" />
                                            <path d="M5 2h14" />
                                            <path
                                                d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                                            <path
                                                d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
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
                                        <svg class="flex-shrink-0 size-5 text-gray-600"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                        @if ($order->status_transaksi == 'penawaran')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full ">
                                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" width="24" height="24">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'pembayaran' ? 'Proses Pembayaran' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'dibayar')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                    </svg>


                                                    {{ $order->status_transaksi == 'dibayar' ? 'Dibayar' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'delivery')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-cyan-100 text-cyan-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'delivery' ? 'Delivery' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'success')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-green-100 text-green-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'success' ? 'Success' : '' }}
                                                </span>
                                            </div>
                                        @elseif ($order->status_transaksi == 'cancel')
                                            <div class="mt-1 flex items-center gap-x-2">
                                                <span
                                                    class="py-2 px-2.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-3.5">
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
                        <!-- End Grid -->

                        <div class="flex flex-col md:flex-row gap-8 mt-4">
                            @if ($order->status_transaksi === 'delivery')
                                <div class="md:w-3/4">
                                    <div class="flex">
                                        <div class="flex bg-gray-100 hover:bg-gray-200 rounded-lg transition p-1">
                                            <nav class="flex space-x-1" aria-label="Tabs" role="tablist">
                                                <button type="button"
                                                    class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-gray-800 disabled:opacity-50 disabled:pointer-events-none active"
                                                    id="segment-item-1" data-hs-tab="#segment-1"
                                                    aria-controls="segment-1" role="tab">
                                                    Jadwal Berangkat
                                                </button>
                                                <button type="button"
                                                    class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-gray-800 disabled:opacity-50 disabled:pointer-events-none"
                                                    id="segment-item-2" data-hs-tab="#segment-2"
                                                    aria-controls="segment-2" role="tab">
                                                    Mob Demob
                                                </button>
                                            </nav>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div id="segment-1" role="tabpanel" aria-labelledby="segment-item-1">
                                            <div class="flex flex-col bg-white rounded-lg shadow-sm p-4 border mb-4">
                                                <div class="-m-1.5 overflow-x-auto">
                                                    <div class="p-1.5 min-w-full inline-block align-middle">
                                                        <div class="overflow-hidden">
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead class="bg-gray-50">
                                                                    <tr>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Customer</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Alamat</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Genset</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Jobdesk</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Plan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody
                                                                    class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                                    <tr>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            PT. Abipraya Perkasa</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            Site IKN</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            Cummins 200 KVA</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            Delivery</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            20 Juli 2024</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col bg-white rounded-lg shadow-sm p-4 border">
                                                <div class="-m-1.5 overflow-x-auto">
                                                    <div class="p-1.5 min-w-full inline-block align-middle">
                                                        <div class="overflow-hidden">
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead class="bg-gray-50">
                                                                    <tr>
                                                                        <th scope="col" colspan="2"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Operator</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            Hudry, Agus
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            <span class="font-semibold">Phone:</span>
                                                                            089555182901
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="segment-2" class="hidden" role="tabpanel"
                                            aria-labelledby="segment-item-2">
                                            <div class="flex flex-col bg-white rounded-lg shadow-sm p-4 border">
                                                <div class="-m-1.5 overflow-x-auto">
                                                    <div class="p-1.5 min-w-full inline-block align-middle">
                                                        <div class="overflow-hidden">
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead class="bg-gray-50">
                                                                    <tr>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Nama Supir</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            No. Telp</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Jenis Mobil</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Plat</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody
                                                                    class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                                    <tr>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                            Iwan</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            081292348812</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            Truk</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            DA32001F</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="md:w-3/4">
                                    <div
                                        class="flex flex-col justify-center bg-white rounded-lg shadow-sm p-4 border text-center">
                                        <div class="flex flex-col gap-y-2 justify-center items-center py-12">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="size-28 text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                                            </svg>


                                            <h4 class="text-2xl text-center leading-8 text-gray-500">
                                                Jadwal masih diproses <br> Silakan ditunggu! 😁
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- invoice -->
                            <div class="md:w-1/4">
                                <div
                                    class="max-w-sm mx-auto bg-white rounded-lg shadow-sm border overflow-hidden items-center">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                    Invoice</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    <button type="button"
                                                        class="w-full py-3 px-4 inline-flex justify-between items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                                                        Lihat Invoice
                                                        <svg class="size-6" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End invoice -->
                        </div>

                        <!-- Button Group -->
                        <div class="mt-5 flex justify-between items-center gap-x-2">
                            <button type="button" wire:click='backStep(2)'
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg>
                                Back
                            </button>
                            {{-- <button type="button"
                                wire:click="{{ $order->status_transaksi == 'pembayaran' ? '' : 'firstStepSubmit' }}"
                                {{ $order->status_transaksi == 'pembayaran' ? 'disabled' : '' }}
                                class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-indigo-500 text-white hover:bg-indigo-600 disabled:opacity-50 disabled:pointer-events-none">
                                Next
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg>
                            </button> --}}
                        </div>
                        <!-- End Button Group -->
                    </div>
                    <!-- End Third Content -->
                @else
                    <h1>Final</h1>
                @endif

                <!-- Final Contnet -->
                <div data-hs-stepper-content-item='{"isFinal": true}' style="display: none;">
                    <div
                        class="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl">
                        <h3 class="text-gray-500">
                            Final content
                        </h3>
                    </div>
                </div>
                <!-- End Final Contnet -->

            </div>
            <!-- End Stepper Content -->
        </div>
        <!-- End Stepper -->
    </div>
    <!-- Modal Cancel Order -->
    @livewire('partials.modals.modal-cancelled-order', ['order_id' => $order->order_id])
    <!-- End Modal Cancel Order -->

    <!-- Modal Revisi Order -->
    @livewire('partials.modals.modal-revisi-order', ['order_id' => $order->order_id])
    <!-- End Modal Revisi Order -->

    <!-- Modal Confirm Order -->
    @livewire('partials.modals.modal-confirm-order', ['order_id' => $order->order_id])
    <!-- End Modal Confirm Order -->
</div>
