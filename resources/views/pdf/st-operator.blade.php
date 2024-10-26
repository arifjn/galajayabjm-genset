<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Surat Tugas Operator</title>

    <link rel="stylesheet" href="./storage/assets/laporan-css/style.css">

    <style>
        * {
            font-family: Arial, sans-serif;
        }

        #tableTtd {
            border-collapse: collapse;
            width: 100%;
            margin-top: 32px;
        }

        #tableTtd td,
        #tableTtd th {
            /* border: 1px solid black; */
            padding: 8px;
        }

        #tableTtd th {
            padding-top: 12px;
            padding-bottom: 12px;
            color: black;
            font-size: 12px;
        }

        #tableTtd td {
            /* font-size: 11px; */
        }
    </style>

</head>

<body>
    <header class="text-center">
        <table style="margin-top: -20px">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="20%">
                                <img src="./storage/assets/logo/logo_only.png" width="80%" alt=""
                                    class="my-4">
                            </td>
                            <td class="fw-bold">
                                <span style="font-size: 20px">
                                    PT. GALA JAYA BANJARMASIN <br>
                                </span>
                                <span style="font-size: 16px">
                                    Jl. Pramuka No. 19, RT.32 RW.06; Telp. 0511-3276688 <br>
                                    BANJARMASIN
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>

    <hr class="line" />

    <main style="margin-top: -1rem;">

        <div class="text-uppercase fw-bold text-center mt-4" style="margin-top: -12px">
            <p class="uppercase" style="font-size: 22px">
                SURAT TUGAS OPERATOR
            </p>
            <p style="margin-top: -18px; font-size: 13px">
                No : {{ $plan->id }}/GJ-BJM/SPK/{{ str_replace('GJ-', '', $plan->order_id) }}
            </p>
        </div>

        <table style="font-size: 14px">
            <thead>
                <tr>
                    <th colspan="3" class="text-start">
                        <u>Diberikan Kepada</u>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama Operator</td>
                    <td>
                        :
                        {{ $plan->operator_id ? $plan->operator->name : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Mulai</td>
                    <td>
                        :
                        {{ Carbon::parse($plan->tanggal_job)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Selesai</td>
                    <td>
                        :
                        {{ Carbon::parse($plan->tanggal_kembali)->translatedFormat('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td>Genset</td>
                    <td>
                        :
                        @foreach ($plan->gensets as $gs)
                            {{ str()->upper($gs->brand_engine) }}
                            {{ $gs->kapasitas }} KVA
                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="font-size: 14px">
            <thead>
                <tr>
                    <th colspan="3" class="text-start">
                        <u>Data Informasi Customer</u>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Customer</td>
                    <td>
                        :
                        {{ $plan->transaction->customer->perusahaan ? $plan->transaction->customer->perusahaan : $plan->transaction->customer->name }}
                    </td>
                </tr>
                <tr>
                    <td>Lokasi</td>
                    <td>
                        :
                        {{ $plan->transaction->customer->alamat }}
                    </td>
                </tr>
                <tr>
                    <td>PIC</td>
                    <td>
                        :
                        {{ $plan->transaction->customer->name }}
                    </td>
                </tr>
                <tr>
                    <td>No. HP</td>
                    <td>
                        :
                        {{ $plan->transaction->customer->no_telp }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <div style="font-size: 14px">
            <p>Adapun tugas yang harus dilaksanakan adalah sebagai berikut :</p>
            <ol>
                <li><b>Pemeliharaan Rutin Genset</b> – Melakukan pengecekan dan pemeliharaan genset secara berkala,
                    termasuk
                    pemeriksaan oli, filter, dan komponen lainnya.</li>
                <li><b>Pengoperasian genset</b> – Menjalankan genset sesuai dengan prosedur operasional, terutama saat
                    terjadi pemadaman listrik atau ketika dibutuhkan.</li>
                <li><b>Monitoring kinerja genset</b> – Memastikan kinerja genset selalu optimal dengan melakukan
                    pengawasan terhadap semua indikator fungsi genset.</li>
                <li><b>Pelaporan</b> – Melaporkan kondisi genset secara rutin kepada manajemen atau bagian terkait serta
                    memberikan laporan jika terdapat kendala atau kerusakan.</li>
                <li><b>Tindakan preventif</b> – Mengantisipasi masalah teknis yang mungkin terjadi dan mengambil
                    langkah-langkah untuk mencegah kerusakan pada genset.</li>
            </ol>
        </div>

    </main>

    <footer style="font-size: 14px;">
        <table id="tableTtd" class="text-center">
            <tr>
                <td>Operator</td>
                <td>Pemberi Tugas</td>
                <td>Customer</td>
            </tr>
            <tr>
                <td style="padding: 1.3rem"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    ( ............................ )
                </td>
                <td>
                    ( ............................ )
                </td>
                <td>
                    ( ............................ )
                </td>
            </tr>
        </table>
    </footer>
</body>

</html>
