<!-- Floating Bottom Navigation for Mobile -->
<div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-md bg-white/80 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.1)] rounded-2xl md:hidden z-[100] flex justify-around items-center py-4 px-6 scale-100 active:scale-95 transition-transform animate-in fade-in slide-in-from-bottom-10 duration-500">
    @auth('siswa')
        <a href="{{ route('siswa.dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600' : 'text-slate-400' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('siswa.dashboard') ? 'fill' : '' }}">dashboard</span>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="{{ route('siswa.laporan.create') }}" class="flex flex-col items-center justify-center w-14 h-14 bg-blue-600 text-white rounded-full -translate-y-8 shadow-lg shadow-blue-500/40 border-4 border-[#EFF6FF]">
            <span class="material-symbols-outlined text-3xl">add</span>
        </a>
        <a href="{{ route('siswa.akun.edit') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('siswa.akun.*') ? 'text-blue-600' : 'text-slate-400' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('siswa.akun.*') ? 'fill' : '' }}">person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    @endauth

    @auth('admin')
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-slate-400' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'fill' : '' }}">dashboard</span>
            <span class="text-[10px] font-bold">Dasbor</span>
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('admin.laporan.*') ? 'text-blue-600' : 'text-slate-400' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('admin.laporan.*') ? 'fill' : '' }}">assignment_turned_in</span>
            <span class="text-[10px] font-bold">Laporan</span>
        </a>
        <a href="{{ route('admin.akun') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('admin.akun') ? 'text-blue-600' : 'text-slate-400' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('admin.akun') ? 'fill' : '' }}">admin_panel_settings</span>
            <span class="text-[10px] font-bold">Admin</span>
        </a>
    @endauth
    
    @if(!Auth::guard('siswa')->check() && !Auth::guard('admin')->check())
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 {{ Request::is('/') ? 'text-blue-600' : 'text-slate-400' }}">
            <span class="material-symbols-outlined {{ Request::is('/') ? 'fill' : '' }}">home</span>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="{{ route('siswa.login') }}" class="flex flex-col items-center gap-1 text-slate-400">
            <span class="material-symbols-outlined">login</span>
            <span class="text-[10px] font-bold">Masuk Siswa</span>
        </a>
    @endif
</div>

<footer class="w-full py-16 px-8 flex flex-col md:flex-row justify-between items-center gap-8 bg-slate-50 border-t border-slate-200/50 mt-12 mb-24 md:mb-0">
    <div class="flex items-center gap-2">
        <div class="text-lg font-black text-blue-800 font-headline">APSS</div>
        <span class="text-xs font-medium text-slate-500 hidden md:inline">|</span>
        <p class="text-sm font-medium text-slate-500 font-body">© 2026 APSS - Aplikasi Pengaduan Sarana Sekolah.</p>
    </div>
    <nav class="flex items-center gap-6 text-sm font-medium">
        <a class="text-slate-500 hover:text-primary transition-colors opacity-80 hover:opacity-100" href="{{ route('info.bantuan') }}">Bantuan</a>
        <a class="text-slate-500 hover:text-primary transition-colors opacity-80 hover:opacity-100" href="{{ route('info.privasi') }}">Kebijakan Privasi</a>
        <a class="text-slate-500 hover:text-primary transition-colors opacity-80 hover:opacity-100" href="mailto:dzilanbaru@gmail.com">Kontak Admin</a>
    </nav>
</footer>

@auth('admin')
<form id="auto-logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
    @csrf
</form>

<script>
    let idleTime = 0;
    // Auto logout setelah 15 menit tidak ada aktivitas
    const idleLimit = 15; 

    function resetTimer() {
        idleTime = 0;
    }

    // Reset timer jika ada pergerakan atau input
    window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer;
    window.ontouchstart = resetTimer;
    window.onclick = resetTimer;
    window.onkeydown = resetTimer;

    setInterval(function() {
        idleTime++;
        if (idleTime >= idleLimit) {
            // Notifikasi sebelum logout (opsional)
            console.log("Inactivity detected. Logging out...");
            document.getElementById('auto-logout-form').submit();
        }
    }, 60000); // Cek setiap 1 menit
</script>
@endauth
