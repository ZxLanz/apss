<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Kelola Kategori | APSS Admin</title>
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
    </style>
</head>
<body class="bg-surface font-body text-on-surface min-h-screen flex flex-col">
<header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
    <nav class="flex justify-between items-center px-8 h-16 w-full max-w-screen-2xl mx-auto">
        <div class="flex items-center gap-8">
            <div class="text-2xl font-black tracking-tight text-blue-800 font-headline">APSS</div>
            <div class="hidden md:flex gap-6 items-center">
                <a class="text-slate-500 font-medium hover:text-primary transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="text-slate-500 font-medium hover:text-primary transition-colors" href="{{ route('admin.siswa.index') }}">Siswa</a>
                <a class="text-primary font-bold border-b-2 border-primary pb-1" href="{{ route('admin.kategori.index') }}">Kategori</a>
                <a class="text-slate-500 font-medium hover:text-primary transition-colors" href="{{ route('admin.laporan.index') }}">Laporan</a>
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

<main class="max-w-screen-2xl mx-auto px-8 py-8 flex-grow w-full">
    {{-- Breadcrumbs --}}
    <div class="mb-8">
        <nav class="flex text-xs font-bold uppercase tracking-widest text-outline mb-2">
            <span>Admin</span>
            <span class="mx-2 opacity-30">/</span>
            <span class="text-primary">Kelola Kategori</span>
        </nav>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-4xl font-extrabold text-on-surface tracking-tight leading-tight">Master Kategori</h1>
                <p class="text-on-surface-variant font-medium text-sm mt-1">Atur kategori sarana dan prasarana sekolah untuk pengaduan yang lebih terorganisir.</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}" class="signature-gradient text-white flex items-center gap-2 px-6 py-3 rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[0.98] transition-all">
                <span class="material-symbols-outlined">add</span>
                Tambah Kategori
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="fixed top-20 right-8 z-[100] animate-in fade-in slide-in-from-top-4 duration-300" id="toast-success">
        <div class="bg-white border-l-4 border-primary p-4 rounded-xl shadow-2xl flex items-center gap-4">
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>
            <div>
                <p class="font-bold text-on-surface text-sm">Berhasil!</p>
                <p class="text-on-surface-variant text-xs">{{ session('success') }}</p>
            </div>
            <button class="text-outline hover:text-on-surface" onclick="document.getElementById('toast-success').remove()">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    </div>
    @endif

    <div class="bg-surface-container-lowest rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-outline w-20">No</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-outline">Nama Kategori</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-outline">Jumlah Laporan</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-outline text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-variant/10">
                    @forelse ($kategori as $item)
                        <tr class="hover:bg-surface-container/30 transition-colors group">
                            <td class="px-8 py-6 text-sm font-bold text-outline">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-8 py-6">
                                <p class="font-bold text-on-surface tracking-tight">{{ $item->nama_kategori }}</p>
                            </td>
                            <td class="px-8 py-6">
                                    {{ $item->laporan_count }} Laporan
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('admin.kategori.edit', $item->id) }}" class="text-primary hover:bg-primary/10 p-2 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit_square</span>
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="inline" id="form-hapus-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $item->id }}')" class="text-error hover:bg-error/10 p-2 rounded-lg transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-on-surface-variant font-medium">
                                <div class="flex flex-col items-center gap-2 opacity-40">
                                    <span class="material-symbols-outlined text-4xl">inventory_2</span>
                                    <p>Data kategori masih kosong</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kategori->hasPages())
        <div class="px-8 py-6 bg-surface-container-low/30 border-t border-surface-variant/10">
            {{ $kategori->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</main>

<footer class="bg-surface-container-low/50 py-10 px-8 border-t border-surface-variant/10">
    <div class="max-w-screen-2xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <p class="text-lg font-black text-blue-900 mb-1">APSS Admin</p>
            <p class="text-xs text-on-surface-variant font-medium">© 2026 APSS Aplikasi Pengaduan Sarana Sekolah. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari Sistem?',
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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Laporan yang berkaitan dengan kategori ini mungkin akan terpengaruh.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ba1a1a',
            cancelButtonColor: '#727785',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-hapus-' + id).submit();
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

