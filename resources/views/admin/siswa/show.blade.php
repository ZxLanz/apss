<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Profil Siswa | APSS Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
       tailwind.config = {
         theme: {
           extend: {
             "colors": {
                     "primary": "#0058be",
                     "surface": "#f6f9ff",
                     "on-surface": "#151c23",
                     "on-surface-variant": "#424754",
                     "outline": "#727785",
                     "surface-container-low": "#edf4fd",
                     "surface-container-lowest": "#ffffff",
                     "error": "#ba1a1a"
             },
             "fontFamily": {
                     "headline": ["Manrope"],
                     "body": ["Inter"]
             }
           },
         },
       }
    </script>
</head>
<body class="bg-surface font-body text-on-surface min-h-screen">
    <div class="max-w-screen-xl mx-auto px-8 py-12">
        <div class="mb-10 flex items-center gap-4">
            <a href="{{ route('admin.siswa.index') }}" class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-outline hover:text-primary transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-3xl font-black font-headline tracking-tight">Profil Lengkap Siswa</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Info Siswa --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-surface-variant/5">
                <div class="flex flex-col items-center text-center">
                    <div class="w-32 h-32 rounded-3xl bg-primary/10 flex items-center justify-center text-primary font-black text-4xl mb-6 overflow-hidden border-4 border-surface shadow-lg">
                        @if($siswa->foto)
                            <img src="{{ asset('storage/' . $siswa->foto) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($siswa->nama, 0, 2) }}
                        @endif
                    </div>
                    <h2 class="text-2xl font-black font-headline">{{ $siswa->nama }}</h2>
                    <p class="text-sm font-bold text-primary mt-1">{{ $siswa->nis }}</p>
                    <div class="mt-6 w-full space-y-4 pt-6 border-t border-surface-variant/10 text-left">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-outline">Kelas</p>
                            <p class="font-bold text-on-surface">{{ $siswa->kelas }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-outline">Jurusan</p>
                            <p class="font-bold text-on-surface">{{ $siswa->jurusan?->nama_jurusan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Laporan Terakhir --}}
            <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm border border-surface-variant/5">
                <h3 class="text-xl font-black font-headline mb-6">10 Laporan Terakhir</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black uppercase tracking-widest text-outline border-b border-surface-variant/10">
                                <th class="pb-4">Tanggal</th>
                                <th class="pb-4">Keterangan</th>
                                <th class="pb-4">Status</th>
                                <th class="pb-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-variant/5">
                            @forelse($siswa->laporan as $laporan)
                            <tr class="group">
                                <td class="py-4 text-xs font-mono font-bold">{{ $laporan->created_at->format('d/m/Y') }}</td>
                                <td class="py-4 text-sm font-medium text-on-surface-variant">{{ \Illuminate\Support\Str::limit($laporan->ket, 50) }}</td>
                                <td class="py-4">
                                    @php $stat = $laporan->aspirasi?->status ?? 'menunggu' @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider 
                                        {{ $stat == 'selesai' ? 'bg-green-100 text-green-700' : ($stat == 'proses' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ $stat }}
                                    </span>
                                </td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="text-outline hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-outline text-xs italic">Belum ada riwayat laporan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
