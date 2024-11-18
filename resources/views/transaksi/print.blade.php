<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi - {{ $transaksi->kode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>KUITANSI</h2>
        <p><strong>Nomor Transaksi:</strong> {{ $transaksi->kode }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->tanggaltransaksi }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksi as $detail)
                <tr>
                    <td>{{ $detail->produk->nama }}</td>
                    <td>{{ number_format($detail->harga, 2) }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <p><strong>Total: </strong>{{ number_format($transaksi->total, 2) }}</p>
        <p><strong>Bayar: </strong>{{ number_format($transaksi->bayar, 2) }}</p>
        <p><strong>Kembalian: </strong>{{ number_format($transaksi->kembalian, 2) }}</p>
    </div>

    <div class="text-center">
        <p>Terima kasih atas transaksi Anda!</p>
    </div>
</body>
</html>
