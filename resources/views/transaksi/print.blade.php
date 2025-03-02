<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi - {{ $transaksi->kode }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            width: 250px;
            font-size: 10px;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            padding: 3px;
            text-align: center;
            font-size: 10px;
            border-bottom: 1px solid #000;
        }

        .table th {
            font-weight: bold;
        }

        .total, .bayar, .kembalian {
            font-weight: bold;
            font-size: 10px;
            margin-top: 5px;
            text-align: right;
        }

        .footer {
            margin-top: 10px;
            font-size: 10px;
            text-align: center;
            padding-top: 10px;
            border-top: 1px solid #000;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .line {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .store-name {
            font-size: 12px;
            font-weight: bold;
        }

        .store-address {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <div class="store-name">Agen Sosis Lancar Manunggal</div>
        <div class="store-address">Jl. Tayu-Jepara depan Kantor Kantor Pos Ngablak</div>
        <div class="store-address">HP: 085201454015</div>
        <br>
        <label><strong>No:</strong> {{ $transaksi->kode }}</label><br>
        <label><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggaltransaksi)->format('d-m-Y') }}</label>
        <div class="line"></div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksi as $detail)
                <tr>
                    <td>{{ $detail->produk->nama }}</td>
                    <td>{{ number_format($detail->harga, 0) }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->subtotal, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <label><strong>Total:</strong> {{ number_format($transaksi->total, 0) }}</label>
    </div>
    <div class="bayar">
        <label><strong>Bayar:</strong> {{ number_format($transaksi->bayar, 0) }}</label>
    </div>
    <div class="kembalian">
        <label><strong>Kembalian:</strong> {{ number_format($transaksi->kembalian, 0) }}</label>
    </div>

    <div class="footer">
        <p>Terima kasih atas transaksi Anda!</p>
        <p><strong>Barang yang sudah dibeli tidak dapat dikembalikan.</strong></p>
    </div>
</body>
</html>
