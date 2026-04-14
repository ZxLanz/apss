<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\AuthController;
use App\Http\Controllers\Siswa\AkunController;
use App\Http\Controllers\Siswa\DashboardController;
use App\Http\Controllers\Siswa\LaporanPengaduanController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AkunController as AdminAkunController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanAspirasiController;
use App\Http\Controllers\Admin\SiswaController;

Route::get('/bantuan', function () {
    $content = '
        <div class="space-y-6 text-sm">
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">how_to_reg</span>
                    Cara Melapor
                </h3>
                <p>Klik tombol <strong>"Buat Laporan"</strong> di dashboard Anda. Masukkan lokasi yang akurat dan jelaskan kerusakan sarana dengan detail serta lampirkan foto pendukung.</p>
            </div>
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">pending_actions</span>
                    Alur Proses
                </h3>
                <p>Setiap laporan akan ditinjau oleh Admin Sarpras. Status akan berubah dari <strong>Menunggu</strong> ke <strong>Diproses</strong> saat teknisi mulai menangani, dan menjadi <strong>Selesai</strong> setelah perbaikan tuntas.</p>
            </div>
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">star</span>
                    Memberikan Feedback
                </h3>
                <p>Kami sangat menghargai masukan Anda. Berikan rating bintang dan komentar setelah laporan Anda ditandai sebagai Selesai untuk membantu kami meningkatkan layanan.</p>
            </div>
        </div>';
    return view('info', ['title' => 'Pusat Bantuan', 'icon' => 'help_center', 'content' => $content]);
})->name('info.bantuan');

Route::get('/kebijakan-privasi', function () {
    $content = '
        <div class="space-y-6 text-sm">
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">database</span>
                    Data yang Kami Kumpulkan
                </h3>
                <p>Kami hanya mengumpulkan data yang diperlukan untuk identifikasi pelapor seperti NIS, Nama, Kelas, dan informasi terkait sarana sekolah yang Anda laporkan.</p>
            </div>
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">admin_panel_settings</span>
                    Penggunaan & Keamanan
                </h3>
                <p>Data Anda digunakan secara eksklusif untuk koordinasi perbaikan fasilitas sekolah oleh tim internal Sarpras. Kami tidak membagikan identitas Anda kepada pihak ketiga di luar sekolah.</p>
            </div>
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">history</span>
                    Penyimpanan Data
                </h3>
                <p>History laporan Anda akan tetap tersimpan selama Anda masih terdaftar sebagai siswa aktif guna keperluan rekam jejak pemeliharaan aset sekolah secara digital.</p>
            </div>
        </div>';
    return view('info', ['title' => 'Kebijakan Privasi', 'icon' => 'security', 'content' => $content]);
})->name('info.privasi');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/kontak-admin', function() {
    $content = '
        <div class="space-y-6 text-sm">
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">email</span>
                    Email
                </h3>
                <p>Hubungi kami melalui email: <strong>sarpras@sekolah.sch.id</strong></p>
            </div>
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">phone</span>
                    Telepon
                </h3>
                <p>Hubungi Kepala Sarpras di nomor: <strong>(021) XXXX-XXXX</strong></p>
            </div>
            <div>
                <h3 class="text-slate-800 font-bold flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-600">location_on</span>
                    Lokasi
                </h3>
                <p>Ruang Sarpras berada di Gedung Utama, Lantai 2, Ruang 201.</p>
            </div>
        </div>';
    return view('info', ['title' => 'Kontak Admin', 'icon' => 'contact_support', 'content' => $content]);
})->name('info.kontak');

Route::prefix('siswa')->name('siswa.')->group(function () {

    Route::middleware('guest:siswa')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:siswa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::post('/notifications/{id}/mark-as-read', function($id) {
            $notification = \Illuminate\Support\Facades\Auth::guard('siswa')->user()->notifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
            }
            return back();
        })->name('notifications.read');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::singleton('/akun', AkunController::class)->except('show');
        Route::post('laporan/{aspirasi}/feedback', [LaporanPengaduanController::class, 'feedback'])
            ->name('laporan.feedback');
        Route::resource('laporan', LaporanPengaduanController::class)->except(['index', 'edit', 'update']);
    });
});

Route::prefix(config('admin.prefix'))->name('admin.')->group(function () {

    
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });


    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/akun', [AdminAkunController::class, 'index'])->name('akun');
        Route::post('/akun', [AdminAkunController::class, 'updateProfile']);
        Route::post('/akun/password', [AdminAkunController::class, 'updatePassword'])
            ->name('akun.password')
            ->middleware('throttle:3,1');
        Route::resource('kategori', KategoriController::class);
        Route::get('laporan/export', [LaporanAspirasiController::class, 'exportExcel'])->name('laporan.export');
        Route::resource('laporan', LaporanAspirasiController::class)
        ->only(['index', 'show', 'update']);
        Route::get('siswa/export', [SiswaController::class, 'export'])->name('siswa.export');
        Route::post('siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
        Route::resource('siswa', SiswaController::class);
    });
});
