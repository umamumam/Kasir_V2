<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .kuitansi {
            border: 1px solid #000;
            padding: 10px;
            width: 400px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="kuitansi">
        <div class="header">Kuitansi Transaksi</div>
        <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->tanggaltransaksi }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detailTransaksis as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ number_format($detail->harga, 2) }}</td>
                        <td>{{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p><strong>Total:</strong> {{ number_format($transaksi->total, 2) }}</p>
            <p><strong>Bayar:</strong> {{ number_format($transaksi->bayar, 2) }}</p>
            <p><strong>Kembalian:</strong> {{ number_format($transaksi->kembalian, 2) }}</p>
        </div>
    </div>
</body>
</html>
