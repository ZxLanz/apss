<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Edit Siswa | APSS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0058be",
                        error: "#ba1a1a",
                        outline: "#727785",
                        "on-surface": "#151c23",
                        "surface": "#f6f9ff",
                        "surface-container": "#e7eff7",
                        "surface-container-low": "#edf4fd",
                        "surface-container-lowest": "#ffffff",
                        "surface-variant": "#dce3ec",
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
        .signature-gradient { background: linear-gradient(135deg, #0058be 0%, #2170e4 100%); }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen">
<x-admin.navbar active="siswa" />

<main class="max-w-screen-2xl mx-auto px-8 py-8">
    <div class="mb-10">
        <nav class="flex text-sm font-medium text-on-surface-variant mb-2">
            <a href="{{ route('admin.siswa.index') }}" class="hover:text-primary cursor-pointer">Siswa</a>
            <span class="mx-2 text-outline-variant">/</span>
            <span class="text-primary">Edit Siswa</span>
        </nav>
        <h1 class="text-4xl font-extrabold text-on-surface tracking-tight mb-2">Edit Data Siswa</h1>
        <p class="text-on-surface-variant max-w-2xl">Perbarui informasi siswa <strong>{{ $siswa->nama }}</strong>.</p>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-8">
            <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">badge</span>
                            NIS (Nomor Induk Siswa)
                        </span>
                    </label>
                    <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" 
                        class="w-full px-4 py-3 bg-surface-container-low border border-surface-variant rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-transparent text-on-surface placeholder:text-outline/60"
                        placeholder="Contoh: 12345" required />
                    @error('nis')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">person</span>
                            Nama Lengkap
                        </span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" 
                        class="w-full px-4 py-3 bg-surface-container-low border border-surface-variant rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-transparent text-on-surface placeholder:text-outline/60"
                        placeholder="Contoh: Budi Santoso" required />
                    @error('nama')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">school</span>
                            Kelas
                        </span>
                    </label>
                    <select name="kelas" class="w-full px-4 py-3 bg-surface-container-low border border-surface-variant rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-transparent text-on-surface cursor-pointer" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="X" {{ old('kelas', $siswa->kelas) == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ old('kelas', $siswa->kelas) == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ old('kelas', $siswa->kelas) == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                        <option value="XIII" {{ old('kelas', $siswa->kelas) == 'XIII' ? 'selected' : '' }}>Kelas XIII</option>
                    </select>
                    @error('kelas')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">trending_up</span>
                            Jurusan (Opsional)
                        </span>
                    </label>
                    <select name="jurusan_id" class="w-full px-4 py-3 bg-surface-container-low border border-surface-variant rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-transparent text-on-surface cursor-pointer">
                        <option value="">-- Tidak Ada Jurusan --</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $siswa->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }} ({{ $jurusan->deskripsi }})
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">lock</span>
                            Password Baru (Kosongkan jika tidak ingin mengubah)
                        </span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" 
                            class="w-full px-4 py-3 pr-12 bg-surface-container-low border border-surface-variant rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-transparent text-on-surface placeholder:text-outline/60"
                            placeholder="Minimal 6 karakter" />
                        <button type="button" onclick="togglePassword('password')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-lg" id="password-icon" style="font-variation-settings: 'FILL' 0;">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-bold text-on-surface mb-2">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">lock</span>
                            Konfirmasi Password Baru
                        </span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                            class="w-full px-4 py-3 pr-12 bg-surface-container-low border border-surface-variant rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-transparent text-on-surface placeholder:text-outline/60"
                            placeholder="Ulang password" />
                        <button type="button" onclick="togglePassword('password_confirmation')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-lg" id="password_confirmation-icon" style="font-variation-settings: 'FILL' 0;">visibility</span>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="signature-gradient text-white font-semibold px-8 py-3 rounded-lg text-sm shadow-md hover:scale-[0.98] transition-transform flex items-center gap-2 flex-1">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.siswa.index') }}" class="bg-surface-container-high text-on-surface font-semibold px-8 py-3 rounded-lg text-sm hover:bg-surface-container-highest transition-colors flex items-center gap-2 flex-1 justify-center">
                        <span class="material-symbols-outlined text-lg">close</span>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

@include('layouts.footer')
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari Sistem?',
            text: 'Sesi anda sebagai administrator akan diakhiri.',
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

    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.style.fontVariationSettings = "'FILL' 1";
        } else {
            field.type = 'password';
            icon.style.fontVariationSettings = "'FILL' 0";
        }
    }
</script>
</body>
</html>
