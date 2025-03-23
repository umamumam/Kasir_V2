<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi - {{ $transaksi->kode }}</title>
    <style>
        * {
            margin: 7px;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            width: 58mm;
            font-size: 14px;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .table td {
            padding: 3px 0;
            font-size: 14px;
        }

        .total, .bayar, .kembalian {
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
            text-align: right;
        }

        .footer {
            margin-top: 10px;
            font-size: 12px;
            text-align: center;
            padding-top: 10px;
            border-top: 1px solid #000;
        }

        .line {
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        .store-name {
            font-size: 16px;
            font-weight: bold;
        }

        .store-address {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <div class="store-name">Agen Sosis Lancar Manunggal</div>
        <div class="store-address">Jl. Tayu-Jepara depan Kantor Pos Ngablak</div>
        <div class="store-address">HP: 085201454015</div>
        <br>
        <label><strong>No:</strong> {{ $transaksi->kode }}</label><br>
        <label><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggaltransaksi)->format('d-m-Y') }}</label>
        <div class="line"></div>
    </div>

    <table class="table">
        <tbody>
            @foreach($transaksi->detailTransaksi as $detail)
                <tr>
                    <td>
                        {{ $detail->produk->nama }} <br>
                        {{ number_format($detail->harga, 0) }} x {{ $detail->jumlah }}
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($detail->subtotal, 0) }}
                    </td>
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
