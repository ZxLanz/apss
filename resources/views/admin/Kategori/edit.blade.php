<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Edit Kategori | APSS Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
                    "surface-container-lowest": "#ffffff"
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
<x-admin.navbar active="kategori" />

<main class="max-w-xl mx-auto px-6 py-12 flex-grow w-full">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.kategori.index') }}" class="text-outline hover:text-primary transition-colors bg-white rounded-full p-2 shadow-sm">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <nav class="flex text-[10px] font-bold uppercase tracking-widest text-outline mb-1">
                <span>Kategori</span>
                <span class="mx-2 opacity-30">/</span>
                <span class="text-primary">Edit Data</span>
            </nav>
            <h1 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Edit Kategori</h1>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8">
        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-2">
                <label class="text-sm font-bold text-on-surface tracking-wide" for="nama_kategori">Nama Kategori</label>
                <input required autofocus 
                    class="w-full bg-surface/50 border-2 border-surface-variant/20 rounded-xl py-3.5 px-4 text-on-surface focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all placeholder:text-outline/50" 
                    id="nama_kategori" name="nama_kategori" 
                    placeholder="Contoh: Sarana Olahraga" type="text" value="{{ old('nama_kategori', $kategori->nama_kategori) }}"/>
                @error('nama_kategori')
                    <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button class="w-full signature-gradient text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 flex items-center justify-center gap-3 transition-all active:scale-[0.98]" type="submit">
                    Simpan Perubahan
                    <span class="material-symbols-outlined">save</span>
                </button>
            </div>
        </form>
    </div>
</main>
@include('layouts.footer')
</body></html>
