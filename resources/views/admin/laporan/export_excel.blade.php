<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        /* Excel Compatibility: Poppins font with local fallbacks */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        
        table { 
            font-family: 'Poppins', 'Segoe UI', Tahoma, Arial, sans-serif; 
            border-collapse: collapse; 
            width: 100%; 
        }
        
        /* Branding Header */
        .report-header {
            font-size: 18pt;
            font-weight: bold;
            color: #0058be;
            text-align: center;
        }
        .report-subheader {
            font-size: 10pt;
            color: #4b5563;
            text-align: center;
            margin-bottom: 20px;
        }

        th { 
            background-color: #0058be; 
            color: #ffffff; 
            font-weight: bold; 
            text-align: center;
            border: 0.5pt solid #cccccc;
            padding: 12px 8px;
        }
        td { 
            border: 0.5pt solid #cccccc; 
            padding: 10px 8px;
            vertical-align: middle;
        }
        
        /* Zebra Stripes */
        .even { background-color: #f8fafc; }
        
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        /* Excel number formatting */
        .num-text { mso-number-format:"\@"; }
        
        /* Status Badges */
        .status { 
            font-weight: bold; 
            text-align: center;
            padding: 4px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Header Branding -->
    <table>
        <tr>
            <td colspan="11" class="report-header">LAPORAN PENGADUAN SARANA SEKOLAH (APSS)</td>
        </tr>
        <tr>
            <td colspan="11" class="report-subheader">
                Dicetak pada: {{ now()->format('d F Y, H:i') }} | Total Data: {{ $laporan->count() }}
            </td>
        </tr>
        <tr><td colspan="11" style="border:none; height:10px;"></td></tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="30">ID</th>
                <th width="120">TANGGAL</th>
                <th width="100">NIS</th>
                <th width="200">NAMA SISWA</th>
                <th width="100">KELAS</th>
                <th width="150">KATEGORI</th>
                <th width="150">LOKASI</th>
                <th width="250">KETERANGAN LAPORAN</th>
                <th width="100">STATUS</th>
                <th width="150">FEEDBACK</th>
                <th width="250">TANGGAPAN ADMIN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $item)
            <tr class="{{ $index % 2 == 0 ? 'odd' : 'even' }}">
                <td class="text-center">{{ $item->id }}</td>
                <td class="text-center">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                <td class="num-text text-center">{{ $item->siswa->nis }}</td>
                <td class="font-bold">{{ strtoupper($item->siswa->nama) }}</td>
                <td class="text-center">{{ $item->siswa->kelas }}</td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->ket }}</td>
                <td class="text-center font-bold">
                    @php
                        $color = match($item->aspirasi?->status) {
                            'selesai' => '#059669',
                            'proses' => '#2563eb',
                            default => '#d97706'
                        };
                    @endphp
                    <span style="color: {{ $color }};">{{ strtoupper($item->aspirasi?->status ?? 'menunggu') }}</span>
                </td>
                <td>{{ $item->aspirasi?->feedback_label ?? '-' }}</td>
                <td>{{ $item->aspirasi?->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
