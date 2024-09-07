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
            INVOICE
        </h2>

        <table class="font-bold">
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

        <table border="1" id="table1" class="font-bold">
            <thead>
                <tr>
                    <th align="center" width="1%">No</th>
                    <th>Keterangan</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center">1</td>
                    <td>
                        {{ $order->genset ? str()->upper($order->genset->tipe_genset) : '-' }} TYPE
                        {{ $order->kapasitas ? $order->kapasitas : $order->genset->kapasitas }} KVA
                    </td>
                    <td>1</td>
                    <td>Unit</td>
                    <td>{{ Number::currency($order->harga, 'IDR', 'id') }}</td>
                </tr>
                <tr>
                    <td align="center">2</td>
                    <td>
                        MOB DEMOB
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ $order->mob_demob ? Number::currency($order->mob_demob, 'IDR', 'id') : 0 }}</td>
                </tr>
                <tr>
                    <td align="center">3</td>
                    <td>
                        OPERATOR
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ $order->biaya_operator ? Number::currency($order->biaya_operator, 'IDR', 'id') : 0 }}</td>
                </tr>
                <tr>
                    <td align="center">4</td>
                    <td>
                        PPN {{ $order->ppn }}%
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ $order->ppn ? Number::currency(($order->sub_total * $order->ppn) / 100, 'IDR', 'id') : 0 }}
                    </td>
                </tr>
                <tr>
                    <td align="center">5</td>
                    <td>
                        GRAND TOTAL
                    </td>
                    <td></td>
                    <td></td>
                    <td>{{ $order->grand_total ? Number::currency($order->grand_total, 'IDR', 'id') : 0 }}</td>
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
        <table class="font-bold">
            <tr>
                <td>
                    Sistem Pembayaran
                </td>
                <td>
                    :
                </td>
                <td>
                    Pelunasan 100% barang akan dikirim selambat – lambatnya 1 minggu setelah pelunasan
                </td>
            </tr>
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
