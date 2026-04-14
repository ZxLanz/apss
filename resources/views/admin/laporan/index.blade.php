<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<title>Laporan & Aspirasi | APSS</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
 <!-- SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "tertiary-container": "#b75b00",
                    "on-background": "#151c23",
                    "surface": "#f6f9ff",
                    "surface-dim": "#d4dbe3",
                    "on-tertiary-fixed-variant": "#723600",
                    "primary-fixed": "#d8e2ff",
                    "surface-bright": "#f6f9ff",
                    "primary-fixed-dim": "#adc6ff",
                    "on-surface-variant": "#424754",
                    "secondary-fixed-dim": "#b1c6f9",
                    "on-error-container": "#93000a",
                    "tertiary-fixed-dim": "#ffb786",
                    "on-tertiary-fixed": "#311400",
                    "on-primary-container": "#fefcff",
                    "background": "#f6f9ff",
                    "on-tertiary-container": "#fffbff",
                    "tertiary-fixed": "#ffdcc6",
                    "surface-container-highest": "#dce3ec",
                    "on-secondary-container": "#405682",
                    "on-primary-fixed-variant": "#004395",
                    "outline-variant": "#c2c6d6",
                    "inverse-on-surface": "#eaf1fa",
                    "surface-container-high": "#e2e9f2",
                    "primary": "#0058be",
                    "outline": "#727785",
                    "surface-tint": "#005ac2",
                    "primary-container": "#2170e4",
                    "on-primary": "#ffffff",
                    "surface-container-low": "#edf4fd",
                    "on-primary-fixed": "#001a42",
                    "on-error": "#ffffff",
                    "error": "#ba1a1a",
                    "on-secondary-fixed": "#001a42",
                    "surface-variant": "#dce3ec",
                    "inverse-surface": "#2a3138",
                    "secondary-fixed": "#d8e2ff",
                    "on-tertiary": "#ffffff",
                    "on-secondary-fixed-variant": "#304671",
                    "tertiary": "#924700",
                    "secondary-container": "#b6ccff",
                    "surface-container": "#e7eff7",
                    "secondary": "#495e8a",
                    "inverse-primary": "#adc6ff",
                    "error-container": "#ffdad6",
                    "surface-container-lowest": "#ffffff",
                    "on-secondary": "#ffffff",
                    "on-surface": "#151c23"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Manrope"],
                    "body": ["Inter"],
                    "label": ["Inter"]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .signature-gradient { background: linear-gradient(135deg, #0058be 0%, #2170e4 100%); }
        
        @media print {
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
            body { font-family: 'Poppins', sans-serif !important; background: white !important; }
            .print\:hidden, nav, header, footer, .sidebar, button, a { display: none !important; }
            .max-w-screen-2xl { max-width: 100% !important; padding: 0 !important; }
            table { font-size: 10px !important; width: 100% !important; border: 1px solid #ddd !important; }
            th { background-color: #f3f4f6 !important; color: black !important; -webkit-print-color-adjust: exact; }
            td, th { border: 1px solid #eee !important; padding: 8px !important; }
            .bg-surface-container-lowest { box-shadow: none !important; border: 1px solid #eee !important; }
            h1 { font-size: 24px !important; margin-bottom: 5px !important; color: black !important; }
            p { font-size: 12px !important; }
            .status-badge { font-weight: bold !important; border: 1px solid #ccc !important; padding: 2px 5px !important; border-radius: 4px !important; }
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen">
<x-admin.navbar active="laporan" />
<main class="max-w-screen-2xl mx-auto px-8 py-8">
@if(session('success'))
<div class="fixed top-6 right-6 z-[60] flex items-center gap-3 bg-surface-container-lowest border-l-4 border-primary px-6 py-4 rounded-xl shadow-lg ring-1 ring-black/5" id="toast-success">
    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
    <div>
        <p class="text-sm font-semibold text-on-surface">Berhasil</p>
        <p class="text-xs text-on-surface-variant">{{ session('success') }}</p>
    </div>
    <button class="ml-4 text-outline hover:text-on-surface" onclick="document.getElementById('toast-success').remove()">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="fixed top-6 right-6 z-[60] flex items-center gap-3 bg-error-container text-on-error-container border-l-4 border-error px-6 py-4 rounded-xl shadow-lg ring-1 ring-black/5" id="toast-error">
    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">error</span>
    <div>
        <p class="text-sm font-semibold">Error</p>
        <p class="text-xs">{{ session('error') }}</p>
    </div>
    <button class="ml-4 hover:opacity-70" onclick="document.getElementById('toast-error').remove()">
        <span class="material-symbols-outlined text-sm">close</span>
    </button>
</div>
@endif

<div class="mb-10">
    <nav class="flex text-sm font-medium text-on-surface-variant mb-2">
        <span class="hover:text-primary cursor-pointer">Admin</span>
        <span class="mx-2 text-outline-variant">/</span>
        <span class="text-primary">Laporan & Aspirasi</span>
    </nav>
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-on-surface tracking-tight mb-2">Daftar Laporan dan Aspirasi</h1>
            <p class="text-on-surface-variant max-w-2xl">Kelola masukan, keluhan, dan saran dari seluruh civitas akademika untuk lingkungan sekolah yang lebih baik.</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.laporan.index') }}" method="GET" class="bg-surface-container-lowest rounded-xl p-6 mb-8 flex flex-wrap items-center gap-4">
    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-xs font-bold uppercase tracking-wider text-outline">Pencarian</label>
        <div class="relative group">
            <span class="absolute inset-y-0 left-3 flex items-center text-outline group-focus-within:text-primary transition-colors">
                <span class="material-symbols-outlined text-sm">search</span>
            </span>
            <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/40 text-on-surface placeholder:text-outline/60" placeholder="Cari laporan atau nama siswa..." type="text"/>
        </div>
    </div>
    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-xs font-bold uppercase tracking-wider text-outline">Filter Status</label>
        <select name="status" class="bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/40 py-2.5 pl-4 pr-10 cursor-pointer hover:bg-surface-container transition-colors">
            <option value="semua">Semua</option>
            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Menunggu (Belum Diproses)</option>
            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>
    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-xs font-bold uppercase tracking-wider text-outline">Filter Kategori</label>
        <select name="kategori_id" class="bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/40 py-2.5 pl-4 pr-10 cursor-pointer hover:bg-surface-container transition-colors">
            <option value="semua">Semua Kategori</option>
            @foreach($kategoriList as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-xs font-bold uppercase tracking-wider text-outline">Filter Kelas</label>
        <select name="kelas" class="bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/40 py-2.5 pl-4 pr-10 cursor-pointer hover:bg-surface-container transition-colors">
            <option value="semua">Semua Kelas</option>
            <option value="X" {{ request('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
            <option value="XI" {{ request('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
            <option value="XII" {{ request('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
        </select>
    </div>
    <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
        <label class="text-xs font-bold uppercase tracking-wider text-outline">Filter Tanggal</label>
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/40 py-2.5" />
    </div>
    <div class="pt-5 flex gap-2">
        <button type="submit" class="signature-gradient text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-md hover:scale-[0.98] transition-transform flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">filter_alt</span>
            Terapkan Filter
        </button>
        <button onclick="window.print()" class="bg-indigo-600 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-md hover:bg-indigo-700 transition-all flex items-center gap-2 print:hidden">
            <span class="material-symbols-outlined text-lg">print</span>
            Cetak (PDF)
        </button>
        <a href="{{ route('admin.laporan.export', request()->query()) }}" class="bg-green-600 text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-md hover:bg-green-700 transition-all flex items-center gap-2 print:hidden">
            <span class="material-symbols-outlined text-lg">table_chart</span>
            Export Excel
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="bg-surface-container-high text-on-surface font-semibold px-6 py-2.5 rounded-lg text-sm hover:bg-surface-container-highest transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">restart_alt</span>
            Reset Filter
        </a>
    </div>
</form>

<div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">No</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Siswa</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Kategori</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Laporan</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Status</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Feedback</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-low">
                @if($laporan->isEmpty())
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-on-surface-variant font-medium text-sm">Belum ada laporan pengaduan.</td>
                </tr>
                @else
                @foreach($laporan as $item)
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="px-6 py-5 text-sm font-semibold text-on-surface-variant">{{ str_pad($laporan->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm uppercase">{{ substr($item->siswa->nama, 0, 2) }}</div>
                            <div>
                                <p class="text-sm font-bold text-on-surface">{{ $item->siswa->nama }}</p>
                                <p class="text-xs text-outline">{{ $item->siswa->kelas }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="bg-surface-container text-secondary text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded-full">{{ $item->kategori->nama_kategori }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-sm text-on-surface-variant line-clamp-1 max-w-[200px]" title="{{ $item->ket }}">{{ \Illuminate\Support\Str::limit($item->ket, 50) }}</p>
                    </td>
                    <td class="px-6 py-5">
                        @if($item->status == 'menunggu' || empty($item->status))
                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Menunggu
                            </span>
                        @elseif($item->status == 'proses')
                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Proses
                            </span>
                        @else
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1.5 rounded-full inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Selesai
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-[11px] font-mono text-on-surface-variant border border-surface-container-low px-2 py-1 rounded bg-surface-container-low/30">{{ $item->created_at->format('d/m/Y H:i:s') }} WIB</p>
                    </td>
                    <td class="px-6 py-5">
                        @if($item->aspirasi && $item->aspirasi->feedback)
                            <div class="flex text-amber-400 gap-0.5" title="{{ $item->aspirasi->feedback_label }}">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $item->aspirasi->feedback)
                                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">star</span>
                                    @else
                                        <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 0;">star</span>
                                    @endif
                                @endfor
                            </div>
                        @else
                            <span class="text-xs text-outline italic">Belum ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.laporan.show', $item->id) }}" class="text-primary font-bold text-sm flex items-center gap-1.5 hover:underline transition-all">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @if($laporan->hasPages())
    <div class="px-6 py-6 border-t border-surface-container-low flex flex-col md:flex-row justify-between items-center gap-4">
        {{ $laporan->links('pagination::tailwind') }}
    </div>
    @endif
</div>
</main>

@include('layouts.footer')
<script>
</script>
</body></html>
>