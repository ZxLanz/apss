<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Buat Laporan Pengaduan | APSS</title>
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
        .frosted-glass {
            backdrop-filter: blur(12px);
            background-color: rgba(237, 244, 253, 0.8);
        }
        /* Hapus dropdown arrow bawaan browser */
        select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: none !important;
            padding-right: 2.5rem !important;
        }
        select::-ms-expand {
            display: none !important;
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface flex flex-col min-h-screen">
<header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-50 shadow-sm dark:shadow-none">
    <nav class="flex justify-between items-center px-8 h-16 w-full max-w-screen-2xl mx-auto">
        <div class="text-2xl font-black tracking-tight text-blue-800 dark:text-blue-300">
            APSS
        </div>
        <div class="hidden md:flex gap-8 items-center">
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 transition-colors" href="{{ route('siswa.dashboard') }}">Dashboard</a>
            <a class="text-blue-700 dark:text-blue-400 font-bold border-b-2 border-blue-600" href="{{ route('siswa.laporan.create') }}">Buat Laporan</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('siswa.akun.edit') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer group">
                <span class="material-symbols-outlined text-outline group-hover:text-primary">person</span>
                <span class="text-sm font-medium text-on-surface-variant group-hover:text-primary">Akun Saya</span>
            </a>
            <form action="{{ route('siswa.logout') }}" method="POST" id="form-logout">
                @csrf
                <button type="button" onclick="confirmLogout()" class="text-blue-700 dark:text-blue-400 font-bold px-4 py-2 rounded-lg hover:bg-slate-50 transition-colors scale-95 duration-150 ease-in-out">
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
            </script>
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
                <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight leading-tight">
                    Buat Laporan Pengaduan
                </h1>
                <p class="text-on-surface-variant font-medium text-sm mt-1">Sampaikan keluhan Anda dengan detail untuk penanganan yang lebih cepat.</p>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-lg mb-6 flex items-start gap-3 border-l-4 border-red-500">
            <span class="material-symbols-outlined mt-0.5">error_outline</span>
            <ul class="text-sm list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-amber-50 text-amber-900 p-5 rounded-xl mb-6 flex items-start gap-4 border-l-4 border-amber-500 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="bg-amber-100 p-2 rounded-full text-amber-600">
                <span class="material-symbols-outlined">warning_amber</span>
            </div>
            <div>
                <p class="font-bold text-sm tracking-tight">Perhatian</p>
                <p class="text-xs mt-1 leading-relaxed opacity-90">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="bg-surface-container-lowest rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 md:p-10">
            <form action="{{ route('siswa.laporan.store') }}" method="POST" class="space-y-6" id="form-laporan" enctype="multipart/form-data" onsubmit="return validateForm(event)">
                @csrf
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface tracking-wide" for="kategori_id">Kategori</label>
                    <div class="relative">
                        <select required class="w-full bg-surface-container-highest border-none rounded-lg py-3.5 px-4 text-on-surface focus:ring-2 focus:ring-primary/40 cursor-pointer pr-10" id="kategori_id" name="kategori_id">
                            <option disabled selected value="">Pilih Kategori</option>
                            @php $categories = \App\Models\Kategori::all() @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="material-symbols-outlined text-outline">expand_more</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface tracking-wide" for="lokasi">Lokasi Kejadian</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline group-focus-within:text-primary transition-colors">location_on</span>
                        </div>
                        <input required class="w-full bg-surface-container-highest border-none rounded-lg py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/40 transition-all" id="lokasi" name="lokasi" placeholder="Contoh: Ruang Kelas X RPL A" type="text" value="{{ old('lokasi') }}"/>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface tracking-wide" for="ket">Keterangan</label>
                    <textarea required class="w-full bg-surface-container-highest border-none rounded-lg py-3.5 px-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/40 transition-all resize-none" id="ket" name="ket" placeholder="Masukkan keterangan..." rows="5">{{ old('ket') }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface tracking-wide flex items-center gap-2" for="foto">
                        <span class="material-symbols-outlined">image</span>
                        Foto Kerusakan (Opsional)
                    </label>
                    <div class="relative group">
                        <input class="w-full bg-surface-container-highest border-none rounded-lg py-3.5 px-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/40 transition-all cursor-pointer" id="foto" name="foto" placeholder="Pilih foto..." type="file" accept="image/*" onchange="previewImage(event)"/>
                    </div>
                    <p class="text-xs text-on-surface-variant">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                    <div id="previewContainer" class="mt-3 hidden">
                        <img id="previewImage" src="" alt="Preview" class="max-w-full h-40 object-cover rounded-lg shadow-md"/>
                    </div>
                </div>
                <div class="pt-4">
                    <button id="submitBtn" class="w-full signature-gradient text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 flex items-center justify-center gap-3 group transition-all active:scale-95 duration-150" type="submit">
                        Kirim Laporan
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">send</span>
                    </button>
                </div>
            </form>
            <script>
                let hasFileValidationError = false;
                
                function previewImage(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('previewImage');
                    const container = document.getElementById('previewContainer');
                    const allowedFormats = ['image/jpeg', 'image/png', 'image/gif'];
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    
                    // Reset error flag
                    hasFileValidationError = false;
                    
                    if (file) {
                        // Validasi format
                        if (!allowedFormats.includes(file.type)) {
                            hasFileValidationError = true;
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
                            hasFileValidationError = true;
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
                
                function validateForm(event) {
                    if (hasFileValidationError) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Silakan pilih file gambar yang sesuai.',
                            confirmButtonColor: '#0058be'
                        });
                        return false;
                    }
                    
                    // Form valid, show loading
                    const btn = document.getElementById('submitBtn');
                    btn.disabled = true;
                    btn.innerHTML = '<span class=\'material-symbols-outlined animate-spin\'>sync</span> Mengirim...';
                    return true;
                }
            </script>
        </div>
        <div class="mt-8 flex items-start gap-4 p-4 bg-surface-container-low rounded-lg">
            <span class="material-symbols-outlined text-primary mt-0.5">info</span>
            <p class="text-xs text-on-secondary-fixed-variant leading-relaxed">
                Setiap laporan yang masuk akan diverifikasi dalam waktu 1x24 jam kerja. Anda dapat memantau status perkembangan laporan melalui menu <strong>Keluhan Saya / Dashboard</strong>.
            </p>
        </div>
    </div>
</main>
<footer class="bg-[#edf4fd] dark:bg-slate-950 flex flex-col md:flex-row justify-between items-center px-12 py-12 w-full border-t border-blue-100/20 mt-auto">
    <div class="mb-6 md:mb-0">
        <div class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-2">APSS</div>
        <p class="text-blue-900 dark:text-blue-200 text-sm font-normal opacity-70">
            © 2026 Academic Sentinel Complaint System. All Rights Reserved.
        </p>
    </div>
</footer>
@include('layouts.footer')
</body></html>

