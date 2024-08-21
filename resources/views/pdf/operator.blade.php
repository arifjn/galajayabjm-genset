<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Laporan Operator</title>

    <link rel="stylesheet" href="./storage/assets/laporan-css/style.css">

</head>

<body>
    <header class="text-center">
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="5%">
                                <img src="./storage/assets/logo/logo_only.png" width="80%" alt=""
                                    class="my-4">
                            </td>
                            <td width="15%" class="fw-bold" style="font-size: 14px">
                                PT. GALA JAYA BANJARMASIN <br>
                                Heavy Equipment Spare Part Specialist <br>
                                Komatsu, Hitachi,Caterpillar, etc. <br>
                                Generating Set 10-1000 kVA (Sales, Rental, Spare Parts, <br> & Service)
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="3%">
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

    <main>

        <h2 class="text-uppercase fw-bold text-center my-4">
            Laporan Operator {{ Carbon::now()->translatedFormat('d F Y') }}
        </h2>

        <table border="1" id="table1">
            <thead>
                <tr>
                    <th align="center" width="1%">No</th>
                    <th>Nama Lengkap</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @foreach ($operators as $operator)
                    <tr>
                        <td align="center">{{ $no++ }}</td>
                        <td>{{ str()->title($operator->name) }}</td>
                        <td>{{ $operator->no_telp }}</td>
                        <td>{{ $operator->email }}</td>
                        <td>{{ $operator->alamat }}</td>
                        <td>{{ $operator->tgl_lahir->translatedFormat('d F Y') }}</td>
                        <td>{{ str()->title($operator->status) }}</td>
                    </tr>
                @endforeach
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
