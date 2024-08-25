<div class="w-full max-w-[85rem] min-h-screen py-20 px-4 sm:px-6 lg:px-8 mx-auto size-full">
    <h1 class="text-4xl font-bold text-gray-800">My Orders</h1>
    <div class="flex flex-col bg-white p-5 rounded mt-4 shadow-lg">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">No.
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Order ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Tanggal
                                    Sewa</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Genset</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Perusahaan
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Lokasi
                                    Proyek</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Order
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($orders) > 0)
                                @foreach ($orders as $order)
                                    <tr class="odd:bg-white even:bg-gray-100" wire:key='{{ $order->order_id }}'>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                            {{ $order->order_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ Carbon\Carbon::parse($order->tgl_sewa)->translatedFormat('d F Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            Genset
                                            {{ $order->kapasitas ? $order->kapasitas : $order->genset->kapasitas }} KVA
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $order->customer->perusahaan ? $order->customer->perusahaan : 'Perorangan' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            {{ $order->site ? $order->site : $order->customer->alamat }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                            @if ($order->status_transaksi == 'penawaran')
                                                <span
                                                    class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full ">
                                                    <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" width="16" height="16">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                    </svg>
                                                    {{ $order->status_transaksi == 'penawaran' ? 'Proses Penawaran' : '' }}
                                                </span>
                                            @elseif($order->status_transaksi == 'pembayaran')
                                                <span
                                                    class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="16" height="16" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'pembayaran' ? 'Proses Pembayaran' : '' }}
                                                </span>
                                            @elseif($order->status_transaksi == 'dibayar')
                                                <span
                                                    class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="16" height="16" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                    </svg>

                                                    {{ $order->status_transaksi == 'dibayar' ? 'Dibayar' : '' }}
                                                </span>
                                            @elseif ($order->status_transaksi == 'success')
                                                <span
                                                    class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-green-100 text-green-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="16" height="16" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    {{ ucfirst($order->status_transaksi) }}
                                                </span>
                                            @elseif ($order->status_transaksi == 'cancel')
                                                <span
                                                    class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        width="16" height="16" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="size-2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    {{ $order->status_transaksi == 'cancel' ? 'Cancel' : '' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium gap-x-2 flex justify-end">
                                            <a href="{{ route('order.show', [auth()->guard('customer')->user()->id, $order->order_id]) }}"
                                                class="bg-indigo-600 text-white py-2 px-2 rounded-md hover:bg-indigo-500 inline-flex"><svg
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    width="24" height="24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="odd:bg-white even:bg-gray-100">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-500 text-center text-xl"
                                        colspan="8">
                                        No data found! 🙁
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
