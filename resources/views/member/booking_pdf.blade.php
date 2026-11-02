<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .info {
            width: 50%;
            margin: 0 auto;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .info th,
        .info td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .info th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .data-booking {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .data-booking th,
        .data-booking td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .data-booking th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        .data-booking tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .data-booking tr:hover {
            background-color: #ddd;
        }

        .data-booking td {
            color: #333;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Data Booking</h1>
    <table class="info">
        <tr>
            <th>ID Booking</th>
            <th>Tanggal Booking</th>
            <th>Batas Ambil</th>
        </tr>
        <tr>
            <td>{{ $data_booking[0]->id_booking }}</td>
            <td>{{ $data_booking[0]->tgl_booking }}</td>
            <td>{{ $data_booking[0]->batas_ambil }}</td>
        </tr>
    </table>

    <table class="data-booking">
        <thead>
            <tr>
                <th class="center">#</th>
                <th class="center">ID Booking</th>
                <th>Judul Buku</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_booking as $booking)
                @foreach ($booking->booking_detail as $detail)
                    <tr>
                        <td class="center">{{ $loop->iteration }}</td>
                        <td class="center">{{ $booking->id_booking }}</td>
                        <td>{{ $detail->buku->judul_buku }}</td>
                        <td>{{ $detail->buku->pengarang }}</td>
                        <td>{{ $detail->buku->penerbit }}</td>
                        <td>{{ $detail->buku->tahun_terbit }}</td>
                        <td>{{ $detail->buku->kategori->nama_kategori }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>
