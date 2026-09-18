<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Struk {{ $transaksi->kode }}</title>
    <style>
        * {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 300px;
            margin: 0 auto;
            padding: 16px;
            color: #000;
            font-size: 12px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 0;
            vertical-align: top;
        }

        .right {
            text-align: right;
        }

        .item-name {
            font-size: 12px;
        }

        .item-sub {
            font-size: 11px;
            color: #333;
        }

        .total-row td {
            padding-top: 4px;
        }

        @media print {
            body {
                width: 100%;
            }

            .no-print {
                display: none;
            }
        }

        .btn {
            display: inline-block;
            margin-top: 12px;
            padding: 8px 20px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="center">
        <div class="bold" style="font-size: 14px;">ADIBAH SHOP</div>
        <div>Ritel Modern</div>
        <div>Alamat toko di sini, Jambi</div>
        <div>Telp: 08xx-xxxx-xxxx</div>
    </div>

    <hr>

    <table>
        <tr>
            <td>No</td>
            <td class="right">{{ $transaksi->kode }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="right">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="right">{{ $transaksi->user->name }}</td>
        </tr>
    </table>

    <hr>

    <table>
        @foreach ($transaksi->detail as $item)
        <tr>
            <td class="item-name" colspan="2">{{ $item->barang->nama ?? 'Barang' }}</td>
        </tr>
        <tr class="item-sub">
            <td>{{ $item->jumlah }} x {{ number_format($item->harga, 0, ',', '.') }}</td>
            <td class="right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <hr>

    <table>
        <tr class="total-row bold">
            <td>TOTAL</td>
            <td class="right">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembalian</td>
            <td class="right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Metode</td>
            <td class="right">{{ strtoupper($transaksi->metode_bayar) }}</td>
        </tr>
    </table>

    <hr>

    <div class="center">
        <div>Terima kasih atas kunjungan Anda</div>
        <div>Barang yang sudah dibeli</div>
        <div>tidak dapat dikembalikan</div>
    </div>

    <div class="center no-print">
        <button class="btn" onclick="window.print()">🖨️ Cetak</button>
    </div>

    <script>
        window.addEventListener('load', () => setTimeout(() => window.print(), 400));
    </script>
</body>

</html>