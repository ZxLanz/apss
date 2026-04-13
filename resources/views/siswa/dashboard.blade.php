<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<title>Dashboard Siswa - APSS</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
 <!-- SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-fixed-dim": "#b1c6f9",
                    "surface-container": "#e7eff7",
                    "on-secondary-fixed-variant": "#304671",
                    "primary": "#0058be",
                    "surface-container-low": "#edf4fd",
                    "on-tertiary-container": "#fffbff",
                    "surface": "#f6f9ff",
                    "on-tertiary-fixed-variant": "#723600",
                    "surface-container-high": "#e2e9f2",
                    "secondary-fixed": "#d8e2ff",
                    "primary-fixed": "#d8e2ff",
                    "on-tertiary": "#ffffff",
                    "on-background": "#151c23",
                    "on-surface": "#151c23",
                    "background": "#f6f9ff",
                    "secondary": "#495e8a",
                    "tertiary-fixed": "#ffdcc6",
                    "on-secondary-fixed": "#001a42",
                    "on-secondary": "#ffffff",
                    "outline-variant": "#c2c6d6",
                    "inverse-on-surface": "#eaf1fa",
                    "on-tertiary-fixed": "#311400",
                    "surface-dim": "#d4dbe3",
                    "on-primary-fixed-variant": "#004395",
                    "primary-fixed-dim": "#adc6ff",
                    "on-surface-variant": "#424754",
                    "inverse-surface": "#2a3138",
                    "on-primary-container": "#fefcff",
                    "on-primary-fixed": "#001a42",
                    "on-primary": "#ffffff",
                    "surface-variant": "#dce3ec",
                    "surface-container-lowest": "#ffffff",
                    "primary-container": "#2170e4",
                    "tertiary-container": "#b75b00",
                    "error-container": "#ffdad6",
                    "surface-tint": "#005ac2",
                    "tertiary-fixed-dim": "#ffb786",
                    "on-error-container": "#93000a",
                    "surface-bright": "#f6f9ff",
                    "inverse-primary": "#adc6ff",
                    "tertiary": "#924700",
                    "outline": "#727785",
                    "surface-container-highest": "#dce3ec",
                    "error": "#ba1a1a",
                    "on-secondary-container": "#405682",
                    "secondary-container": "#b6ccff",
                    "on-error": "#ffffff"
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
        body { font-family: 'Inter', sans-serif; background-color: #f6f9ff; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .glass-effect { backdrop-filter: blur(12px); background-color: rgba(237, 244, 253, 0.8); }
        .primary-gradient { background: linear-gradient(135deg, #0058be 0%, #2170e4 100%); }
    </style>
</head>
<body class="text-on-surface">

@if(session('success'))
<div class="fixed top-24 right-6 z-[100] animate-in fade-in slide-in-from-top-4 duration-300" id="toast-success">
    <div class="bg-surface-container-lowest border border-green-200 p-4 rounded-[12px] shadow-2xl flex items-center gap-4 max-w-md">
        <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <div class="flex-grow">
            <p class="font-bold text-on-surface text-sm">Berhasil!</p>
            <p class="text-on-surface-variant text-xs">{{ session('success') }}</p>
        </div>
        <button class="text-outline hover:text-on-surface" onclick="document.getElementById('toast-success').remove()">
            <span class="material-symbols-outlined text-sm" data-icon="close">close</span>
        </button>
    </div>
</div>
@endif

<nav class="fixed top-0 left-0 w-full z-50 bg-transparent">
<div class="flex justify-between items-center w-full px-6 py-4 glass-effect">
    <div class="flex items-center gap-12">
        <div class="text-2xl font-bold tracking-tight text-blue-800 dark:text-blue-300 font-headline">
            APSS
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a class="text-blue-700 dark:text-blue-400 font-bold border-b-2 border-blue-600 px-1 py-1 text-sm tracking-tight transition-all duration-200" href="{{ route('siswa.dashboard') }}">Dashboard</a>
            <a class="text-slate-500 hover:text-blue-600 px-1 py-1 text-sm tracking-tight transition-colors" href="{{ route('siswa.laporan.create') }}">Buat Laporan</a>
        </div>
    </div>
    <div class="flex items-center gap-4">
    <div class="flex items-center gap-4">
        <!-- Notification Bell -->
        <div class="relative group">
            <button class="w-10 h-10 rounded-xl bg-white border border-surface-variant/20 flex items-center justify-center text-slate-500 hover:text-primary transition-all active:scale-95 shadow-sm">
                <span class="material-symbols-outlined">notifications</span>
                @if(auth()->guard('siswa')->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-error text-white text-[10px] font-black rounded-xl flex items-center justify-center border-2 border-white animate-bounce">
                        {{ auth()->guard('siswa')->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>
            
            <!-- Dropdown (Simple version for now) -->
            <div class="absolute right-0 mt-4 w-80 bg-white rounded-2xl shadow-2xl border border-surface-variant/10 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[100] transform translate-y-2 group-hover:translate-y-0">
                <div class="p-4 border-b border-surface-variant/10 bg-surface-container-low/30 flex justify-between items-center">
                    <h3 class="font-black text-xs uppercase tracking-widest text-outline">Notifikasi</h3>
                    <span class="text-[10px] font-bold text-primary">{{ auth()->guard('siswa')->user()->unreadNotifications->count() }} Baru</span>
                </div>
                <div class="max-h-[300px] overflow-y-auto">
                    @forelse(auth()->guard('siswa')->user()->unreadNotifications as $notification)
                        <div class="p-4 hover:bg-slate-50 transition-colors border-b border-surface-variant/5">
                            <p class="text-[11px] text-on-surface-variant leading-relaxed">{{ $notification->data['keterangan'] }}</p>
                            <form action="{{ route('siswa.notifications.read', $notification->id) }}" method="POST" class="mt-2 text-right">
                                @csrf
                                <button type="submit" class="text-[10px] font-black text-primary hover:underline">Tandai Dibaca</button>
                            </form>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <span class="material-symbols-outlined text-outline/30 text-4xl block mb-2">notifications_off</span>
                            <p class="text-xs text-outline font-medium">Tidak ada notifikasi baru</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <a href="{{ route('siswa.akun.edit') }}" class="flex items-center gap-2 text-slate-500 hover:bg-blue-50 transition-colors px-3 py-2 rounded-xl transition-all active:scale-[0.98]">
            <div class="w-8 h-8 rounded-lg overflow-hidden bg-blue-100 flex items-center justify-center shrink-0 border border-white shadow-sm">
                @if(Auth::guard('siswa')->user()->foto)
                    <img src="{{ asset('storage/' . Auth::guard('siswa')->user()->foto) }}" class="w-full h-full object-cover">
                @else
                    <span class="material-symbols-outlined text-blue-600 text-[20px]">person</span>
                @endif
            </div>
            <span class="font-bold text-sm tracking-tight">Akun Saya</span>
        </a>
        <form action="{{ route('siswa.logout') }}" method="POST" id="form-logout">
            @csrf
            <button type="button" onclick="confirmLogout()" class="bg-error text-white px-4 py-2 rounded-md font-bold text-sm hover:opacity-90 transition-opacity">
                Logout
            </button>
        </form>
        <script>
            function confirmLogout() {
                Swal.fire({
                    title: 'Keluar dari aplikasi?',
                    text: 'Anda harus login kembali untuk mengakses laporan Anda.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ba1a1a',
                    cancelButtonColor: '#727785',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-logout').submit();
                    }
                })
            }

            // Auto-hide toast after 3 seconds
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.style.transition = 'all 0.5s ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-20px)';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>
    </div>
</div>
</nav>

<main class="pt-24 pb-12 px-6 max-w-6xl mx-auto">
<!-- Notification Banner (Desktop/Legacy) removed, replaced by Bell Dropdown -->

<section class="mb-8">
    <div class="bg-surface-container-lowest p-8 rounded-[12px] shadow-[0px_4px_24px_rgba(21,28,35,0.06)] flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-3xl overflow-hidden flex-shrink-0 bg-blue-100 flex items-center justify-center border-4 border-white shadow-xl">
                @if(Auth::guard('siswa')->user()->foto)
                    <img src="{{ asset('storage/' . Auth::guard('siswa')->user()->foto) }}" class="w-full h-full object-cover">
                @else
                    <span class="material-symbols-outlined text-4xl text-primary">person</span>
                @endif
            </div>
            <div>
                <p class="text-on-surface-variant font-medium text-sm uppercase tracking-wider mb-1">Beranda Siswa</p>
                <h1 class="font-headline text-3xl font-extrabold tracking-tight text-on-surface">
                    Selamat datang, {{ auth()->guard('siswa')->user()->nama }}
                </h1>
            </div>
        </div>
        <a href="{{ route('siswa.laporan.create') }}" class="primary-gradient text-white flex items-center gap-2 px-6 py-4 rounded-[12px] font-bold shadow-lg hover:shadow-xl transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined" data-icon="add">add</span>
            Buat Pengaduan
        </a>
    </div>
</section>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-surface-container-low p-6 rounded-[12px] border-l-4 border-yellow-400">
        <p class="text-on-surface-variant text-sm font-semibold">Laporan Menunggu</p>
        <p class="font-headline text-4xl font-black mt-2 text-on-surface">{{ $stats['menunggu'] }}</p>
    </div>
    <div class="bg-surface-container-low p-6 rounded-[12px] border-l-4 border-primary">
        <p class="text-on-surface-variant text-sm font-semibold">Laporan Diproses</p>
        <p class="font-headline text-4xl font-black mt-2 text-on-surface">{{ $stats['proses'] }}</p>
    </div>
    <div class="bg-surface-container-low p-6 rounded-[12px] border-l-4 border-green-500">
        <p class="text-on-surface-variant text-sm font-semibold">Laporan Selesai</p>
        <p class="font-headline text-4xl font-black mt-2 text-on-surface">{{ $stats['selesai'] }}</p>
    </div>
</div>

<section class="bg-surface-container-lowest rounded-[12px] shadow-[0px_4px_24px_rgba(21,28,35,0.06)] overflow-hidden">
    <div class="px-8 py-6 border-b border-surface-variant/20 flex justify-between items-center flex-wrap gap-4">
        <h2 class="font-headline text-xl font-bold text-on-surface">Riwayat Laporan Saya</h2>
        <form action="{{ route('siswa.dashboard') }}" method="GET" class="flex gap-2 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan..." class="border border-outline-variant rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary w-full md:w-64">
            <select name="status" class="border border-outline-variant rounded-md pl-3 pr-8 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary bg-white cursor-pointer hover:border-primary/50 transition-all">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit" class="bg-surface-container-high text-primary px-3 py-1.5 rounded-md text-sm font-bold hover:bg-primary hover:text-white transition-colors">Filter</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-surface-container-low text-on-surface-variant text-xs font-bold uppercase tracking-widest">
                <tr>
                    <th class="px-8 py-4">#</th>
                    <th class="px-8 py-4">Keterangan Laporan</th>
                    <th class="px-8 py-4">Tanggal</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-variant/10">
                @if($laporan->isEmpty())
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-on-surface-variant">
                        Belum ada laporan pengaduan yang sesuai.
                    </td>
                </tr>
                @else
                @foreach($laporan as $item)
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                    <td class="px-8 py-6 font-headline font-bold text-on-surface">{{ $laporan->firstItem() + $loop->index }}</td>
                    <td class="px-8 py-6">
                        <p class="font-semibold text-on-surface mb-1">{{ \Illuminate\Support\Str::limit($item->ket, 50) }}</p>
                        <p class="text-xs text-on-surface-variant">Dilaporkan pada {{ $item->created_at->format('d M Y') }} di {{ $item->lokasi }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs font-mono font-bold text-primary">{{ $item->created_at->format('d/m/Y H:i:s') }} WIB</p>
                    </td>
                    <td class="px-8 py-6">
                        @if($item->status == 'menunggu')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Menunggu
                            </span>
                        @elseif($item->status == 'proses')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> Proses
                            </span>
                        @elseif($item->status == 'selesai')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold flex items-center w-fit gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Selesai
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <a href="{{ route('siswa.laporan.show', $item->id) }}" class="bg-surface-container-high text-primary inline-flex items-center gap-2 px-4 py-2 rounded-md font-bold text-sm ml-auto hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-sm" data-icon="visibility">visibility</span>
                            Lihat
                        </a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @if($laporan->hasPages())
    <div class="px-8 py-6 bg-surface-container-low/30">
        {{ $laporan->links('pagination::tailwind') }}
    </div>
    @endif
</section>
</main>

@include('layouts.footer')
</body></html>