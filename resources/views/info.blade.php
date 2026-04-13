<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $title }} | APSS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-[#f6f9ff] min-h-screen flex flex-col items-center justify-center font-['Inter'] relative p-6">
    <div class="absolute inset-0 max-w-full overflow-hidden flex justify-center -z-10 bg-white">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-[#f6f9ff] blur-[120px] opacity-60"></div>
    </div>
    <div class="max-w-xl w-full mx-auto px-6 py-12 text-center bg-white/70 backdrop-blur-xl border border-slate-100 rounded-3xl shadow-xl shadow-slate-200/40 border-t-white/80">
        <div class="w-20 h-20 bg-blue-50 border-4 border-white flex items-center justify-center rounded-2xl mx-auto mb-6 text-blue-600 shadow-md">
            <span class="material-symbols-outlined text-4xl">{{ $icon }}</span>
        </div>
        <h1 class="text-4xl font-extrabold font-['Manrope'] text-slate-800 mb-2 tracking-tight">{{ $title }}</h1>
        <div class="w-16 h-1.5 bg-blue-600 rounded-full mx-auto mb-8"></div>
        
        <div class="text-slate-600 font-medium mb-10 leading-relaxed text-left space-y-6">
            {!! $content ?? '<p>Konten tidak tersedia.</p>' !!}
        </div>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-bold px-8 py-4 rounded-xl hover:scale-[1.02] hover:shadow-blue-500/30 transition-all duration-300 shadow-lg shadow-blue-500/20 active:scale-95">
            <span class="material-symbols-outlined">home</span>
            Kembali ke Beranda
        </a>
    </div>
    @include('layouts.footer')
</body>
</html>
