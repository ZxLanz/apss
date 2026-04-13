<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<title>Login Admin - APSS</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-highest": "#dce3ec",
                        "surface-bright": "#f6f9ff",
                        "surface": "#f6f9ff",
                        "primary-fixed-dim": "#adc6ff",
                        "on-tertiary-fixed": "#311400",
                        "outline": "#727785",
                        "on-tertiary-fixed-variant": "#723600",
                        "inverse-on-surface": "#eaf1fa",
                        "tertiary-container": "#b75b00",
                        "secondary-container": "#b6ccff",
                        "surface-variant": "#dce3ec",
                        "secondary": "#495e8a",
                        "on-surface-variant": "#424754",
                        "secondary-fixed": "#d8e2ff",
                        "primary-fixed": "#d8e2ff",
                        "on-error-container": "#93000a",
                        "on-primary-fixed": "#001a42",
                        "surface-container-high": "#e2e9f2",
                        "surface-container-low": "#edf4fd",
                        "on-secondary-container": "#405682",
                        "on-primary-fixed-variant": "#004395",
                        "background": "#f6f9ff",
                        "on-error": "#ffffff",
                        "on-surface": "#151c23",
                        "error": "#ba1a1a",
                        "surface-dim": "#d4dbe3",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed-variant": "#304671",
                        "error-container": "#ffdad6",
                        "tertiary": "#924700",
                        "tertiary-fixed-dim": "#ffb786",
                        "surface-tint": "#005ac2",
                        "surface-container-lowest": "#ffffff",
                        "primary-container": "#2170e4",
                        "primary": "#0058be",
                        "inverse-surface": "#2a3138",
                        "secondary-fixed-dim": "#b1c6f9",
                        "outline-variant": "#c2c6d6",
                        "surface-container": "#e7eff7",
                        "on-tertiary-container": "#fffbff",
                        "on-secondary-fixed": "#001a42",
                        "on-primary-container": "#fefcff",
                        "on-secondary": "#ffffff",
                        "inverse-primary": "#adc6ff",
                        "tertiary-fixed": "#ffdcc6",
                        "on-background": "#151c23",
                        "on-tertiary": "#ffffff"
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
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .bg-pattern {
            background-color: #f6f9ff;
            background-image: radial-gradient(#0058be 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
        .signature-gradient {
            background: linear-gradient(135deg, #0058be 0%, #2170e4 100%);
        }
    </style>
</head>
<body class="font-body text-on-surface bg-background min-h-screen flex flex-col relative overflow-x-hidden">

@if($errors->any())
<!-- Toast Notification -->
<div class="fixed top-6 right-6 z-50 animate-bounce-in" id="toast-notif">
    <div class="bg-surface-container-lowest shadow-[0_24px_48px_-12px_rgba(21,28,35,0.06)] rounded-lg p-4 flex items-center gap-3 border-l-4 border-error max-w-sm">
        <span class="material-symbols-outlined text-error" data-icon="error">error</span>
        <div class="flex flex-col">
            <span class="text-sm font-semibold text-on-surface">Login Gagal</span>
            <span class="text-xs text-on-surface-variant">{{ $errors->first() }}</span>
        </div>
        <button class="ml-auto text-outline hover:text-on-surface transition-colors" onclick="document.getElementById('toast-notif').remove()">
            <span class="material-symbols-outlined text-lg" data-icon="close">close</span>
        </button>
    </div>
</div>
@endif


<main class="flex-grow flex items-center justify-center px-6 py-12 relative">
    <div class="w-full max-w-md z-10">
        <div class="bg-surface-container-lowest rounded-xl shadow-[0_24px_48px_-12px_rgba(0,88,190,0.08)] overflow-hidden">
            <div class="p-8 md:p-10">
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-primary/5 flex items-center justify-center rounded-2xl transition-transform hover:scale-105 duration-300 border border-primary/10">
                        <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                </div>
                <div class="text-center mb-8">
                    <a href="{{ url('/') }}" class="text-3xl font-extrabold font-headline text-primary tracking-tight mb-1 hover:text-blue-800 transition-colors block">APSS</a>
                    <p class="text-on-surface-variant font-medium text-sm leading-relaxed">Aplikasi Pengaduan Sarana Sekolah</p>
                </div>
                
                <form class="space-y-6" action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-outline ml-1" for="username">Username Akses</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                                <span class="material-symbols-outlined">person</span>
                            </div>
                            <input name="username" value="{{ old('username') }}" required class="w-full pl-12 pr-4 py-4 bg-surface-container-highest/50 border-none rounded-xl text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/40 focus:bg-surface-container-lowest transition-all outline-none text-base" id="username" placeholder="Masukkan username" type="text"/>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-outline ml-1" for="password">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                                <span class="material-symbols-outlined">lock</span>
                            </div>
                            <input name="password" required class="w-full pl-12 pr-12 py-4 bg-surface-container-highest/50 border-none rounded-xl text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/40 focus:bg-surface-container-lowest transition-all outline-none text-base" id="password" placeholder="Masukkan password" type="password"/>
                            <button type="button" onclick="togglePasswordLogin('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-xl" id="password-icon" style="font-variation-settings: 'FILL' 0;">visibility</span>
                            </button>
                        </div>
                    </div>
                    <button class="w-full signature-gradient text-white font-headline font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[0.98] active:scale-[0.95] transition-all flex items-center justify-center gap-2 group mt-8" type="submit">
                        <span>Masuk ke Dashboard</span>
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="mt-10 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-full">
                <span class="material-symbols-outlined text-primary text-sm font-bold">shield</span>
                <span class="text-sm font-medium text-on-surface-variant">Hanya untuk Authorized Administrator.</span>
            </div>
        </div>
    </div>
</main>

<footer class="w-full py-8 px-6 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50 dark:bg-slate-950 border-t border-slate-200/50">
    <div class="flex items-center gap-2">
        <a href="{{ url('/') }}" class="text-lg font-black text-blue-800 dark:text-blue-200 hover:opacity-80 transition-opacity font-headline">APSS</a>
        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 hidden md:inline">|</span>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 font-body">© 2026 APSS - Aplikasi Pengaduan Sarana Sekolah.</p>
    </div>
    <nav class="flex items-center gap-6">
        <a class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-primary transition-colors opacity-80 hover:opacity-100" href="{{ route('info.bantuan') }}">Bantuan</a>
        <a class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-primary transition-colors opacity-80 hover:opacity-100" href="{{ route('info.privasi') }}">Kebijakan Privasi</a>
        <a class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-primary transition-colors opacity-80 hover:opacity-100" href="{{ route('info.kontak') }}">Kontak Admin</a>
    </nav>
</footer>
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
