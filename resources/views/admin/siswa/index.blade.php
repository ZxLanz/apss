<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Manajemen Siswa | APSS</title>
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
<header class="bg-[#f6f9ff] dark:bg-slate-950 sticky top-0 z-50 shadow-sm">
    <nav class="flex justify-between items-center px-8 py-4 w-full max-w-screen-2xl mx-auto">
        <div class="flex items-center gap-8">
            <span class="text-2xl font-bold tracking-tight text-[#0058be] dark:text-blue-400">APSS</span>
            <div class="hidden md:flex items-center gap-6">
                <a class="text-[#424754] dark:text-slate-400 font-medium hover:text-[#0058be] dark:hover:text-blue-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="text-[#0058be] dark:text-blue-400 font-bold border-b-2 border-[#0058be] pb-1" href="{{ route('admin.siswa.index') }}">Siswa</a>
                <a class="text-[#424754] dark:text-slate-400 font-medium hover:text-[#0058be] dark:hover:text-blue-300 transition-colors" href="{{ route('admin.kategori.index') }}">Kategori</a>
                <a class="text-[#424754] dark:text-slate-400 font-medium hover:text-[#0058be] dark:hover:text-blue-300 transition-colors" href="{{ route('admin.laporan.index') }}">Laporan & Aspirasi</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.akun') }}" class="flex items-center gap-3 pr-4 border-r border-surface-variant group">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary transition-colors group-hover:text-white overflow-hidden ring-1 ring-black/5">
                    @if(Auth::guard('admin')->user()->foto)
                        <img src="{{ asset('storage/' . Auth::guard('admin')->user()->foto) }}" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined">shield_person</span>
                    @endif
                </div>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" id="form-logout">
                @csrf
                <button type="button" onclick="confirmLogout()" class="text-slate-500 hover:text-error flex items-center gap-1 text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </nav>
</header>

<main class="max-w-screen-2xl mx-auto px-8 py-8">
    @if(session('success'))
    <div class="fixed top-6 right-6 z-[60] flex items-center gap-3 bg-surface-container-lowest border-l-4 border-primary px-6 py-4 rounded-xl shadow-lg ring-1 ring-black/5" id="toast-success">
        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <div>
            <p class="text-sm font-semibold text-on-surface">Berhasil</p>
            <p class="text-xs text-on-surface-variant">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="mb-10">
        <nav class="flex text-sm font-medium text-on-surface-variant mb-2">
            <span class="hover:text-primary cursor-pointer">Admin</span>
            <span class="mx-2 text-outline-variant">/</span>
            <span class="text-primary">Siswa</span>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-extrabold text-on-surface tracking-tight mb-2">Manajemen Siswa</h1>
                <p class="text-on-surface-variant max-w-2xl">Kelola data siswa yang terdaftar di aplikasi APSS.</p>
            </div>
            <div class="flex items-center gap-3 flex-wrap justify-end">
                <button onclick="openImportModal()" class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg text-sm shadow-md hover:bg-blue-700 transition-all flex items-center gap-2 w-fit">
                    <span class="material-symbols-outlined text-lg">upload_file</span>
                    Import Excel/CSV
                </button>
                <a href="{{ route('admin.siswa.create') }}" class="signature-gradient text-white font-semibold px-6 py-3 rounded-lg text-sm shadow-md hover:scale-[0.98] transition-transform flex items-center gap-2 w-fit">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                    Tambah Siswa
                </a>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl p-6 mb-8 flex flex-wrap items-center gap-4">
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex gap-4 w-full flex-wrap">
            <div class="flex flex-col gap-1.5 flex-1 min-w-[200px]">
                <label class="text-xs font-bold uppercase tracking-wider text-outline">Pencarian</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-3 flex items-center text-outline group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-sm">search</span>
                    </span>
                    <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/40 text-on-surface placeholder:text-outline/60" placeholder="Cari nama atau NIS siswa..." type="text"/>
                </div>
            </div>
            <div class="pt-5 flex gap-2">
                <button type="submit" class="signature-gradient text-white font-semibold px-6 py-2.5 rounded-lg text-sm shadow-md hover:scale-[0.98] transition-transform flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">filter_alt</span>
                    Cari
                </button>
                <a href="{{ route('admin.siswa.index') }}" class="bg-surface-container-high text-on-surface font-semibold px-6 py-2.5 rounded-lg text-sm hover:bg-surface-container-highest transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">restart_alt</span>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">No</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">NIS</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Nama Siswa</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Kelas</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Jurusan</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Terdaftar</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-outline">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-low">
                    @if($siswa->isEmpty())
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-on-surface-variant font-medium text-sm">Belum ada data siswa.</td>
                    </tr>
                    @else
                    @foreach($siswa as $item)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-6 py-5 text-sm font-semibold text-on-surface-variant">{{ str_pad($siswa->firstItem() + $loop->index, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-5 text-sm font-bold text-primary">{{ $item->nis }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm uppercase">{{ substr($item->nama, 0, 2) }}</div>
                                <p class="text-sm font-semibold text-on-surface">{{ $item->nama }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="bg-surface-container text-secondary text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded-full">{{ $item->kelas }}</span>
                        </td>
                        <td class="px-6 py-5">
                            @if($item->jurusan)
                                <span class="bg-blue-100 text-blue-700 text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded-full">{{ $item->jurusan->nama_jurusan }}</span>
                            @else
                                <span class="text-xs text-outline italic">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-sm text-on-surface-variant">
                            {{ $item->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.siswa.edit', $item->id) }}" class="text-primary font-bold text-sm flex items-center gap-1.5 hover:underline transition-all">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                    Edit
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" class="inline-block" id="delete-form-{{ $item->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')" class="text-error font-bold text-sm flex items-center gap-1.5 hover:underline transition-all">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if($siswa->hasPages())
        <div class="px-6 py-6 border-t border-surface-container-low flex flex-col md:flex-row justify-between items-center gap-4">
            {{ $siswa->links('pagination::tailwind') }}
        </div>
        @endif
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

    function confirmDelete(id, namaSiswa) {
        Swal.fire({
            title: 'Hapus Siswa?',
            text: `Anda akan menghapus data ${namaSiswa}. Laporan terkait juga akan dihapus! Tindakan ini tidak dapat dibatalkan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ba1a1a',
            cancelButtonColor: '#727785',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
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

    function openImportModal() {
        Swal.fire({
            title: 'Import Data Siswa',
            html: `
                <div class="text-left space-y-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.siswa.downloadTemplate') }}" class="flex-1 bg-green-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-green-700 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">download</span>
                            Download Template
                        </a>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih File Excel:</label>
                        <input type="file" id="importFile" accept=".xlsx,.xls,.csv" class="w-full border border-gray-300 rounded-lg p-2 text-sm">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Import',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0058be',
            didOpen: () => {
                const fileInput = document.getElementById('importFile');
                if (fileInput) {
                    fileInput.focus();
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const fileInput = document.getElementById('importFile');
                const file = fileInput.files[0];
                
                if (!file) {
                    Swal.fire('Error', 'Silakan pilih file terlebih dahulu', 'error');
                    return;
                }
                
                const formData = new FormData();
                formData.append('file', file);
                
                Swal.fire({
                    title: 'Mengimport...',
                    html: 'Sedang memproses file, mohon tunggu...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                fetch('{{ route("admin.siswa.import") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Gagal mengimport file: ' + error.message, 'error');
                });
            }
        });
    }
</script>
</body>
</html>
