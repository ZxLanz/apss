<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Akun Saya | APSS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-[#f6f9ff] font-['Inter'] text-slate-800">
    <!-- Navbar (Simplified for Account) -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <a href="{{ route('siswa.dashboard') }}" class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                        <span class="material-symbols-outlined">school</span>
                    </a>
                    <span class="text-xl font-bold text-slate-900 tracking-tight">APSS</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('siswa.dashboard') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Pengaturan Akun</h1>
            <p class="text-slate-500 font-medium">Kelola informasi profil dan foto identitas Anda.</p>
        </div>

        @if(session('success'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-700 animate-in fade-in slide-in-from-top-4 duration-500" id="toast-success">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        <form action="{{ route('siswa.akun.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Profile Picture Section -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-3xl bg-slate-100 border-4 border-white shadow-xl overflow-hidden flex items-center justify-center relative">
                            @if($siswa->foto)
                                <img id="preview-img" src="{{ asset('storage/' . $siswa->foto) }}" class="w-full h-full object-cover">
                            @else
                                <div id="placeholder-icon" class="flex flex-col items-center text-slate-400">
                                    <span class="material-symbols-outlined text-4xl">person</span>
                                </div>
                            @endif
                            <img id="new-preview" class="w-full h-full object-cover absolute inset-0 hidden">
                        </div>
                        <label for="foto" class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center cursor-pointer shadow-lg hover:scale-110 transition-transform active:scale-95 border-2 border-white">
                            <span class="material-symbols-outlined text-[20px]">add_a_photo</span>
                            <input type="file" name="foto" id="foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                    <div class="flex-grow text-center md:text-left space-y-2">
                        <h3 class="text-lg font-bold text-slate-800">Foto Profil</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Gunakan foto asli Anda untuk memudahkan identifikasi oleh petugas sekolah. Format JPG/PNG, maksimal 2MB.</p>
                        @error('foto')
                            <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Basic Info Section -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIS (Readonly) -->
                    <div class="space-y-2 lg:col-span-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Nomor Induk Siswa (NIS)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">id_card</span>
                            <input type="text" value="{{ $siswa->nis }}" readonly class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-xl text-slate-400 font-mono text-sm cursor-not-allowed">
                        </div>
                        <p class="text-[10px] text-slate-400 ml-1">*NIS tidak dapat diubah secara mandiri.</p>
                    </div>

                    <!-- Nama -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 group-focus-within:text-blue-600 transition-colors">person</span>
                            <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none" placeholder="Nama lengkap sesuai ijazah">
                        </div>
                        @error('nama')
                            <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Kelas</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 group-focus-within:text-blue-600 transition-colors">groups</span>
                            <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: XII PPLG B">
                        </div>
                        @error('kelas')
                            <p class="text-xs text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 rounded-xl shadow-lg shadow-blue-500/25 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </main>
</div>

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
</body>
</html>