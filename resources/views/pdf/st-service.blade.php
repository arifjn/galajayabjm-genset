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

    <title>Surat Tugas Mekanik</title>

    {{-- <link rel="stylesheet" href="{{ url('assets/laporan-css/style.css') }}"> --}}
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
            font-size: 11px;
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
                                <span style="font-size: 18px">
                                    PT. GALA JAYA BANJARMASIN <br>
                                </span>
                                <span style="font-size: 12px">
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

        <div class="text-uppercase fw-bold text-center my-4" style="margin-top: -12px">
            <p class="uppercase">
                SURAT TUGAS MEKANIK
            </p>
            <p style="margin-top: -12px; font-size: 11px">
                No : {{ $plan->id }}/GJ-BJM/STM/{{ $plan->created_at->format('Y') }}
            </p>
        </div>

        <table style="font-size: 12px">
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
                            {{ ucwords($u->name) }}
                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Alat Transportasi</td>
                    <td>
                        :
                        ...........................................
                    </td>
                </tr>
                <tr>
                    <td>Deskripsi Job</td>
                    <td>
                        :
                        Service & Maintenance Check
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

        <table style="font-size: 12px">
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
                    <td>Alamat</td>
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

        <table style="font-size: 12px">
            <thead>
                <tr>
                    <th colspan="3" class="text-start">
                        <u>Tanggal (Hari/Tanggal/Jam)</u>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Berangkat</td>
                    <td>
                        :
                        ................, ................... Pkl ............. WITA
                    </td>
                </tr>
                <tr>
                    <td>Tiba Lokasi</td>
                    <td>
                        :
                        ................, ................... Pkl ............. WITA
                    </td>
                </tr>
                <tr>
                    <td>Kembali Lokasi</td>
                    <td>
                        :
                        ................, ................... Pkl ............. WITA
                    </td>
                </tr>
                <tr>
                    <td>Sampai Kantor</td>
                    <td>
                        :
                        ................, ................... Pkl ............. WITA
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table style="font-size: 12px">
            <thead>
                <tr>
                    <th>
                        Hasil Pekerjaan Mekanik :
                    </th>
                    <th>
                        <span style="font-family: DejaVu Sans, sans-serif;">▢</span>
                        Baik
                    </th>
                    <th>
                        <span style="font-family: DejaVu Sans, sans-serif;">▢</span>
                        Cukup
                    </th>
                    <th>
                        <span style="font-family: DejaVu Sans, sans-serif;">▢</span>
                        Tidak Baik
                    </th>
                </tr>
            </thead>
        </table>

    </main>


    <footer style="font-size: 12px" class="mt-2">
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
