<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Detail Laporan | APSS Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
     <!-- SweetAlert2 -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .signature-gradient { background: linear-gradient(135deg, #0058be 0%, #2170e4 100%); }
        
        @media print {
            body { background: white !important; }
            nav, header, footer, button, .sidebar, .print-hidden { display: none !important; }
            .bg-surface-container-lowest, .bg-surface-container-low { 
                box-shadow: none !important; 
                border: 1px solid #eee !important;
                background: white !important;
            }
            main { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
            .shadow-\[0_8px_30px_rgb\(0\,0\,0\,0\.04\)\] { box-shadow: none !important; }
            .print-only { display: block !important; }
        }
        .print-only { display: none; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface min-h-screen flex flex-col">
<header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-surface-variant/10">
    <nav class="flex justify-between items-center px-8 h-16 w-full max-w-screen-2xl mx-auto">
        <div class="flex items-center gap-8">
            <div class="text-2xl font-black tracking-tight text-blue-800 font-headline">APSS</div>
            <div class="hidden md:flex gap-6 items-center">
                <a class="text-slate-500 font-medium hover:text-primary transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="text-slate-500 font-medium hover:text-primary transition-colors" href="{{ route('admin.siswa.index') }}">Siswa</a>
                <a class="text-slate-500 font-medium hover:text-primary transition-colors" href="{{ route('admin.kategori.index') }}">Kategori</a>
                <a class="text-primary font-bold border-b-2 border-primary pb-1" href="{{ route('admin.laporan.index') }}">Laporan</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.akun') }}" class="flex items-center gap-3 px-3 py-1.5 rounded-lg hover:bg-slate-50 transition-colors group">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all shadow-sm ring-1 ring-black/5">
                    @if(Auth::guard('admin')->user()->foto)
                        <img src="{{ asset('storage/' . Auth::guard('admin')->user()->foto) }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-[20px]">shield_person</span>
                    @endif
                </div>
                <span class="text-sm font-bold text-on-surface-variant group-hover:text-primary">{{ Auth::guard('admin')->user()->nama }}</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" id="form-logout">
                @csrf
                <button type="button" onclick="confirmLogout()" class="text-slate-500 hover:text-error transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                </button>
            </form>
        </div>
    </nav>
</header>

<main class="max-w-screen-2xl mx-auto px-8 py-10 flex-grow w-full">
    <div class="mb-10">
        <nav class="flex text-[10px] font-bold uppercase tracking-widest text-outline mb-2">
            <span>Admin</span>
            <span class="mx-2 opacity-30">/</span>
            <a href="{{ route('admin.laporan.index') }}" class="hover:text-primary transition-colors">Daftar Laporan</a>
            <span class="mx-2 opacity-30">/</span>
            <span class="text-primary">Detail Laporan</span>
        </nav>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.laporan.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-outline hover:text-primary transition-colors print-hidden">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div class="flex-grow">
                <h1 class="text-4xl font-extrabold text-on-surface tracking-tight font-headline">Detail Pengaduan Siswa</h1>
            </div>
            <button onclick="window.print()" class="bg-white px-6 py-2.5 rounded-xl border border-surface-variant/20 shadow-sm font-bold text-sm text-on-surface-variant flex items-center gap-2 hover:bg-slate-50 transition-all print-hidden">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak Laporan
            </button>
        </div>
        
        <div class="print-only mb-8 text-center border-b-2 border-primary pb-6">
            <h2 class="text-2xl font-black text-primary font-headline">APSS - APLIKASI PENGADUAN SARANA SEKOLAH</h2>
            <p class="text-xs font-bold text-outline mt-1 uppercase tracking-widest">Dokumen Laporan Pengaduan Resmi</p>
        </div>
    </div>

    @if(session('success'))
    <div class="fixed top-20 right-8 z-[100] animate-in fade-in slide-in-from-right-4 duration-300" id="toast-success">
        <div class="bg-white border-l-4 border-green-500 p-4 rounded-xl shadow-2xl flex items-center gap-4">
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>
            <div>
                <p class="font-bold text-on-surface text-sm">Update Berhasil</p>
                <p class="text-on-surface-variant text-xs">{{ session('success') }}</p>
            </div>
            <button class="text-outline hover:text-on-surface ml-4" onclick="document.getElementById('toast-success').remove()">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-20 right-8 z-[100] animate-in fade-in slide-in-from-right-4 duration-300" id="toast-error">
        <div class="bg-white border-l-4 border-red-500 p-4 rounded-xl shadow-2xl flex items-center gap-4">
            <div class="w-10 h-10 bg-red-50 text-red-600 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">error</span>
            </div>
            <div>
                <p class="font-bold text-on-surface text-sm">Update Gagal</p>
                <p class="text-on-surface-variant text-xs">{{ session('error') }}</p>
            </div>
            <button class="text-outline hover:text-on-surface ml-4" onclick="document.getElementById('toast-error').remove()">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Sisi Kiri: Detail Laporan --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Kartu Siswa --}}
            <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center gap-6 border border-surface-variant/5">
                <div class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-black text-2xl uppercase">
                    {{ substr($laporan->siswa->nama, 0, 2) }}
                </div>
                <div>
                    <h2 class="text-2xl font-black text-on-surface tracking-tight font-headline">{{ $laporan->siswa->nama }}</h2>
                    <div class="flex items-center gap-4 mt-1">
                        <p class="text-sm font-medium text-on-surface-variant flex items-center gap-1.5 leading-none">
                            <span class="material-symbols-outlined text-sm text-outline">badge</span>
                            {{ $laporan->siswa->nis }}
                        </p>
                        <p class="text-sm font-medium text-on-surface-variant flex items-center gap-1.5 leading-none pl-4 border-l border-surface-variant/20">
                            <span class="material-symbols-outlined text-sm text-outline">school</span>
                            {{ $laporan->siswa->kelas }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Isi Laporan --}}
            <div class="bg-surface-container-lowest rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden border border-surface-variant/5">
                <div class="px-8 py-5 border-b border-surface-variant/10 bg-surface-container-low/30">
                    <h3 class="text-xs font-black uppercase tracking-widest text-outline">Informasi Pengaduan</h3>
                </div>
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-outline mb-1">Kategori</p>
                            <p class="font-bold text-on-surface">{{ $laporan->kategori->nama_kategori }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-outline mb-1">Tanggal Pengaduan</p>
                            <p class="font-bold text-on-surface text-sm font-mono">{{ $laporan->created_at->format('d/m/Y H:i:s') }} WIB</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-outline mb-1">Lokasi Kejadian</p>
                        <p class="font-bold text-on-surface">{{ $laporan->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-outline mb-3">Keterangan Pengaduan</p>
                        <div class="bg-surface/50 rounded-xl p-5 border border-surface-variant/10">
                            <p class="text-on-surface-variant text-sm leading-relaxed whitespace-pre-line">{{ $laporan->ket }}</p>
                        </div>
                    </div>
                    @if($laporan->foto)
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-outline mb-3">Foto Kerusakan</p>
                        <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kerusakan" class="max-w-full h-auto rounded-xl border border-surface-variant/10 shadow-md"/>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Feedback Section --}}
            @if($laporan->aspirasi?->feedback)
            <div class="bg-amber-50 rounded-2xl p-8 border border-amber-100 flex items-center gap-6">
                <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center text-amber-500">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-amber-800 opacity-70">Feedback Siswa</h3>
                    <p class="text-xl font-black text-amber-900 mt-0.5">
                        {{ $laporan->aspirasi->feedback_label }}
                    </p>
                </div>
            </div>
            @endif
        </div>

        {{-- Sisi Kanan: Status & Navigasi --}}
        <div class="space-y-6 print-hidden">
            <div class="bg-surface-container-lowest rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-surface-variant/5">
                <h3 class="text-xs font-black uppercase tracking-widest text-outline mb-6">Kelola Progress</h3>
                
                <div class="mb-8">
                    <p class="text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Status Saat Ini</p>
                    @if($laporan->status == 'menunggu')
                        <div class="bg-amber-50 text-amber-700 px-4 py-3 rounded-xl border border-amber-200/50 flex items-center gap-3">
                            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                            <span class="font-black text-xs uppercase tracking-wider">Menunggu Diproses</span>
                        </div>
                    @elseif($laporan->status == 'proses')
                        <div class="bg-blue-50 text-blue-700 px-4 py-3 rounded-xl border border-blue-200/50 flex items-center gap-3">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span class="font-black text-xs uppercase tracking-wider">Dalam Penanganan</span>
                        </div>
                    @elseif($laporan->status == 'selesai')
                        <div class="bg-green-50 text-green-700 px-4 py-3 rounded-xl border border-green-200/50 flex items-center gap-3">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="font-black text-xs uppercase tracking-wider">Selesai Menangani</span>
                        </div>
                    @endif
                </div>

                <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-outline uppercase tracking-widest pl-1">Update Status:</label>
                        <select name="status" class="w-full bg-surface border-2 border-surface-variant/10 rounded-xl py-3.5 px-4 font-bold text-sm focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all cursor-pointer">
                            <option value="proses" {{ $laporan->aspirasi?->status === 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $laporan->aspirasi?->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-outline uppercase tracking-widest pl-1">Tanggapan Admin:</label>
                        <textarea name="keterangan" rows="4" class="w-full bg-surface border-2 border-surface-variant/10 rounded-xl py-3.5 px-4 font-medium text-sm focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all placeholder:text-outline/40 leading-relaxed" placeholder="Tulis progress atau solusi di sini...">{{ $laporan->aspirasi->keterangan ?? '' }}</textarea>
                    </div>

                    @if($laporan->aspirasi?->status === 'selesai' || request()->input('status') === 'selesai')
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-outline uppercase tracking-widest pl-1 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">image</span>
                            Foto Perbaikan (Opsional)
                        </label>
                        <input type="file" name="foto_perbaikan" id="fotoPerbaikan" accept="image/*" class="w-full bg-surface border-2 border-surface-variant/10 rounded-xl py-3.5 px-4 font-medium text-sm focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all cursor-pointer" onchange="previewRepairImage(event)"/>
                        <p class="text-[10px] text-on-surface-variant">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                        @if($laporan->aspirasi?->foto_perbaikan)
                        <div class="mt-3 p-3 bg-surface-container-low rounded-lg border border-surface-variant/20">
                            <p class="text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Foto Perbaikan Saat Ini:</p>
                            <img src="{{ asset('storage/' . $laporan->aspirasi->foto_perbaikan) }}" alt="Foto Perbaikan" class="max-w-full h-24 object-cover rounded-lg"/>
                        </div>
                        @endif
                        <div id="repairPreviewContainer" class="mt-3 hidden">
                            <p class="text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Preview:</p>
                            <img id="repairPreviewImage" src="" alt="Preview" class="max-w-full h-40 object-cover rounded-lg shadow-md"/>
                        </div>
                    </div>
                    @endif

                    <button type="submit" class="w-full signature-gradient text-white font-black py-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[0.98] transition-all flex items-center justify-center gap-3 active:scale-95">
                        Update Status
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </form>

                <script>
                    function previewRepairImage(event) {
                        const file = event.target.files[0];
                        const preview = document.getElementById('repairPreviewImage');
                        const container = document.getElementById('repairPreviewContainer');
                        const allowedFormats = ['image/jpeg', 'image/png', 'image/gif'];
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        
                        if (file) {
                            // Validasi format
                            if (!allowedFormats.includes(file.type)) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Format Tidak Sesuai',
                                    text: 'Hanya format JPG, PNG, dan GIF yang didukung.',
                                    confirmButtonColor: '#0058be'
                                });
                                event.target.value = '';
                                container.classList.add('hidden');
                                return;
                            }
                            
                            // Validasi ukuran
                            if (file.size > maxSize) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ukuran File Terlalu Besar',
                                    text: 'Ukuran file maksimal 2MB.',
                                    confirmButtonColor: '#0058be'
                                });
                                event.target.value = '';
                                container.classList.add('hidden');
                                return;
                            }
                            
                            // Validasi passed, show preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                container.classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            container.classList.add('hidden');
                        }
                    }
                </script>
            </div>

            <a href="{{ route('admin.laporan.index') }}" class="w-full bg-white hover:bg-surface-container-low text-on-surface-variant font-black py-4 rounded-xl border border-surface-variant/10 transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-widest shadow-sm">
                <span class="material-symbols-outlined text-lg opacity-60">arrow_back</span>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</main>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Logout Admin?',
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

    function previewRepairImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('repairPreviewImage');
        const container = document.getElementById('repairPreviewContainer');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            container.classList.add('hidden');
        }
    }

    // Auto-hide toast after 3 seconds
    setTimeout(() => {
        ['toast-success', 'toast-error'].forEach(id => {
            const toast = document.getElementById(id);
            if (toast) {
                toast.style.transition = 'all 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 500);
            }
        });
    }, 3000);
</script>
@include('layouts.footer')
</body></html>