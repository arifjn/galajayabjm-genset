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
                    @if (($plan && $plan->status == 'pending' && $currentStep == 3) || ($plan && $plan->status == 'delivery'))
                        <span class="flex items-cente text-indigo-500">
                            <span
                                class="me-2 text-sm bg-indigo-200 rounded-full size-6 flex items-center justify-center">3</span>
                            <span class="hidden sm:inline-flex sm:ms-2">Pengiriman</span>
                        </span>
                    @elseif (($plan && $plan->status == 'success' && $order->status_transaksi != 'cancel') || ($plan && $plan->status == 'rent'))
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
                        @livewire('partials.cards.card-order', ['order' => $order, 'plan' => $plan])
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
                                                                Tanggal Sewa</th>
                                                            <th scope="col"
                                                                class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                Tanggal Selesai</th>
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
                                                                @endif
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ Carbon\Carbon::parse($order->tgl_sewa)->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ Carbon\Carbon::parse($order->tgl_selesai)->translatedFormat('d F Y') }}
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ $order->kapasitas ? $order->kapasitas : $order->genset->kapasitas }}
                                                                KVA
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                {{ $order->customer->perusahaan ? $order->customer->perusahaan : 'Perorangan' }}
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
                                                                {{ $order->site ? $order->site : $order->customer->alamat }}
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
                                    @if ($order->genset_id == null)
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
                                                <h2 class="font-semibold mb-4">Penawaran</h2>
                                                <a href="{{ route('pdf.penawaran', $order->order_id) }}"
                                                    target="_blank">
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
                                                <a href="{{ route('pdf.penawaran', $order->order_id) }}"
                                                    target="_blank"
                                                    class="bg-red-500 text-center text-white hover:bg-red-600 p-1.5 w-full">
                                                    Lihat Penawaran
                                                </a>
                                            </div>

                                            @if ($order->status_transaksi == 'penawaran')
                                                <div class="flex justify-between">
                                                    <button type="button" data-hs-overlay="#hs-revisi-order-modal"
                                                        class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-semibold rounded-lg border border-transparent bg-yellow-500 text-white hover:bg-yellow-600 disabled:opacity-50 disabled:pointer-events-none">
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
                                                        class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-semibold rounded-lg border border-transparent bg-green-500 text-white hover:bg-green-600 disabled:opacity-50 disabled:pointer-events-none">
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
                                @if ($order->status_transaksi == 'pembayaran') onclick="window.location.reload();" @endif
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
                        @livewire('partials.cards.card-order', ['order' => $order, 'plan' => $plan])
                        <!-- End Grid -->

                        <div class="flex flex-col md:flex-row gap-8 mt-4" wire:ignore>
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
                            <div class="md:w-1/4">
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
                        @livewire('partials.cards.card-order', ['order' => $order, 'plan' => $plan])
                        <!-- End Grid -->

                        <div class="flex flex-col md:flex-row gap-8 mt-4">
                            @if (
                                ($plan && $plan->status === 'pending') ||
                                    ($plan && $plan->status === 'delivery') ||
                                    ($plan && $plan->status === 'rent') ||
                                    ($plan && $plan->status === 'selesai'))
                                <div class="md:w-full">
                                    <div class="flex">
                                        <div class="flex bg-gray-100 hover:bg-gray-200 rounded-lg transition p-1">
                                            <nav class="flex space-x-1" aria-label="Tabs" role="tablist">
                                                <button type="button"
                                                    class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-gray-800 disabled:opacity-50 disabled:pointer-events-none active"
                                                    id="segment-item-1" data-hs-tab="#segment-1"
                                                    aria-controls="segment-1" role="tab">
                                                    Jadwal Berangkat
                                                </button>
                                                @if ($plan->nama_supir)
                                                    <button type="button"
                                                        class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active: hs-tab-active: py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 font-medium rounded-lg hover:hover:text-gray-800 disabled:opacity-50 disabled:pointer-events-none"
                                                        id="segment-item-2" data-hs-tab="#segment-2"
                                                        aria-controls="segment-2" role="tab">
                                                        Mob Demob
                                                    </button>
                                                @endif
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
                                                                            Jobdesk</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Plan</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Customer</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Alamat</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Genset</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody
                                                                    class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                                    <tr>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            {{ ucwords($plan->jobdesk) }}</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            {{ \Carbon\Carbon::parse($plan->tanggal_job)->translatedFormat('d F Y') }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            {{ $plan->transaction->customer->perusahaan ? $plan->transaction->customer->perusahaan : $plan->transaction->customer->name }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            {{ $plan->transaction->site }}</td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            @foreach ($plan->gensets as $genset)
                                                                                <ul>
                                                                                    <li> •
                                                                                        {{ ucwords($genset->brand_engine) }}
                                                                                        {{ $genset->kapasitas }} KVA
                                                                                    </li>
                                                                                </ul>
                                                                            @endforeach
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
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            Mekanik</th>
                                                                        <th scope="col"
                                                                            class="px-6 py-3 text-start text-sm font-medium text-gray-500 uppercase">
                                                                            No. HP</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($plan->users as $user)
                                                                        <tr>
                                                                            <td
                                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                {{ $user->name }}
                                                                            </td>
                                                                            <td
                                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                {{ $user->no_telp }}

                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            {{ $plan->operator->name }}
                                                                        </td>
                                                                        <td
                                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                            {{ $plan->operator->no_telp }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($plan->nama_supir)
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
                                                                                {{ $plan->nama_supir }}</td>
                                                                            <td
                                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                {{ $plan->nohp_supir }}</td>
                                                                            <td
                                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                {{ $plan->jenis_mobil }}</td>
                                                                            <td
                                                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                                                {{ $plan->plat_mobil }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="md:w-full">
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
