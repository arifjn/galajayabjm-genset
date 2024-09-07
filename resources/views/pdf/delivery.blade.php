<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Delivery Order</title>

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
                            <td width="10%">
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
                <u>DELIVERY ORDER</u>
            </p>
            <p style="margin-top: -12px; font-size: 11px">
                <u>{{ $plan->order_id }}</u>
            </p>
        </div>

        <table border="1" id="table1" style="font-size: 12px">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <ul>
                            @foreach ($plan->gensets as $gs)
                                <li>
                                    {{ str()->upper($gs->brand_engine) }} {{ $gs->kapasitas }} KVA
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $plan->gensets->count() }} Unit</td>
                    <td>
                        @if ($plan->users->count() > 0)
                            Mekanik :
                            <b>
                                @foreach (json_decode($plan->users) as $user)
                                    {{-- @foreach ($plan->users as $user) --}}
                                    {{ $user->name }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </b>
                            <br>
                        @endif
                        @if ($plan->operator)
                            Operator :
                            <b>
                                {{ $plan->operator?->name }}
                            </b>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

    <footer style="font-size: 12px" class="mt-2 text-end">
        <p>Banjarmasin, {{ Carbon::parse($plan->tanggal_job)->translatedFormat('d F Y') }}</p>

        <table id="tableTtd" style="width: 70%; margin-top: -4px" class="text-center">
            <tr>
                <td>Issued by</td>
                <td>Approved by</td>
                <td>Delivered by</td>
                <td>Received by</td>
            </tr>
            <tr>
                <td style="padding: 2rem"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    ( ......................... )
                </td>
                <td>
                    ( ......................... )
                </td>
                <td>
                    ( ......................... )
                </td>
                <td>
                    ( ......................... )
                </td>
            </tr>
        </table>
    </footer>

</body>

</html>
