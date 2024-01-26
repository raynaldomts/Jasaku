<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <img src="{{ public_path('images/combined-logo.png') }}" alt="" width="15%">
    <h3>Invoice Order-{{ $order->id }}-{{ $order->waktu_dibuat }}</h3>
    
    <h4 class="title-kecil">Data Pemesan</h4>
    <table>
        <tr>
            <th class="identifier">Nama</th>
            <th>:</th>
            <td>{{ $user->nama }}</td>
        </tr>
        <tr>
            <th class="identifier">Alamat</th>
            <th>:</th>
            <td>{{ $user->alamat }}</td>
        </tr>
        <tr>
            <th class="identifier">Nomor Telepon</th>
            <th>:</th>
            <td>{{ $user->no_telp }}</td>
        </tr>
    </table>

    <h4 class="title-kecil">Data Pesanan</h4>
    <table>
        <tr>
            <th class="identifier">Dipesan Tanggal</th>
            <th>:</th>
            <td>{{ date('d-M-Y', strtotime($order->waktu_dibuat)) }}</td>
        </tr>
        <tr>
            <th class="identifier">Nama Jasa</th>
            <th>:</th>
            <td>{{ $order->getJasa->nama }}</td>
        </tr>
        <tr>
            <th class="identifier">Harga</th>
            <th>:</th>
            <td>Rp{{ number_format($order->getJasa->harga) }}</td>
        </tr>
        <tr>
            <th class="identifier">Jumlah Dipesan</th>
            <th>:</th>
            <td>
                {{ $order->jumlah_barang }} 
                @if ($order->jumlah_barang > 1)
                    pcs
                @else
                    pc
                @endif
            </td>
        </tr>
        <tr>
            <th class="identifier">Total Biaya</th>
            <th>:</th>
            <td><b>Rp{{ number_format($order->total_harga) }}</b></td>
        </tr>
        <tr>
            <th class="identifier">Status</th>
            <th>:</th>
            <td>{{ $order->status }}</td>
        </tr>
    </table>

    <h4 class="title-kecil">Data Penjual</h4>
    <table>
        <tr>
            <th class="identifier">Nama Penjual</th>
            <th>:</th>
            <td>{{ $order->getJasa->getUser->getPenjual->nama }}</td>
        </tr>
        <tr>
            <th class="identifier">Nomor Telepon</th>
            <th>:</th>
            <td>{{ $order->getJasa->getUser->getPenjual->no_telp }}</td>
        </tr>
        <tr>
            <th class="identifier">Nomor Rekening</th>
            <th>:</th>
            <td>{{ $order->getJasa->getUser->getPenjual->no_rek }}</td>
        </tr>
    </table>
    
    <br/><br/>

    <div class="footer">
        &copy; Jasaku {{ date('Y') }}
    </div>
</body>
</html>