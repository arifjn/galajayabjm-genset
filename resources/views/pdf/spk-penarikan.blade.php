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

    <title>SPK Penarikan</title>

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
                SURAT PERINTAH KERJA (SPK)
                <br>
                PENARIKAN GENSET
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
                    <td>Nama Mekanik</td>
                    <td>
                        :
                        @foreach ($plan->users as $u)
                            {{ ucwords($u->name) }}{{ $loop->last ? '' : ', ' }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>
                        :
                        {{ Carbon::parse($plan->tanggal_job)->translatedFormat('d F Y') }}
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

        <div style="font-size: 14px; margin-top: -14px">
            <p class="mb-5">
                Sehubungan dengan berakhirnya masa sewa Genset di lokasi {{ $plan->transaction->customer->alamat }} pada
                tanggal {{ Carbon::parse($plan->transaction->tgl_selesai)->translatedFormat('d F Y') }}, melalui surat
                ini kami
                memerintahkan Saudara
                @foreach ($plan->users as $u)
                    {{ ucwords($u->name) }}{{ $loop->last ? '' : ', ' }}
                @endforeach beserta tim untuk melakukan penarikan genset tersebut.
            </p>
            {{-- <span>Berikut rincian genset yang akan ditarik:</span> --}}
            <table border="1" id="table1" style="background-color: rgb(230, 230, 230); margin-top: 0px">
                <thead>
                    <tr>
                        <th align="center" width="1%">No</th>
                        <th>Genset</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center">1</td>
                        <td>
                            @foreach ($plan->gensets as $gs)
                                {{ str()->upper($gs->brand_engine) }}
                                {{ $gs->kapasitas }} KVA
                                @if (!$loop->last)
                                    <br>
                                @endif
                            @endforeach
                        </td>
                        <td>{{ Carbon::parse($plan->transaction->tgl_sewa)->translatedFormat('d F Y') }}</td>
                        <td>{{ Carbon::parse($plan->transaction->tgl_selesai)->translatedFormat('d F Y') }}</td>
                    </tr>
                </tbody>
            </table>

            <p class="mt-5">
                Demikian surat pengembalian ini kami sampaikan. Kami ucapkan terima kasih atas kepercayaan dan
                kerjasamanya selama masa sewa. Semoga kita dapat menjalin kerja sama kembali di masa yang akan datang.
            </p>
        </div>

    </main>

    <footer style="font-size: 14px;">
        <table id="tableTtd" class="text-center">
            <tr>
                <td>Mekanik</td>
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
