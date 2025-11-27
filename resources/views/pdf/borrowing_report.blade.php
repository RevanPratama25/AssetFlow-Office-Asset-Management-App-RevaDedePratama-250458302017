<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Peminjaman Aset</title>
    <style>
        /* Reset dasar */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif; /* Font standar PDF */
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Header Laporan */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #444; /* Garis ganda untuk kesan formal */
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
            color: #2c3e50; /* Warna Slate Tua */
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 12pt;
            font-weight: normal;
            color: #555;
        }
        .header p {
            margin: 2px;
            font-size: 9pt;
            color: #777;
            font-style: italic;
        }

        /* Styling Tabel Utama */
        table {
            width: 100%;
            border-collapse: collapse; /* Wajib agar border menyatu rapi */
            margin-top: 10px;
        }

        /* Header Tabel */
        th {
            background-color: #34495e; /* Background gelap (Slate) */
            color: #ffffff; /* Teks putih */
            font-weight: bold;
            padding: 10px;
            border: 1px solid #000; /* Border hitam tegas */
            font-size: 9pt;
            text-transform: uppercase;
            vertical-align: middle;
        }

        /* Isi Tabel */
        td {
            border: 1px solid #000; /* Border hitam di semua sisi */
            padding: 8px;
            vertical-align: top; /* Teks rata atas */
            font-size: 9pt;
            color: #000;
        }

        /* Zebra Striping (Baris Ganjil-Genap) untuk keterbacaan */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Kolom Spesifik */
        .col-no { width: 5%; text-align: center; }
        .col-date { width: 13%; white-space: nowrap; }
        .col-status { width: 12%; text-align: center; font-weight: bold; }

        /* Footer Halaman */
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 8pt;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: right;
        }
        
        /* Helper untuk status badge sederhana (text-based) */
        .status-pending { color: #d35400; }
        .status-selesai { color: #27ae60; }
        .status-ditolak { color: #c0392b; }

        /* Mencegah baris tabel terpotong di pergantian halaman */
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    {{-- Kop Laporan --}}
    <div class="header">
        <h1>Laporan Peminjaman Aset</h1>
        <h2>AssetFlow Management System</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    {{-- Tabel Data --}}
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Peminjam</th>
                <th>Detail Aset</th>
                <th class="col-date">Tgl Pinjam</th>
                <th class="col-date">Tgl Kembali</th>
                <th class="col-status">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="col-no">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item->user->name }}</strong><br>
                    <span style="font-size: 8pt; color: #555;">{{ $item->user->email }}</span>
                </td>
                <td>
                    {{ $item->asset->name }}<br>
                    <span style="font-size: 8pt; color: #555; font-family: monospace;">Kode: {{ $item->asset->asset_code }}</span>
                </td>
                <td class="col-date">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d/m/Y') }}</td>
                <td class="col-date">{{ \Carbon\Carbon::parse($item->return_date)->format('d/m/Y') }}</td>
                <td class="col-status">
                    {{-- Logic warna text sederhana untuk PDF --}}
                    @if($item->status == 'Selesai' || $item->status == 'Disetujui')
                        <span class="status-selesai">{{ strtoupper($item->status) }}</span>
                    @elseif($item->status == 'Ditolak')
                        <span class="status-ditolak">{{ strtoupper($item->status) }}</span>
                    @else
                        <span class="status-pending">{{ strtoupper($item->status) }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer (Tanda tangan sistem / timestamp) --}}
    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }} | Halaman <span class="pagenum"></span>
    </div>

</body>
</html>