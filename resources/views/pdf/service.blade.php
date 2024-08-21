<?php
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Laporan Service</title>

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
            Service & Check Report
        </h2>

        <table border="1" id="table1" class="mb-8">
            <thead>
                <tr>
                    <th align="center" width="1%">No</th>
                    <th>Tanggal Cek</th>
                    <th>Genset</th>
                    <th>Mekanik</th>
                    <th>Customer</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @if (count($services) > 0)
                    @php $no=1; @endphp
                    @foreach ($services as $service)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            <td>{{ Carbon::parse($service->tgl_cek)->translatedFormat('d F Y') }}</td>
                            <td>
                                {{ $service->genset->brand_engine }} {{ $service->genset->kapasitas }} KVA
                            </td>
                            <td>
                                <ul>
                                    @foreach ($service->users as $u)
                                        <li>
                                            {{ ucwords($u->name) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                {{ $service->transaction->customer->perusahaan ? $service->transaction->customer->perusahaan : $service->transaction->customer->name }}
                            </td>
                            <td>
                                {{ $service->transaction->site }}
                            </td>
                            <td>
                                {{ $service->keterangan ? $service->keterangan : '-' }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center">
                        <td colspan="7">Belum ada data!</td>
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

    @foreach ($services as $service)
        <div class="page_break">
            <h2 class="text-uppercase fw-bold text-center mb-6">
                Service & Maintenance Check Report {{ $service->genset->brand_engine }}
                {{ $service->genset->kapasitas }} KVA
            </h2>
            <div class="mb-4">
                <p>
                    Tanggal : {{ Carbon::parse($service->tgl_cek)->translatedFormat('d F Y') }}
                </p>
                <p>
                    Mekanik :
                <ul>
                    @foreach ($service->users as $u)
                        <li>
                            {{ ucwords($u->name) }}
                        </li>
                    @endforeach
                </ul>
                </p>
                @foreach ($service->foto_service as $foto)
                    <img src="./storage/{{ $foto }}" alt="" height="180" class="me-2 mt-8">
                @endforeach
                <div class="page_break text-center">
                    <img src="./storage/{{ $service->service_report }}" alt="" height="400">
                </div>
                <div class="page_break text-center">
                    <img src="./storage/{{ $service->check_list }}" alt="" height="400">
                </div>
                <div class="page_break text-center">
                    <img src="./storage/{{ $service->part_request }}" alt="" class="cover-image"
                        height="400">
                </div>
            </div>
        </div>
    @endforeach

</body>

</html>
