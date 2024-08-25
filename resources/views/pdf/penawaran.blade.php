<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Penawaran Harga</title>

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

        <p>
            Perihal : <b>Penawaran {{ ucwords($order->subject) }} Genset {{ $order->kapasitas }}</b>
        </p>
        <br>
        <span>
            Kepada :
        </span>
        <br>
        <span>
            <b> {{ $order->customer->perusahaan }}</b>
        </span>
        <br>
        <span>
            <b> {{ $order->site }}</b>
        </span>
        <br>
        <br>
        <span>
            <b> Up. Bapak/Ibu {{ $order->customer->name }}</b>
        </span>
        <br>
        <br>
        <span>
            Dengan hormat,
        </span>
        <br>
        <span>
            Sehubungan dengan adanya kebutuhan {{ ucwords($order->subject) }} Genset kapasitas
            {{ $order->kapasitas ? $order->kapasitas : $order->genset->kapasitas }} KVA
            tipe
            {{ ucwords($order->genset->tipe_genset) }},
            maka dengan ini kami
            memberikan penawaran harga {{ $order->subject }} sebagai berikut:
        </span>
        <br>
        <br>

        <table>
            <tr>
                <td colspan="3">
                    Diesel Genset, {{ ucwords($order->genset->tipe_genset) }} Type, Capacity
                    <b>{{ $order->kapasitas ? $order->kapasitas : $order->genset->kapasitas }} KVA</b>,
                    {{ $order->genset->voltase }} V, {{ $order->genset->phase }}
                    Phase, {{ $order->genset->frekuensi }} Hz, {{ $order->genset->kecepatan }} Rpm :
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    Engine
                </td>
                <td>
                    :
                </td>
                <td>
                    <b>{{ ucwords($order->genset->brand_engine) }} {{ $order->genset->tipe_engine }}</b>,
                    {{ $order->genset->no_silinder }} Cylinder, {{ ucwords($order->genset->pendingin) }} System
                </td>
            </tr>
            <tr>
                <td>
                    Generator
                </td>
                <td>
                    :
                </td>
                <td>
                    <b>{{ ucwords($order->genset->brand_generator) }}</b>,
                    {{ $order->genset->sist_eksitasi }} type, Insulation {{ ucwords($order->genset->insul_class) }}
                    with {{ $order->genset->regulator_tegangan }}
                </td>
            </tr>
            <tr class="font-bold">
                <td>
                    Harga Sewa
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ Number::currency($order->harga, 'IDR', 'id') }}/Unit (Maks. Pemakaian 360 Jam/Unit)
                </td>
            </tr>
            <tr class="font-bold">
                <td>
                    <u>Mob Demob</u>
                </td>
                <td>
                    <u>:</u>
                </td>
                <td>
                    <u>{{ Number::currency($order->mob_demob, 'IDR', 'id') }}/Unit</u>
                </td>
            </tr>
            <tr class="font-bold">
                <td>
                    Sub Total
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ Number::currency($order->sub_total, 'IDR', 'id') }}
                </td>
            </tr>
            <tr class="font-bold">
                <td>
                    PPN {{ $order->ppn }}%
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ Number::currency(($order->sub_total * $order->ppn) / 100, 'IDR', 'id') }}
                </td>
            </tr>
            <tr class="font-bold">
                <td>
                    Grand Total
                </td>
                <td>
                    :
                </td>
                <td>
                    {{ Number::currency($order->grand_total, 'IDR', 'id') }}
                </td>
            </tr>
        </table>

        <br>
        <span>
            <b>*Kelebihan Jam: {{ Number::currency(($order->harga * 0.295) / 100, 'IDR', 'id') }} /Jam (Harga belum
                termasuk PPN
                {{ $order->ppn }}%)</b>
        </span>
        <br>
        <br>
        <span>
            Persyaratan :
        </span>
        <br>
        <ul style="margin-left: 12px; padding:0;">
            <li>Pembayaran {{ ucwords($order->subject) }} <b>“Cash”</b> sebelum unit dikirim ke Lokasi.</li>
            <li style="list-style: none;">Pembayaran dapat dilakukan secara Cash atau Transfer ke :</li>
            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>Nama Bank</td>
                                <td>:</td>
                                <td>Bank Central Asia (BCA)</td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening</td>
                                <td>:</td>
                                <td>0511-788-578</td>
                            </tr>
                        </table>
                    <td>
                        <table>
                            <tr>
                                <td>Atas Nama</td>
                                <td>:</td>
                                <td>PT. Gala Jaya Banjarmasin</td>
                            </tr>
                            <tr>
                                <td>Kantor Cabang</td>
                                <td>:</td>
                                <td>Cabang Banjarmasin</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <li>Mobilisasi - Demobilisasi Genset hanya ditagihkan diawal Periode Sewa</li>
            <li>Genset dikirim setelah melalui <b>Quality Control</b> sehingga dalam keadaan <b>Prima</b>.</li>
            <li>Harga sewa tidak termasuk BBM Solar dan Operator</li>
            <li>Penggantian filter-filter dan oli mesin merupakan tanggungan pemilik Genset.</li>
            <li>Pihak Penyewa bertanggung jawab atas keamanan, kebersihan genset dan kerusakan yang diakibatkan oleh
                kelalaian pihak penyewa.</li>
            <li>Pihak Penyewa bertanggung jawab atas penurunan genset dan penaikkan kembali di lokasi
                sewa</li>
            <li>Segala Perijinan dilokasi sewa menjadi tanggung jawab Penyewa.</li>
            <li>Kontak Person <b>Sales a/n {{ ucwords($order->sale->name) }} {{ $order->sale->no_telp }}</b>.</li>
            <li><b>Penawaran Harga berlaku 14 Hari.</b></li>
        </ul>
        <p>
            Demikian penawaran dari kami, semoga dapat memenuhi kebutuhan Bapak/Ibu. Atas
            perhatian dan
            kerjasamanya, kami ucapkan terima kasih
        </p>
    </main>

    <br>
    <br>

    <footer class="mt-2">
        <div style="font-size: 15px">
            <p>Banjarmasin, {{ $order->created_at->translatedFormat('d F Y') }}</p>
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
