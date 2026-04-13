<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>404 Not Found | APSS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .signature-gradient { background: linear-gradient(135deg, #0058be 0%, #2170e4 100%); }
    </style>
</head>
<body class="bg-[#f6f9ff] font-['Inter'] text-[#151c23] min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center space-y-8">
        <div class="relative w-48 h-48 mx-auto">
            <div class="absolute inset-0 bg-[#d8e2ff] rounded-full blur-2xl opacity-50"></div>
            <div class="relative w-full h-full flex items-center justify-center bg-white rounded-full shadow-lg">
                <span class="material-symbols-outlined text-8xl text-[#0058be]" style="font-variation-settings: 'FILL' 1;">error</span>
            </div>
        </div>
        
        <div class="space-y-3">
            <h1 class="font-['Manrope'] text-5xl font-extrabold text-[#001a42]">404</h1>
            <h2 class="font-['Manrope'] text-2xl font-bold tracking-tight">Halaman Tidak Ditemukan</h2>
            <p class="text-[#424754] font-medium leading-relaxed">
                Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.
            </p>
        </div>

        <div class="pt-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 signature-gradient text-white px-8 py-3.5 rounded-lg font-bold shadow-lg shadow-blue-500/20 hover:scale-[0.98] transition-all">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
