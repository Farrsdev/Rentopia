<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .status {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Rentopia</h1>
        <p>Laporan Transaksi Penyewaan Game & Aplikasi</p>
        <p>
            Periode: 
            {{ $request->dari_tanggal ? date('d M Y', strtotime($request->dari_tanggal)) : 'Awal' }} 
            s/d 
            {{ $request->sampai_tanggal ? date('d M Y', strtotime($request->sampai_tanggal)) : 'Akhir' }}
            | Status: {{ $request->status ? $request->status : 'Semua' }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Tgl Transaksi</th>
                <th width="20%">Penyewa</th>
                <th width="35%">Detail Item</th>
                <th width="10%">Status</th>
                <th width="20%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($peminjamans as $index => $p)
                @php
                    $totalHarga = $p->details->sum(function($d) { return $d->harga_sewa * $d->qty; });
                    if(in_array($p->status, ['Disetujui', 'Selesai'])) {
                        $grandTotal += $totalHarga;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}<br><small>{{ $p->created_at->format('H:i') }}</small></td>
                    <td>
                        <strong>{{ $p->user->name }}</strong><br>
                        <small>{{ $p->user->email }}</small>
                    </td>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($p->details as $d)
                                <li>{{ $d->produk->nama_produk ?? 'Dihapus' }} ({{ $d->qty }}x)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        <span class="status">{{ $p->status }}</span>
                    </td>
                    <td class="text-right">
                        {{ number_format($totalHarga, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data peminjaman yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan (Disetujui & Selesai):</th>
                <th class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        <br><br><br>
        <p><strong>Admin Rentopia</strong></p>
    </div>

</body>
</html>
