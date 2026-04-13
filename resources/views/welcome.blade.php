<!DOCTYPE html>
<html class="scroll-smooth" lang="id">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>APSS Aplikasi Pengaduan Sarana Sekolah</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #EFF6FF;
        }

        h1,
        h2,
        h3,
        .font-headline {
            font-family: 'Manrope', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .feature-card:hover .icon-box {
            transform: scale(1.1) rotate(5deg);
        }

        .step-circle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 100%;
            height: 2px;
            background: #D1D5DB;
            z-index: -1;
        }

        @media (max-width: 768px) {
            .step-circle::after {
                display: none;
            }
        }
    </style>
</head>

<body class="text-slate-900 overflow-x-hidden">

    <!-- Fixed Navbar -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-blue-100/50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-extrabold text-blue-600 tracking-tighter">APSS</span>
            </div>

            <div class="hidden md:flex items-center gap-10 absolute left-1/2 -translate-x-1/2">
                <a href="#"
                    class="text-[15px] font-bold text-slate-500 hover:text-blue-600 transition-colors tracking-wide">Beranda</a>
                <a href="#fitur"
                    class="text-[15px] font-bold text-slate-500 hover:text-blue-600 transition-colors tracking-wide">Fitur</a>
                <a href="#cara-kerja"
                    class="text-[15px] font-bold text-slate-500 hover:text-blue-600 transition-colors tracking-wide">Cara
                    Kerja</a>
            </div>

            <div class="flex items-center gap-3">
                @auth('siswa')
                    <a href="{{ route('siswa.dashboard') }}"
                        class="hidden sm:inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('siswa.login') }}"
                        class="hidden sm:inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">login</span>
                        Masuk Siswa
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-600 border border-slate-200 active:scale-95 transition-all">
                    <span class="material-symbols-outlined" id="menuIcon">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobileMenu" class="fixed inset-0 bg-white z-[60] translate-x-full transition-transform duration-300 md:hidden p-8 flex flex-col">
            <div class="flex justify-between items-center mb-12">
                <span class="text-2xl font-extrabold text-blue-600 tracking-tighter">APSS</span>
                <button onclick="toggleMobileMenu()" class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-600 border border-slate-200">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="flex flex-col gap-6">
                <a href="#" onclick="toggleMobileMenu()" class="text-2xl font-bold text-slate-800 hover:text-blue-600 transition-colors">Beranda</a>
                <a href="#fitur" onclick="toggleMobileMenu()" class="text-2xl font-bold text-slate-800 hover:text-blue-600 transition-colors">Fitur</a>
                <a href="#cara-kerja" onclick="toggleMobileMenu()" class="text-2xl font-bold text-slate-800 hover:text-blue-600 transition-colors">Cara Kerja</a>
                
                <hr class="border-slate-100 my-4">
                
                @auth('siswa')
                    <a href="{{ route('siswa.dashboard') }}" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-center shadow-lg shadow-blue-500/20">Buka Dashboard</a>
                @else
                    <a href="{{ route('siswa.login') }}" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-center shadow-lg shadow-blue-500/20">Masuk Siswa</a>
                    <a href="{{ route('admin.login') }}" class="text-center text-sm font-bold text-slate-400 mt-4">Login Admin</a>
                @endauth
            </div>
            
            <div class="mt-auto">
                <p class="text-xs text-slate-400 font-medium text-center">© 2026 Academic Sentinel Complaint System</p>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 px-6">
        <div class="max-w-5xl mx-auto text-center space-y-8">
            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Laporkan Kerusakan <br class="hidden md:block" />
                Sarana Sekolah dengan <span class="text-blue-600">Mudah</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Platform pengaduan sarana dan prasarana sekolah yang cepat, transparan, dan terorganisir untuk <span
                    class="font-bold text-slate-700">SMK Negeri 1 Padaherang</span>.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                <a href="{{ route('siswa.login') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 group">
                    Mulai Laporan
                    <span
                        class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
                <button onclick="showToast('Fitur ini akan segera tersedia!')"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-slate-600 border border-slate-200 px-8 py-4 rounded-xl font-bold text-lg hover:bg-slate-50 transition-all active:scale-95">
                    Pelajari Lebih Lanjut
                    <span class="material-symbols-outlined">expand_more</span>
                </button>
            </div>

            <!-- Illustration Mockup Removed as requested -->
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-24 px-6 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                    Mengapa <span class="relative inline-block">Menggunakan<span
                            class="absolute -bottom-2 left-0 w-full h-1 bg-blue-500 rounded-full"></span></span> APSS?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="feature-card group bg-blue-50/30 p-8 rounded-[24px] border border-transparent hover:border-blue-100 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div
                        class="icon-box w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm mb-6 transition-transform">
                        <span class="material-symbols-outlined text-3xl">assignment</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Mudah Digunakan</h3>
                    <p class="text-slate-500 leading-relaxed">Laporkan masalah sarana hanya dengan beberapa langkah
                        mudah melalui ponsel atau komputer kamu.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="feature-card group bg-blue-50/30 p-8 rounded-[24px] border border-transparent hover:border-blue-100 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div
                        class="icon-box w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm mb-6 transition-transform">
                        <span class="material-symbols-outlined text-3xl">query_stats</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Pantau Status Real-time</h3>
                    <p class="text-slate-500 leading-relaxed">Lihat perkembangan laporan kamu kapan saja dan di mana
                        saja. Transparansi total untuk semua siswa.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="feature-card group bg-blue-50/30 p-8 rounded-[24px] border border-transparent hover:border-blue-100 hover:bg-white hover:shadow-xl transition-all duration-300">
                    <div
                        class="icon-box w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm mb-6 transition-transform">
                        <span class="material-symbols-outlined text-3xl">verified_user</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Terorganisir & Aman</h3>
                    <p class="text-slate-500 leading-relaxed">Setiap laporan tercatat rapi dan ditangani langsung oleh
                        tim sarana prasarana sekolah secara profesional.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="cara-kerja" class="py-24 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Cara Kerja APSS</h2>
            <p class="text-slate-500 mb-16">Alur pengaduan yang ringkas untuk kenyamanan bersama.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
                <!-- Step 1 -->
                <div class="relative flex flex-col items-center">
                    <div
                        class="step-circle w-20 h-20 bg-white rounded-full flex items-center justify-center border-4 border-blue-600 shadow-xl relative z-index-10 mb-6">
                        <span class="material-symbols-outlined text-blue-600 text-3xl">person</span>
                        <span
                            class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm ring-4 ring-[#EFF6FF]">1</span>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Login dengan NIS</h4>
                    <p class="text-sm text-slate-500 max-w-xs">Masuk menggunakan Nomor Induk Siswa kamu yang terdaftar
                        di sekolah.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center">
                    <div
                        class="step-circle w-20 h-20 bg-white rounded-full flex items-center justify-center border-4 border-blue-600 shadow-xl relative z-index-10 mb-6">
                        <span class="material-symbols-outlined text-blue-600 text-3xl">description</span>
                        <span
                            class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm ring-4 ring-[#EFF6FF]">2</span>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Buat Laporan</h4>
                    <p class="text-sm text-slate-500 max-w-xs">Pilih kategori kerusakan, tentukan lokasi, dan lampirkan
                        foto serta keterangan singkat.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center">
                    <div
                        class="w-20 h-20 bg-white rounded-full flex items-center justify-center border-4 border-blue-600 shadow-xl relative z-index-10 mb-6">
                        <span class="material-symbols-outlined text-blue-600 text-3xl">notifications_active</span>
                        <span
                            class="absolute -top-2 -right-2 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm ring-4 ring-[#EFF6FF]">3</span>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">Pantau & Feedback</h4>
                    <p class="text-sm text-slate-500 max-w-xs">Cek status pengerjaan secara berkala dan berikan ulasan
                        setelah sarana diperbaiki.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div
                class="bg-blue-600 rounded-[32px] p-10 md:p-16 text-center text-white shadow-2xl shadow-blue-500/40 relative overflow-hidden">
                <!-- Decorative background -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                    <div
                        class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl">
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full translate-x-1/2 translate-y-1/2 blur-3xl">
                    </div>
                </div>

                <h2 class="text-3xl md:text-5xl font-extrabold mb-6 relative">Mulai Laporkan Hari Ini</h2>
                <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto relative">
                    Bersama-sama kita jaga kualitas sarana pendidikan di SMK Negeri 1 Padaherang untuk masa depan yang
                    lebih baik.
                </p>
                <a href="{{ route('siswa.login') }}"
                    class="inline-flex items-center gap-2 bg-white text-blue-600 px-10 py-5 rounded-2xl font-bold text-xl hover:scale-105 transition-transform active:scale-95 shadow-xl">
                    Buka Aplikasi
                </a>
            </div>
        </div>
    </section>

@include('layouts.footer')

    <!-- Toast Component -->
    <div id="toast"
        class="fixed top-24 right-6 z-[100] opacity-0 translate-y-4 scale-95 transition-all duration-300 pointer-events-none">
        <div
            class="bg-slate-900/95 backdrop-blur-md text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 border border-white/10">
            <span class="material-symbols-outlined text-blue-400">info</span>
            <span id="toast-message" class="text-[14px] font-bold tracking-tight"></span>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const isHidden = menu.classList.contains('translate-x-full');
            
            if (isHidden) {
                menu.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
            } else {
                menu.classList.add('translate-x-full');
                document.body.style.overflow = '';
            }
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toast-message');
            toastMsg.innerText = message;
            toast.classList.remove('opacity-0', 'translate-y-4', 'scale-95');

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-4', 'scale-95');
            }, 3000);
        }
    </script>
</body>

</html>