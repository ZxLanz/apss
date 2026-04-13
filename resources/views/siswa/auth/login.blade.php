<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<title>Login | APSS - Aplikasi Pengaduan Sarana Sekolah</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "tertiary-fixed-dim": "#ffb786",
                      "surface-container-lowest": "#ffffff",
                      "background": "#f6f9ff",
                      "on-error": "#ffffff",
                      "on-primary": "#ffffff",
                      "on-background": "#151c23",
                      "tertiary-container": "#b75b00",
                      "on-primary-container": "#fefcff",
                      "on-surface-variant": "#424754",
                      "inverse-surface": "#2a3138",
                      "primary-fixed": "#d8e2ff",
                      "surface-container-low": "#edf4fd",
                      "primary-fixed-dim": "#adc6ff",
                      "on-secondary-fixed-variant": "#304671",
                      "surface-dim": "#d4dbe3",
                      "inverse-primary": "#adc6ff",
                      "surface": "#f6f9ff",
                      "on-primary-fixed-variant": "#004395",
                      "tertiary-fixed": "#ffdcc6",
                      "outline": "#727785",
                      "surface-container-highest": "#dce3ec",
                      "on-tertiary-fixed": "#311400",
                      "surface-container-high": "#e2e9f2",
                      "on-tertiary-fixed-variant": "#723600",
                      "surface-container": "#e7eff7",
                      "on-secondary": "#ffffff",
                      "secondary-container": "#b6ccff",
                      "tertiary": "#924700",
                      "primary-container": "#2170e4",
                      "inverse-on-surface": "#eaf1fa",
                      "secondary-fixed": "#d8e2ff",
                      "on-primary-fixed": "#001a42",
                      "on-secondary-fixed": "#001a42",
                      "surface-variant": "#dce3ec",
                      "primary": "#0058be",
                      "outline-variant": "#c2c6d6",
                      "on-secondary-container": "#405682",
                      "on-tertiary": "#ffffff",
                      "secondary-fixed-dim": "#b1c6f9",
                      "secondary": "#495e8a",
                      "on-surface": "#151c23",
                      "surface-tint": "#005ac2",
                      "error": "#ba1a1a",
                      "surface-bright": "#f6f9ff",
                      "on-tertiary-container": "#fffbff",
                      "error-container": "#ffdad6",
                      "on-error-container": "#93000a"
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
<body class="bg-background font-body text-on-background min-h-screen flex flex-col">

@if($errors->any())
<div class="fixed top-6 right-6 z-50 animate-in fade-in slide-in-from-top-4 duration-300" id="toast-notif">
    <div class="bg-surface-container-lowest border-l-4 border-error px-6 py-4 rounded-lg shadow-xl flex items-center gap-4 max-w-md">
        <div class="bg-error-container p-2 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-error text-xl">error</span>
        </div>
        <div>
            <p class="font-headline font-bold text-on-surface text-sm">Gagal Login</p>
            <p class="text-on-surface-variant text-xs mt-0.5">{{ $errors->first() }}</p>
        </div>
        <button class="ml-auto text-outline hover:text-on-surface-variant transition-colors" onclick="document.getElementById('toast-notif').remove()">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    </div>
</div>
@endif

<main class="flex-grow flex items-center justify-center px-4 py-12 relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden -z-10">
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-fixed-dim/20 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 -right-24 w-64 h-64 bg-tertiary-fixed/10 rounded-full blur-3xl"></div>
</div>
<div class="w-full max-w-[440px] bg-surface-container-lowest rounded-xl shadow-[0px_24px_48px_-12px_rgba(21,28,35,0.06)] overflow-hidden transition-all duration-300">
    <div class="px-8 pt-12 pb-10">
        <div class="flex flex-col items-center mb-10">
            <div class="w-16 h-16 bg-primary-container/10 flex items-center justify-center rounded-2xl mb-6 group transition-transform hover:scale-105 duration-300">
                <span class="material-symbols-outlined text-4xl text-primary" data-weight="fill" style="font-variation-settings: 'FILL' 1;">school</span>
            </div>
            <a href="{{ url('/') }}" class="font-headline text-3xl font-extrabold tracking-tight text-primary text-center hover:text-blue-800 transition-colors block">APSS</a>
            <p class="text-on-surface-variant font-medium mt-2 text-center text-sm leading-relaxed">Aplikasi Pengaduan Sarana Sekolah</p>
        </div>
        
        <form class="space-y-6" action="{{ route('siswa.login') }}" method="POST">
            @csrf
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-outline ml-1" for="nis">NIS (Nomor Induk Siswa)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <input required value="{{ old('nis') }}" class="w-full pl-12 pr-4 py-4 bg-surface-container-highest/50 border-none rounded-xl text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/40 focus:bg-surface-container-lowest transition-all outline-none text-base" id="nis" name="nis" placeholder="Masukkan nomor induk Anda" type="text"/>
                </div>
            </div>

            <!-- Tambahan Password berdasarkan fitur keamanan baru -->
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-wider text-outline ml-1" for="password">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <input required class="w-full pl-12 pr-12 py-4 bg-surface-container-highest/50 border-none rounded-xl text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/40 focus:bg-surface-container-lowest transition-all outline-none text-base" id="password" name="password" placeholder="Masukkan password Anda" type="password"/>
                    <button type="button" onclick="togglePasswordLogin('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl" id="password-icon" style="font-variation-settings: 'FILL' 0;">visibility</span>
                    </button>
                </div>
            </div>

            <button class="signature-gradient w-full py-4 rounded-xl text-on-primary font-headline font-bold text-base shadow-lg shadow-primary-container/20 hover:scale-[0.98] active:scale-95 transition-all duration-200" type="submit">
                Login
            </button>
        </form>
        <div class="mt-10 text-center">
            <div class="inline-flex items-center gap-2 bg-surface-container-low px-4 py-2 rounded-full">
                <span class="material-symbols-outlined text-primary text-sm">info</span>
                <span class="text-sm font-medium text-on-surface-variant">Siswa login menggunakan akun resmi yang disediakan sekolah.</span>
            </div>
        </div>
    </div>
    <div class="h-1.5 w-full signature-gradient opacity-60"></div>
</div>
</main>
@include('layouts.footer')
<script>
    function togglePasswordLogin(fieldId) {
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
</body></html>
</body></html>