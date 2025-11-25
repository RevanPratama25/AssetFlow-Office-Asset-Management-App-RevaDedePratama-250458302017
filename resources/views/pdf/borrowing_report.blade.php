<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #333; }
        .header p { margin: 2px; color: #666; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        
        .status-box { padding: 2px 5px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #999; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN PEMINJAMAN ASET</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Nama Aset</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->asset->name }} <br> <small style="color:#666">({{ $item->asset->asset_code }})</small></td>
                <td>{{ \Carbon\Carbon::parse($item->borrow_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->return_date)->format('d/m/Y') }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }} | Oleh Sistem AssetFlow
    </div>

</body>
</html>