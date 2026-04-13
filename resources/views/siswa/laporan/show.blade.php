<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Detail Laporan | APSS</title>
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
                    "on-error": "#ffffff",
                    "surface-tint": "#005ac2",
                    "secondary": "#495e8a",
                    "primary-fixed": "#d8e2ff",
                    "on-primary-container": "#fefcff",
                    "on-tertiary-container": "#fffbff",
                    "surface-container-low": "#edf4fd",
                    "on-tertiary": "#ffffff",
                    "on-primary": "#ffffff",
                    "inverse-primary": "#adc6ff",
                    "on-secondary": "#ffffff",
                    "surface-container": "#e7eff7",
                    "tertiary-fixed-dim": "#ffb786",
                    "primary": "#0058be",
                    "on-secondary-container": "#405682",
                    "tertiary-fixed": "#ffdcc6",
                    "secondary-container": "#b6ccff",
                    "on-background": "#151c23",
                    "surface-variant": "#dce3ec",
                    "on-secondary-fixed": "#001a42",
                    "primary-fixed-dim": "#adc6ff",
                    "surface": "#f6f9ff",
                    "on-surface-variant": "#424754",
                    "surface-bright": "#f6f9ff",
                    "secondary-fixed": "#d8e2ff",
                    "error-container": "#ffdad6",
                    "inverse-surface": "#2a3138",
                    "on-tertiary-fixed-variant": "#723600",
                    "on-surface": "#151c23",
                    "on-primary-fixed": "#001a42",
                    "primary-container": "#2170e4",
                    "background": "#f6f9ff",
                    "on-error-container": "#93000a",
                    "tertiary-container": "#b75b00",
                    "inverse-on-surface": "#eaf1fa",
                    "on-secondary-fixed-variant": "#304671",
                    "outline-variant": "#c2c6d6",
                    "surface-dim": "#d4dbe3",
                    "tertiary": "#924700",
                    "secondary-fixed-dim": "#b1c6f9",
                    "error": "#ba1a1a",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-highest": "#dce3ec",
                    "on-primary-fixed-variant": "#004395",
                    "outline": "#727785",
                    "on-tertiary-fixed": "#311400",
                    "surface-container-high": "#e2e9f2"
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .signature-gradient {
            background: linear-gradient(135deg, #0058be 0%, #2170e4 100%);
        }
        .glass-effect {
            backdrop-filter: blur(12px);
            background-color: rgba(237, 244, 253, 0.8);
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface flex flex-col min-h-screen">
<header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
    <nav class="flex justify-between items-center px-8 h-16 w-full max-w-screen-2xl mx-auto">
        <div class="text-2xl font-black tracking-tight text-blue-800 dark:text-blue-300 font-headline">
            APSS
        </div>
        <div class="hidden md:flex gap-8 items-center">
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-colors" href="{{ route('siswa.dashboard') }}">Dashboard</a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-colors" href="{{ route('siswa.laporan.create') }}">Buat Laporan</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('siswa.akun.edit') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer group">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-blue-100 flex items-center justify-center shrink-0 border border-white shadow-sm">
                    @if(Auth::guard('siswa')->user()->foto)
                        <img src="{{ asset('storage/' . Auth::guard('siswa')->user()->foto) }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-blue-600 text-[20px]">person</span>
                    @endif
                </div>
                <span class="text-sm font-medium text-on-surface-variant group-hover:text-primary">Akun Saya</span>
            </a>
            <form action="{{ route('siswa.logout') }}" method="POST" id="form-logout">
                @csrf
                <button type="button" onclick="confirmLogout()" class="text-blue-700 font-bold px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </nav>
</header>
<main class="flex-grow flex items-center justify-center py-12 px-6">
    <div class="w-full max-w-xl">
        <div class="mb-8 text-center md:text-left flex items-center gap-4">
            <a href="{{ route('siswa.dashboard') }}" class="text-outline hover:text-primary shrink-0 transition-colors bg-white rounded-full p-2 shadow-sm">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">
                    Detail Laporan
                </h1>
                <p class="text-on-surface-variant font-medium text-sm mt-1">ID Pengaduan #{{ str_pad($laporan->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 flex items-start gap-3 border-l-4 border-green-500 animate-in fade-in slide-in-from-top-4 duration-300" id="toast-success">
            <span class="material-symbols-outlined mt-0.5">check_circle</span>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="bg-surface-container-lowest rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
            {{-- Header Status --}}
            <div class="px-8 py-6 border-b border-surface-variant/20 bg-surface-container-low flex justify-between items-center">
                <span class="text-xs font-bold uppercase tracking-widest text-outline">Status Saat Ini</span>
                @if($laporan->status == 'menunggu')
                    <span class="px-4 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-black uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span> Menunggu
                    </span>
                @elseif($laporan->status == 'proses')
                    <span class="px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-xs font-black uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span> Proses
                    </span>
                @elseif($laporan->status == 'selesai')
                    <span class="px-4 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-black uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span> Selesai
                    </span>
                @endif
            </div>

            <div class="p-8 space-y-8">
                {{-- Info Utama --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-outline mb-1">Kategori</p>
                        <p class="font-bold text-on-surface">{{ $laporan->kategori->nama_kategori ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-outline mb-1">Tanggal</p>
                        <p class="font-bold text-on-surface text-xs font-mono">{{ $laporan->created_at->format('d/m/Y H:i:s') }} WIB</p>
                    </div>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-outline mb-1">Lokasi</p>
                    <p class="font-bold text-on-surface">{{ $laporan->lokasi }}</p>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-outline mb-2">Keterangan Laporan</p>
                    <div class="bg-surface-container-low p-4 rounded-lg border border-surface-variant/20">
                        <p class="text-on-surface-variant text-sm leading-relaxed whitespace-pre-line">{{ $laporan->ket }}</p>
                    </div>
                </div>

                {{-- Foto Kerusakan --}}
                @if($laporan->foto)
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-outline mb-3">📸 Foto Kerusakan</p>
                    <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kerusakan" class="max-w-full h-auto rounded-xl border border-surface-variant/20 shadow-md"/>
                </div>
                @endif

                {{-- Foto Perbaikan --}}
                @if($laporan->aspirasi?->foto_perbaikan)
                <div class="bg-green-50 p-6 rounded-xl border border-green-200">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-green-700 mb-3">✅ Foto Hasil Perbaikan</p>
                    <img src="{{ asset('storage/' . $laporan->aspirasi->foto_perbaikan) }}" alt="Foto Perbaikan" class="max-w-full h-auto rounded-lg border border-green-200 shadow-md"/>
                    <p class="text-xs text-green-700 mt-3">Perbaikan telah selesai dilakukan dan terbukti dengan foto hasil perbaikan di atas.</p>
                </div>
                @endif

                {{-- Tanggapan Admin --}}
                @if($laporan->aspirasi?->status == 'proses' || $laporan->aspirasi?->status == 'selesai')
                <div class="pt-4 border-t border-surface-variant/20">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-primary">forum</span>
                        <p class="text-sm font-bold text-on-surface">Tanggapan Administrator</p>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <p class="text-sm text-blue-900 leading-relaxed italic">"{{ $laporan->aspirasi->keterangan ?? 'Laporan Anda sedang kami tangani.' }}"</p>
                        <p class="text-[10px] text-blue-600 mt-2 font-medium">Direspon pada {{ $laporan->aspirasi->updated_at->format('d/m/Y H:i:s') }} WIB</p>
                    </div>
                </div>
                @endif

                {{-- Feedback Section --}}
                @if ($laporan->aspirasi?->status == 'selesai')
                <div class="pt-6 border-t border-surface-variant/20">
                    @if ($laporan->aspirasi->feedback)
                        <div class="bg-green-50 p-4 rounded-lg flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-green-800 uppercase tracking-wide">Peringkat Kepuasan Anda</p>
                                <p class="text-sm font-black text-green-900">
                                    {{ [1 => 'Tidak Puas', 2 => 'Kurang Puas', 3 => 'Cukup Puas', 4 => 'Puas', 5 => 'Sangat Puas'][$laporan->aspirasi->feedback] }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="text-center mb-6">
                            <p class="text-sm font-bold text-on-surface">Bagaimana pelayanan kami?</p>
                            <p class="text-xs text-on-surface-variant mt-1">Berikan bintang Anda untuk membantu kami meningkatkan layanan.</p>
                        </div>
                        <form action="{{ route('siswa.laporan.feedback', $laporan->aspirasi->id) }}" method="POST" id="feedback-form">
                            @csrf
                            <input type="hidden" name="feedback" id="feedback-value" required>
                            
                            {{-- Star Rating UI --}}
                            <div class="flex flex-col items-center gap-4">
                                <div class="flex justify-center gap-2">
                                    @foreach([1, 2, 3, 4, 5] as $val)
                                    <button type="button" 
                                            onclick="setRating({{ $val }})"
                                            onmouseover="hoverRating({{ $val }})"
                                            onmouseout="resetRating()"
                                            class="star-btn transition-all duration-200 transform hover:scale-125"
                                            data-value="{{ $val }}">
                                        <span class="material-symbols-outlined text-4xl text-slate-300" id="star-{{ $val }}">star</span>
                                    </button>
                                    @endforeach
                                </div>
                                <div id="rating-label" class="h-6 text-sm font-black text-primary transition-all duration-300 opacity-0 transform translate-y-2">
                                    Pilih Bintang
                                </div>
                            </div>
                            
                            <button type="submit" id="submit-feedback" disabled class="w-full mt-6 bg-slate-300 text-white py-4 rounded-xl font-bold text-sm shadow-md transition-all cursor-not-allowed">Kirim Feedback</button>
                        </form>

                        <script>
                            let currentRating = 0;
                            const labels = {
                                1: 'Tidak Puas',
                                2: 'Kurang Puas',
                                3: 'Cukup Puas',
                                4: 'Puas',
                                5: 'Sangat Puas'
                            };

                            function setRating(val) {
                                currentRating = val;
                                document.getElementById('feedback-value').value = val;
                                updateStars(val, true);
                                
                                // Enable submit button
                                const btn = document.getElementById('submit-feedback');
                                btn.disabled = false;
                                btn.classList.remove('bg-slate-300', 'cursor-not-allowed');
                                btn.classList.add('bg-primary', 'hover:opacity-90', 'active:scale-95');
                                
                                // Show label
                                const label = document.getElementById('rating-label');
                                label.textContent = labels[val];
                                label.classList.remove('opacity-0', 'translate-y-2');
                                label.classList.add('opacity-100', 'translate-y-0');
                            }

                            function hoverRating(val) {
                                updateStars(val, false);
                                const label = document.getElementById('rating-label');
                                label.textContent = labels[val];
                                label.classList.remove('opacity-0', 'translate-y-2');
                                label.classList.add('opacity-100', 'translate-y-0');
                            }

                            function resetRating() {
                                updateStars(currentRating, currentRating > 0);
                                const label = document.getElementById('rating-label');
                                if (currentRating > 0) {
                                    label.textContent = labels[currentRating];
                                } else {
                                    label.classList.add('opacity-0', 'translate-y-2');
                                    label.classList.remove('opacity-100', 'translate-y-0');
                                }
                            }

                            function updateStars(val, isActive) {
                                for (let i = 1; i <= 5; i++) {
                                    const star = document.getElementById('star-' + i);
                                    if (i <= val) {
                                        star.classList.remove('text-slate-300');
                                        star.classList.add('text-amber-400');
                                        star.style.fontVariationSettings = "'FILL' 1";
                                    } else {
                                        star.classList.add('text-slate-300');
                                        star.classList.remove('text-amber-400');
                                        star.style.fontVariationSettings = "'FILL' 0";
                                    }
                                }
                            }
                        </script>
                    @endif
                </div>
                @endif
            </div>

            {{-- Footer Action --}}
            <div class="px-8 py-5 bg-surface-container-lowest border-t border-surface-variant/20 flex justify-between items-center">
                <a href="{{ route('siswa.dashboard') }}" class="text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1.5 text-sm font-bold">
                    <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
                </a>

                @if($laporan->status == 'menunggu')
                <form action="{{ route('siswa.laporan.destroy', $laporan->id) }}" method="POST" id="form-hapus">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete()" class="text-error hover:underline flex items-center gap-1 text-sm font-bold opacity-70 hover:opacity-100 transition-opacity">
                        <span class="material-symbols-outlined text-lg">delete</span> Batalkan Laporan
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari aplikasi?',
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

    function confirmDelete() {
        Swal.fire({
            title: 'Batalkan Laporan ini?',
            text: "Laporan yang ditarik tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ba1a1a',
            cancelButtonColor: '#727785',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus').submit();
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
</body></html>
