<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Pengaturan Akun | APSS Admin</title>
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
    </style>
</head>
<body class="bg-surface font-body text-on-surface min-h-screen flex flex-col">
<x-admin.navbar active="" />

<main class="max-w-screen-xl mx-auto px-8 py-12 flex-grow w-full">
    <div class="mb-12 text-center lg:text-left">
        <h1 class="text-5xl font-black text-on-surface tracking-tighter font-headline uppercase leading-tight">Profil Admin</h1>
        <p class="text-on-surface-variant font-medium mt-1 leading-relaxed max-w-2xl">Kelola informasi kredensial administrator, identitas visual, dan perbarui kata sandi secara berkala untuk menjaga keamanan sistem.</p>
    </div>

    @if(session('success'))
    <div class="bg-white border-l-4 border-primary p-5 rounded-2xl shadow-[0_10px_40px_rgba(0,88,190,0.1)] mb-10 flex items-center gap-5 animate-in fade-in slide-in-from-top-4 duration-300" id="toast-success">
        <div class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <div>
            <p class="font-black text-on-surface text-sm tracking-tight uppercase">Aksi Berhasil</p>
            <p class="text-on-surface-variant text-xs font-semibold">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        {{-- Sisi Kiri: Profil & Foto --}}
        <div class="lg:col-span-2">
            <form action="{{ route('admin.akun') }}" method="POST" enctype="multipart/form-data" class="bg-surface-container-lowest rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-surface-variant/5">
                @csrf
                <div class="flex flex-col md:flex-row items-center gap-12 mb-12 pb-12 border-b border-surface-variant/10">
                    <div class="relative group">
                        <div class="w-44 h-44 rounded-[3rem] bg-surface-container-low border-8 border-white shadow-2xl overflow-hidden flex items-center justify-center relative ring-1 ring-surface-variant/20 hover:scale-105 transition-transform duration-500">
                            @if($admin->foto)
                                <img id="preview-img" src="{{ asset('storage/' . $admin->foto) }}" class="w-full h-full object-cover">
                            @else
                                <div id="placeholder-icon" class="flex flex-col items-center text-outline/30">
                                    <span class="material-symbols-outlined text-6xl">account_circle</span>
                                </div>
                            @endif
                            <img id="new-preview" class="w-full h-full object-cover absolute inset-0 hidden">
                            <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                 <span class="material-symbols-outlined text-white text-3xl">add_a_photo</span>
                            </div>
                        </div>
                        <label for="foto" class="absolute -bottom-2 -right-2 w-14 h-14 signature-gradient text-white rounded-2xl flex items-center justify-center cursor-pointer shadow-2xl hover:scale-110 transition-transform active:scale-95 border-4 border-white ring-2 ring-primary/20">
                            <span class="material-symbols-outlined text-[28px]">upload</span>
                            <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                    <div class="flex-grow text-center md:text-left space-y-4">
                        <h3 class="text-2xl font-black text-on-surface font-headline tracking-tighter uppercase">Foto Profil Admin</h3>
                        <p class="text-sm text-on-surface-variant font-medium leading-relaxed max-w-sm">Identitas visual membantu dalam validasi log aktivitas admin. Gunakan foto yang memperlihatkan wajah dengan jelas.</p>
                        @error('foto')
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-error/5 text-error rounded-lg border border-error/10">
                                <span class="material-symbols-outlined text-sm font-bold">error</span>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-[0.2em] text-outline/60 ml-1" for="nama">Nama Lengkap Admin</label>
                        <div class="relative group">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline/40 group-focus-within:text-primary transition-colors">badge</span>
                            <input required name="nama" id="nama" type="text" value="{{ $admin->nama }}" class="w-full pl-14 pr-6 py-5 bg-surface border-2 border-surface-variant/10 rounded-[1.5rem] font-bold text-sm focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all outline-none" placeholder="Masukkan nama resmi admin">
                        </div>
                        @error('nama')
                            <p class="text-[10px] text-error font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-[0.2em] text-outline/60 ml-1" for="username">ID / Username Akses</label>
                        <div class="relative group">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline/40 group-focus-within:text-primary transition-colors">person</span>
                            <input required name="username" id="username" type="text" value="{{ $admin->username }}" class="w-full pl-14 pr-6 py-5 bg-surface border-2 border-surface-variant/10 rounded-[1.5rem] font-bold text-sm focus:ring-8 focus:ring-primary/5 focus:border-primary transition-all outline-none" placeholder="Username untuk login">
                        </div>
                        @error('username')
                            <p class="text-[10px] text-error font-black uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-12">
                    <button type="submit" class="w-full signature-gradient text-white font-black py-5 rounded-[1.5rem] shadow-2xl shadow-primary/30 hover:scale-[0.98] transition-all active:scale-95 flex items-center justify-center gap-4 text-sm tracking-widest uppercase">
                        <span class="material-symbols-outlined">verified_user</span>
                        Simpan Identitas Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- Sisi Kanan: Password --}}
        <div>
            <div class="bg-surface-container-lowest rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-surface-variant/5">
                <div class="flex items-center gap-5 mb-10">
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 shadow-xl shadow-amber-500/10">
                        <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">security</span>
                    </div>
                    <div>
                        <h3 class="font-black text-on-surface text-lg leading-none tracking-tight">Privasi</h3>
                        <p class="text-[10px] text-outline font-black uppercase tracking-widest mt-1 opacity-60">Update Keamanan</p>
                    </div>
                </div>

                <form action="{{ route('admin.akun.password') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-2.5">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-outline/60 ml-1" for="password_lama">Kata Sandi Lama</label>
                        <input required name="password_lama" id="password_lama" type="password" class="w-full px-6 py-4 bg-surface border-2 border-surface-variant/10 rounded-2xl font-bold text-sm focus:border-amber-500 transition-all outline-none" placeholder="••••••••"/>
                        @error('password_lama')
                             <p class="text-[9px] text-error font-black uppercase tracking-widest mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2.5">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-outline/60 ml-1" for="password_baru">Kata Sandi Baru</label>
                        <input required name="password_baru" id="password_baru" type="password" class="w-full px-6 py-4 bg-surface border-2 border-surface-variant/10 rounded-2xl font-bold text-sm focus:border-amber-500 transition-all outline-none" placeholder="Minimal 6 karakter"/>
                    </div>
                    <div class="space-y-2.5">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-outline/60 ml-1" for="password_baru_confirmation">Konfirmasi Baru</label>
                        <input required name="password_baru_confirmation" id="password_baru_confirmation" type="password" class="w-full px-6 py-4 bg-surface border-2 border-surface-variant/10 rounded-2xl font-bold text-sm focus:border-amber-500 transition-all outline-none" placeholder="Ulangi kata sandi baru"/>
                    </div>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black py-5 rounded-[1.5rem] shadow-xl shadow-amber-500/30 hover:scale-[0.98] transition-all active:scale-95 flex items-center justify-center gap-3 text-xs tracking-widest uppercase">
                        Perbarui Keamanan
                        <span class="material-symbols-outlined text-[18px]">key</span>
                    </button>
                </form>
            </div>
            <div class="mt-10 p-8 rounded-[2rem] bg-blue-50 border border-blue-100/50">
                <div class="flex gap-4 items-start">
                    <span class="material-symbols-outlined text-blue-600">info</span>
                    <div>
                        <p class="text-xs font-black text-blue-900 uppercase tracking-widest mb-1">Security Tip</p>
                        <p class="text-[11px] text-blue-800/70 leading-relaxed font-medium">Gunakan kombinasi huruf besar, angka, dan simbol untuk password yang lebih kuat. Jangan berikan kredensial login kepada pihak manapun.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-img');
                const newPreview = document.getElementById('new-preview');
                const placeholder = document.getElementById('placeholder-icon');

                if (previewImg) previewImg.classList.add('hidden');
                if (placeholder) placeholder.classList.add('hidden');
                
                newPreview.src = e.target.result;
                newPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function confirmLogout() {
        Swal.fire({
            title: 'Logout dari Sistem?',
            text: 'Sesi akses administrator Anda akan dihentikan sepenuhnya.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ba1a1a',
            cancelButtonColor: '#727785',
            confirmButtonText: 'Ya, Keluar Akun',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl font-bold px-6 py-3',
                cancelButton: 'rounded-xl font-bold px-6 py-3'
            }
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
@include('layouts.footer')
</body></html>