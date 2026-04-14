<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<title>APSS Admin Dashboard - School Complaint Management</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
 <!-- Chart.js -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <!-- SweetAlert2 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "on-secondary-fixed-variant": "#304671",
                "surface-container-lowest": "#ffffff",
                "surface-container": "#e7eff7",
                "primary-fixed-dim": "#adc6ff",
                "surface-tint": "#005ac2",
                "surface-container-low": "#edf4fd",
                "error": "#ba1a1a",
                "on-primary-container": "#fefcff",
                "on-secondary": "#ffffff",
                "inverse-primary": "#adc6ff",
                "secondary": "#495e8a",
                "inverse-on-surface": "#eaf1fa",
                "on-primary-fixed-variant": "#004395",
                "tertiary-fixed": "#ffdcc6",
                "on-surface-variant": "#424754",
                "on-background": "#151c23",
                "surface-variant": "#dce3ec",
                "outline-variant": "#c2c6d6",
                "secondary-fixed": "#d8e2ff",
                "secondary-container": "#b6ccff",
                "primary-container": "#2170e4",
                "on-tertiary-fixed": "#311400",
                "on-primary": "#ffffff",
                "inverse-surface": "#2a3138",
                "surface-dim": "#d4dbe3",
                "surface": "#f6f9ff",
                "tertiary-fixed-dim": "#ffb786",
                "primary": "#0058be",
                "surface-container-highest": "#dce3ec",
                "secondary-fixed-dim": "#b1c6f9",
                "on-secondary-container": "#405682",
                "on-primary-fixed": "#001a42",
                "tertiary-container": "#b75b00",
                "on-secondary-fixed": "#001a42",
                "on-error": "#ffffff",
                "surface-container-high": "#e2e9f2",
                "surface-bright": "#f6f9ff",
                "tertiary": "#924700",
                "on-error-container": "#93000a",
                "on-surface": "#151c23",
                "on-tertiary": "#ffffff",
                "outline": "#727785",
                "error-container": "#ffdad6",
                "primary-fixed": "#d8e2ff",
                "on-tertiary-fixed-variant": "#723600",
                "background": "#f6f9ff",
                "on-tertiary-container": "#fffbff"
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
        }
      }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .signature-gradient {
            background: linear-gradient(135deg, #0058be 0%, #2170e4 100%);
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased min-h-screen flex flex-col">

@if(session('success'))
<div class="fixed top-24 right-8 z-[60]" id="toast-success">
    <div class="bg-surface-container-lowest border-l-4 border-green-500 p-4 rounded-xl shadow-2xl flex items-center gap-4">
        <div class="bg-green-100 p-2 rounded-full text-green-600">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <div>
            <p class="font-headline font-bold text-on-surface">Berhasil!</p>
            <p class="text-xs text-on-surface-variant">{{ session('success') }}</p>
        </div>
        <button class="ml-4 text-outline hover:text-on-surface" onclick="document.getElementById('toast-success').remove()">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    </div>
</div>
@endif

<x-admin.navbar active="dashboard" />

<main class="flex-grow w-full max-w-7xl mx-auto px-8 py-10">
    <header class="mb-10 max-w-2xl">
        <h1 class="text-4xl font-extrabold text-on-surface tracking-tight mb-2">Pusat Kendali Admin</h1>
        <p class="text-on-surface-variant text-lg">Pantau dan kelola seluruh aspirasi serta sarana sekolah dalam satu dasbor terpadu.</p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-transparent transition-all hover:scale-[0.98] cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-primary/10 p-3 rounded-xl text-primary">
                    <span class="material-symbols-outlined text-2xl">group</span>
                </div>
            </div>
            <p class="text-on-surface-variant text-sm font-medium">Total Siswa</p>
            <p class="font-headline text-3xl font-bold text-on-surface mt-1">{{ number_format($totalSiswa ?? 0) }}</p>
        </div>
        
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-transparent transition-all hover:scale-[0.98] cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-secondary/10 p-3 rounded-xl text-secondary">
                    <span class="material-symbols-outlined text-2xl">description</span>
                </div>
            </div>
            <p class="text-on-surface-variant text-sm font-medium">Total Laporan</p>
            <p class="font-headline text-3xl font-bold text-on-surface mt-1">{{ number_format($totalLaporan ?? 0) }}</p>
        </div>
        
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-warning transition-all hover:scale-[0.98] cursor-default border-l-4 border-yellow-400">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-yellow-100 p-3 rounded-xl text-yellow-700">
                    <span class="material-symbols-outlined text-2xl">pending_actions</span>
                </div>
            </div>
            <p class="text-on-surface-variant text-sm font-medium">Laporan Menunggu</p>
            <p class="font-headline text-3xl font-bold text-on-surface mt-1">{{ number_format($laporanMenunggu ?? 0) }}</p>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-transparent transition-all hover:scale-[0.98] cursor-default border-l-4 border-primary">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-tertiary-container/10 p-3 rounded-xl text-tertiary-container">
                    <span class="material-symbols-outlined text-2xl">schedule</span>
                </div>
            </div>
            <p class="text-on-surface-variant text-sm font-medium">Laporan Diproses</p>
            <p class="font-headline text-3xl font-bold text-on-surface mt-1">{{ number_format($laporanProses ?? 0) }}</p>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-transparent transition-all hover:scale-[0.98] cursor-default border-l-4 border-green-500">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-emerald-100 p-3 rounded-xl text-emerald-700">
                    <span class="material-symbols-outlined text-2xl">check_circle</span>
                </div>
            </div>
            <p class="text-on-surface-variant text-sm font-medium">Laporan Selesai</p>
            <p class="font-headline text-3xl font-bold text-on-surface mt-1">{{ number_format($laporanSelesai ?? 0) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm">
            <h2 class="text-xl font-extrabold text-on-surface tracking-tight mb-6">Statistik Status Laporan</h2>
            <div class="h-[300px] flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm">
            <h2 class="text-xl font-extrabold text-on-surface tracking-tight mb-6">Laporan Berdasarkan Kategori</h2>
            <div class="h-[300px]">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <section class="bg-surface-container-lowest rounded-xl p-8 shadow-sm transition-shadow hover:shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-on-surface tracking-tight">Laporan Terbaru</h2>
                <p class="text-on-surface-variant text-sm mt-1">Daftar pengaduan masuk yang memerlukan perhatian segera.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.index') }}" class="bg-surface-container-high px-4 py-2 rounded-xl text-sm font-bold text-primary flex items-center gap-2 hover:bg-surface-container-highest transition-colors">
                    <span class="material-symbols-outlined text-lg">visibility</span>
                    Lihat Semua
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-outline text-xs font-bold uppercase tracking-widest border-b border-surface-container">
                        <th class="pb-4 px-4 w-16">#</th>
                        <th class="pb-4 px-4">Siswa</th>
                        <th class="pb-4 px-4">Kategori</th>
                        <th class="pb-4 px-4">Status</th>
                        <th class="pb-4 px-4">Tanggal</th>
                        <th class="pb-4 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium text-on-surface">
                    @if($laporanTerbaru->isEmpty())
                    <tr>
                        <td colspan="6" class="py-8 text-center text-on-surface-variant">Belum ada laporan.</td>
                    </tr>
                    @else
                    @foreach($laporanTerbaru as $item)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="py-4 px-4 font-headline text-outline group-hover:text-primary">
                            {{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs uppercase">{{ substr($item->siswa->nama, 0, 2) }}</div>
                                <span>{{ $item->siswa->nama }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-on-surface-variant">{{ $item->kategori->nama_kategori }}</td>
                        <td class="py-4 px-4">
                            @php $stat = $item->aspirasi?->status ?? 'menunggu'; @endphp
                            @if($stat == 'menunggu')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menunggu</span>
                            @elseif($stat == 'proses')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Proses</span>
                            @else
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Selesai</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-on-surface-variant text-[11px] font-mono">{{ $item->created_at->format('d/m/Y H:i:s') }} WIB</td>
                        <td class="py-4 px-4 text-right">
                            <a href="{{ route('admin.laporan.show', $item->id) }}" class="text-outline hover:text-primary transition-colors">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-8 flex justify-center">
            <a href="{{ route('admin.laporan.index') }}" class="signature-gradient text-white px-8 py-3 rounded-xl font-bold flex items-center gap-2 hover:scale-[0.98] transition-all shadow-lg shadow-primary/20">
                Lihat Semua Laporan
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    </section>
</main>

@include('layouts.footer')

<script>
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Proses', 'Selesai'],
            datasets: [{
                data: [{{ $laporanMenunggu }}, {{ $laporanProses }}, {{ $laporanSelesai }}],
                backgroundColor: ['#facc15', '#0058be', '#10b981'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: { family: 'Inter', weight: 'bold' }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Laporan',
                data: {!! json_encode($chartData) !!},
                backgroundColor: '#adc6ff',
                hoverBackgroundColor: '#0058be',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Inter' }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter' }
                    }
                }
            }
        }
    });
</script>
</body></html>