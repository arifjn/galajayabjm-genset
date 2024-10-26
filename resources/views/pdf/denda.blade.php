<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>INVOICE {{ $order->order_id }}</title>

    <link rel="stylesheet" href="./storage/assets/laporan-css/style.css">

    <style>
        * {
            font-family: Arial, sans-serif;
        }
    </style>

</head>

<body>
    <header class="text-center">
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="20%">
                                <img src="./storage/assets/logo/logo_only.png" width="90%" alt=""
                                    class="my-4">
                            </td>
                            <td class="fw-bold" style="font-size: 15px">
                                PT. GALA JAYA BANJARMASIN <br>
                                Heavy Equipment Spare Part Specialist <br>
                                Komatsu, Hitachi,Caterpillar, etc. <br>
                                Generating Set 10-1000 kVA (Sales, Rental, Spare Parts, <br> & Service)
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="5%">
                    <table style="font-size: 12px">
                        <tr>
                            <td colspan="3">Kantor :</td>
                        </tr>
                        <tr>
                            <td colspan="3">Jl. Pramuka No. 19 RT. 32 RW. 05</td>
                        </tr>
                        <tr>
                            <td>Telp.</td>
                            <td>:</td>
                            <td>&nbsp;&nbsp;0511-3275885, 3276688</td>
                        </tr>
                        <tr>
                            <td>HP</td>
                            <td>:</td>
                            <td>&nbsp;&nbsp;0811-50503636</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>&nbsp;&nbsp;galajayabjm@gmail.com</td>
                        </tr>
                        <tr>
                            <td>Banjarmasin</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>

    <hr class="line" />

    <main style="font-size: 15px">

        <h2 class="fw-bold text-center my-4">
            INVOICE DENDA
        </h2>

        <table style="font-weight: bold">
            <tr>
                <td>
                    Nomor
                </td>
                <td>
                    :
                </td>
                <td>
                    {{-- INV/GJB-{{ $order->created_at->format('d/m/Y') }} --}}
                    INV/{{ $order->order_id }}
                </td>
            </tr>
            <tr>
                <td>
                    Tanggal
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ $order->created_at->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td>
                    Customer
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ $order->customer->perusahaan ? $order->customer->perusahaan : $order->customer->name }}
                </td>
            </tr>
        </table>

        <table border="1" id="table1" style="background-color: rgb(230, 230, 230)">
            <thead>
                <tr>
                    <th align="center" width="1%">No</th>
                    <th>Genset</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Selesai</th>
                    <th>Tanggal Kembali</th>
                    <th>Durasi Sewa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center">1</td>
                    <td>
                        {{ $order->genset ? str()->upper($order->genset->tipe_genset) : '-' }} TYPE
                        {{ $order->kapasitas ? $order->kapasitas : $order->genset->kapasitas }} KVA
                    </td>
                    <td>{{ Carbon::parse($order->tgl_sewa)->translatedFormat('d F Y') }}</td>
                    <td>{{ Carbon::parse($order->tgl_selesai)->translatedFormat('d F Y') }}</td>
                    <td>{{ Carbon::parse($plan->tanggal_kembali)->translatedFormat('d F Y') }}</td>
                    <td>{{ $durasi == '' ? '-' : $durasi }} Hari</td>
                </tr>
            </tbody>
        </table>

        <table border="1" id="table1" style="font-weight: bold">
            <thead>
                <tr>
                    <th align="center" width="1%">No</th>
                    <th>Kelebihan Jam Sewa</th>
                    <th>Total Denda</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center">1</td>
                    <td>
                        {{ $order->overtime }} Jam
                    </td>
                    <td>{{ Number::currency(($order->harga * 0.295 * $order->overtime) / 100, 'IDR', 'ID') }}</td>
                </tr>
                <tr>
                    <td align="center">2</td>
                    <td>
                        PPN {{ $order->ppn }}%
                    </td>
                    <td>{{ Number::currency(((($order->harga * 0.295 * $order->overtime) / 100) * $order->ppn) / 100, 'IDR', 'ID') }}
                    </td>
                </tr>

                <td colspan="2" class="text-center">
                    Grand Total
                </td>
                <td>{{ Number::currency(($order->harga * 0.295 * $order->overtime) / 100 + ((($order->harga * 0.295 * $order->overtime) / 100) * $order->ppn) / 100, 'IDR', 'ID') }}
                </td>
                </tr>
            </tbody>
        </table>

        <br>
        <br>
        <span>
            Demikian invoice ini kami buat atas kerjasamanya tak lupa kami ucapkan banyak terima kasih.
        </span>
        <br>

        <p>
            Keterangan :
        </p>
        <table style="font-weight: bold">
            <tr>
                <td>
                    Bank Account
                </td>
                <td>
                    :
                </td>
                <td>
                    BCA 0511-788-578 a/n PT. Gala Jaya Banjarmasin
                </td>
            </tr>
        </table>
    </main>

    <br>
    <br>

    <footer class="mt-2">
        <div style="font-size: 15px">
            <p style="margin-top: -0.50rem" class="mb-4">
                Hormat kami,
            </p>
            {{-- <br>
            <br> --}}

            <img src="./storage/assets/images/ttd.jpg" width="30%">

            <p style="margin-top: -0.80rem" class="fw-bold mt-4">
                <u>Khairun Nisa, SE</u>
                <br>
                <span>
                    Manager
                </span>
            </p>
        </div>
    </footer>

</body>

</html>
