<!DOCTYPE html>
<html lang="id">

@php
$w = 32; // lebar karakter printer termal 58mm

$tengah = function ($t) use ($w) {
$t = substr($t, 0, $w);
$kiri = max(0, intdiv($w - strlen($t), 2));
return str_repeat(' ', $kiri) . $t;
};

$kiriKanan = function ($kiri, $kanan) use ($w) {
$kanan = (string) $kanan;
$sisa = max(1, $w - strlen($kanan));
return substr(str_pad(substr($kiri, 0, $sisa), $sisa), 0, $sisa) . $kanan;
};

$b = [];
$b[] = $tengah('ADIBAH SHOP');
$b[] = $tengah('Ritel Modern');
$b[] = $tengah('Jambi');
$b[] = str_repeat('-', $w);
$b[] = 'No : ' . $transaksi->kode;
$b[] = 'Tgl : ' . $transaksi->created_at->format('d/m/y H:i');
$b[] = 'Kasir: ' . $transaksi->user->name;
$b[] = str_repeat('-', $w);
foreach ($transaksi->detail as $item) {
$b[] = substr($item->barang->nama ?? 'Barang', 0, $w);
$b[] = $kiriKanan(' ' . $item->jumlah . ' x ' . number_format($item->harga, 0, ',', '.'),
number_format($item->subtotal, 0, ',', '.'));
}
$b[] = str_repeat('-', $w);
$b[] = $kiriKanan('TOTAL', 'Rp ' . number_format($transaksi->total, 0, ',', '.'));
$b[] = $kiriKanan('Bayar', 'Rp ' . number_format($transaksi->bayar, 0, ',', '.'));
$b[] = $kiriKanan('Kembali', 'Rp ' . number_format($transaksi->kembalian, 0, ',', '.'));
$b[] = 'Metode: ' . strtoupper($transaksi->metode_bayar);
$b[] = str_repeat('-', $w);
$b[] = $tengah('Terima kasih');
$b[] = $tengah('atas kunjungan Anda');
$b[] = ' ';
$b[] = ' ';

$teksStruk = implode("\n", $b) . "\n";
$linkRawbt = 'rawbt:' . rawurlencode($teksStruk);
@endphp

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
            text-decoration: none;
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
        <a class="btn" href="{{ $linkRawbt }}">🖨️ Cetak ke Printer</a>
        <a class="btn" href="#" onclick="window.print(); return false;"
            style="background:#6b7280;">Print biasa</a>
    </div>

    <script>
        // Otomatis kirim ke RawBT saat struk dibuka (di tablet Android dengan RawBT + printer terpasang)
        window.addEventListener('load', () => {
            setTimeout(() => {
                window.location.href = "{{ $linkRawbt }}";
            }, 500);
        });
    </script>
</body>

</html>