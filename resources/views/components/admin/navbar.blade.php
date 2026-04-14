@props(['active' => ''])

<nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl flex justify-between items-center px-8 py-4 w-full max-w-full mx-auto docked full-width top-0 sticky z-50 shadow-sm">
    <div class="flex items-center gap-8">
        <div class="text-2xl font-bold tracking-tight text-blue-700 dark:text-blue-400 flex items-center gap-2">
            <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">account_balance</span>
            <span>APSS</span>
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a class="{{ $active == 'dashboard' ? 'text-blue-700 dark:text-blue-400 font-bold border-b-2 border-blue-600' : 'text-slate-500 hover:text-blue-600' }} px-1 py-1 text-sm tracking-tight transition-all duration-200" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="{{ $active == 'siswa' ? 'text-blue-700 dark:text-blue-400 font-bold border-b-2 border-blue-600' : 'text-slate-500 hover:text-blue-600' }} px-1 py-1 text-sm tracking-tight transition-colors" href="{{ route('admin.siswa.index') }}">Siswa</a>
            <a class="{{ $active == 'kategori' ? 'text-blue-700 dark:text-blue-400 font-bold border-b-2 border-blue-600' : 'text-slate-500 hover:text-blue-600' }} px-1 py-1 text-sm tracking-tight transition-colors" href="{{ route('admin.kategori.index') }}">Kategori</a>
            <a class="{{ $active == 'laporan' ? 'text-blue-700 dark:text-blue-400 font-bold border-b-2 border-blue-600' : 'text-slate-500 hover:text-blue-600' }} px-1 py-1 text-sm tracking-tight transition-colors" href="{{ route('admin.laporan.index') }}">Laporan & Aspirasi</a>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.akun') }}" class="flex items-center gap-3 pr-4 border-r border-surface-variant group">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary transition-colors group-hover:text-white overflow-hidden border border-white shadow-sm ring-1 ring-black/5">
                @if(Auth::guard('admin')->user()->foto)
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->foto) }}" class="w-full h-full object-cover">
                @else
                    <span class="material-symbols-outlined">shield_person</span>
                @endif
            </div>
            <div class="hidden lg:block">
                <p class="text-sm font-bold text-on-surface leading-none">{{ Auth::guard('admin')->user()->nama }}</p>
                <p class="text-xs text-on-surface-variant mt-1 font-medium">Akun Saya</p>
            </div>
        </a>
        <form action="{{ route('admin.logout') }}" method="POST" id="form-logout-component">
            @csrf
            <button type="button" onclick="confirmLogoutComponent()" class="text-slate-500 hover:text-error flex items-center gap-1 text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-lg">logout</span>
                Logout
            </button>
        </form>
        <script>
            function confirmLogoutComponent() {
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
                        document.getElementById('form-logout-component').submit();
                    }
                })
            }
        </script>
    </div>
</nav>
