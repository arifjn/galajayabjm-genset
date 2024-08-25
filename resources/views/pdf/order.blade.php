<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Laporan Transaksi</title>

    <link rel="stylesheet" href="./storage/assets/laporan-css/style.css">

</head>

<body>
    <header class="text-center">
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="20%">
                                <img src="./storage/assets/logo/logo_only.png" width="80%" alt=""
                                    class="my-4">
                            </td>
                            <td class="fw-bold" style="font-size: 18px">
                                PT. GALA JAYA BANJARMASIN <br>
                                Heavy Equipment Spare Part Specialist <br>
                                Komatsu, Hitachi,Caterpillar, etc. <br>
                                Generating Set 10-1000 kVA (Sales, Rental, Spare Parts, <br> & Service)
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="3%">
                    <table style="font-size: 14px">
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

    <main>

        <h2 class="text-uppercase fw-bold text-center my-4">
            Laporan Riwayat Transaksi
        </h2>

        <table border="1" id="table1">
            <thead>
                <tr>
                    <th align="center" width="1%">No</th>
                    <th>Order ID</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Selesai</th>
                    <th>Customer</th>
                    <th>Subject</th>
                    <th>Kapasitas</th>
                    <th>Perusahaan</th>
                    <th>No. Telp</th>
                    <th>Site</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if (count($orders) > 0)
                    @php $no=1; @endphp
                    @foreach ($orders as $order)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            <td>{{ $order->order_id }}
                            </td>
                            <td>{{ Carbon::parse($order->tgl_sewa)->translatedFormat('d F Y') }}</td>
                            <td>{{ Carbon::parse($order->tgl_selesai)->translatedFormat('d F Y') }}</td>
                            <td>
                                {{ ucwords($order->customer->name) }}
                            </td>
                            <td>
                                {{ ucwords($order->subject) }} Genset
                            </td>
                            <td>
                                {{ $order->kapasitas }}
                            </td>
                            <td>
                                {{ $order->customer->perusahaan ? str()->upper($order->customer->perusahaan) : '-' }}
                            </td>
                            <td>
                                {{ $order->customer->no_telp }}
                            </td>
                            <td>
                                {{ $order->site }}
                            </td>
                            <td>
                                {{ str()->title($order->status_transaksi) }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="10">Belum ada data!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </main>

    <br>
    <br>

    <footer class="mt-2 text-end">
        <div style="font-size: 13px">
            <p>Banjarmasin, {{ Carbon::now()->translatedFormat('d F Y') }}</p>
            <p style="margin-top: -0.50rem" class="fw-bold mb-4">
                a.n Manajer Operasional Banjarmasin
            </p>
            <br>
            <br>
            <p style="margin-top: -0.80rem" class="fw-bold mt-4">
                Khairun Nisa, S.E
            </p>
        </div>
    </footer>

</body>

</html>
