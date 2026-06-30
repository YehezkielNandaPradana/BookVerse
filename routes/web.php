<?php

use Illuminate\Support\Facades\Route;

// =========================================================================
// MANUALLY REQUIRE CONTROLLERS (TO BYPASS PSR-4 COMPLIANCE PATH MISMATCH)
// =========================================================================
require_once app_path('Http/Controllers/Controller.php');
require_once app_path('Http/Controllers/AuthController.php');
require_once app_path('Http/Controllers/DashboardController.php');
require_once app_path('Http/Controllers/ProfileController.php');
require_once app_path('Http/Controllers/WishlistController.php');
require_once app_path('Http/Controllers/NotificationController.php');
require_once app_path('Http/Controllers/PublicController.php');
require_once app_path('Http/Controllers/AuditController.php');
require_once app_path('Http/Controllers/ReportController.php');
require_once app_path('Http/Controllers/SettingController.php');

require_once app_path('Http/Controllers/BookController.php');
require_once app_path('Http/Controllers/AuthorController.php');
require_once app_path('Http/Controllers/PublisherController.php');
require_once app_path('Http/Controllers/CategoryController.php');
require_once app_path('Http/Controllers/ShelfController.php');
require_once app_path('Http/Controllers/MemberController.php');
require_once app_path('Http/Controllers/LibrarianController.php');

require_once app_path('Http/Controllers/BorrowingController.php');
require_once app_path('Http/Controllers/ReturnController.php');
require_once app_path('Http/Controllers/FineController.php');
require_once app_path('Http/Controllers/ReservationController.php');

// Imports
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\AuthorController;
use App\Http\Controllers\Master\BookController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\LibrarianController;
use App\Http\Controllers\Master\MemberController;
use App\Http\Controllers\Master\PublisherController;
use App\Http\Controllers\Master\ShelfController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Transaction\BorrowingController;
use App\Http\Controllers\Transaction\FineController;
use App\Http\Controllers\Transaction\ReservationController;
use App\Http\Controllers\Transaction\ReturnController;
use App\Http\Controllers\WishlistController;

// ==========================================
// 1. PUBLIC ROUTES (GUEST / ALL USERS)
// ==========================================
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/books', [PublicController::class, 'books'])->name('public.books.index');
Route::get('/books/{book}', [PublicController::class, 'bookDetail'])->name('public.books.show');
Route::get('/profile-library', [PublicController::class, 'profile'])->name('public.profile');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');
Route::post('/contact', [PublicController::class, 'sendContact'])->name('public.contact.send');

// ==========================================
// 2. GUEST-ONLY ROUTES (AUTHENTICATION)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Forgot / Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ==========================================
// 3. AUTHENTICATED ROUTES
// ==========================================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification (Optional but defined in AuthController)
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.resend');

    // Dashboards
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])->name('petugas.dashboard');
    Route::get('/member/dashboard', [DashboardController::class, 'member'])->name('member.dashboard');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo.update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // Wishlist Management
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/', [WishlistController::class, 'store'])->name('store');
        Route::delete('/{wishlist}', [WishlistController::class, 'destroy'])->name('destroy');
    });

    // Notifications Management
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/recent', [NotificationController::class, 'recent'])->name('recent');
        Route::patch('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
        Route::patch('/read-all', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Master Data Routes
    Route::prefix('master')->name('master.')->group(function () {
        // Books Custom Operations
        Route::post('books/{book}/add-copy', [BookController::class, 'addCopy'])->name('books.add-copy');
        Route::get('books/copies/{bookCopy}/barcode', [BookController::class, 'generateBarcode'])->name('books.barcode');

        // Resources
        Route::resource('books', BookController::class);
        Route::resource('authors', AuthorController::class);
        Route::resource('publishers', PublisherController::class);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('shelves', ShelfController::class);
        Route::resource('members', MemberController::class);
        Route::resource('librarians', LibrarianController::class);
    });

    // Transactions Routes
    Route::prefix('transaction')->name('transaction.')->group(function () {
        // Borrowings (Peminjaman)
        Route::prefix('borrowings')->name('borrowings.')->group(function () {
            Route::get('/', [BorrowingController::class, 'index'])->name('index');
            Route::get('/create', [BorrowingController::class, 'create'])->name('create');
            Route::get('/search-book', [BorrowingController::class, 'searchBook'])->name('search-book');
            Route::get('/scan-copy', [BorrowingController::class, 'scanCopy'])->name('scan-copy');
            Route::post('/', [BorrowingController::class, 'store'])->name('store');
            Route::get('/{borrowing}', [BorrowingController::class, 'show'])->name('show');
            Route::post('/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('approve');
            Route::post('/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('reject');
            Route::get('/{borrowing}/receipt', [BorrowingController::class, 'printReceipt'])->name('receipt');
            Route::post('/{borrowing}/extend', [BorrowingController::class, 'requestExtension'])->name('request-extension');
            Route::post('/{borrowing}/approve-extend', [BorrowingController::class, 'approveExtension'])->name('approve-extension');
            Route::post('/{borrowing}/reject-extend', [BorrowingController::class, 'rejectExtension'])->name('reject-extension');
        });

        // Returns (Pengembalian)
        Route::prefix('returns')->name('returns.')->group(function () {
            Route::get('/', [ReturnController::class, 'index'])->name('index');
            Route::get('/search-borrowing', [ReturnController::class, 'searchBorrowing'])->name('search-borrowing');
            Route::get('/create/{borrowing}', [ReturnController::class, 'create'])->name('create');
            Route::post('/{borrowing}', [ReturnController::class, 'store'])->name('store');
            Route::get('/{return}', [ReturnController::class, 'show'])->name('show');
            Route::get('/{return}/receipt', [ReturnController::class, 'printReceipt'])->name('receipt');
        });

        // Fines (Denda)
        Route::prefix('fines')->name('fines.')->group(function () {
            Route::get('/', [FineController::class, 'index'])->name('index');
            Route::get('/member/{memberId}', [FineController::class, 'memberHistory'])->name('member-history');
            Route::get('/{fine}', [FineController::class, 'show'])->name('show');
            Route::get('/{fine}/pay', [FineController::class, 'createPayment'])->name('pay');
            Route::post('/{fine}/pay', [FineController::class, 'storePayment'])->name('store-payment');
        });

        // Reservations (Reservasi)
        Route::prefix('reservations')->name('reservations.')->group(function () {
            Route::get('/', [ReservationController::class, 'index'])->name('index');
            Route::post('/', [ReservationController::class, 'store'])->name('store');
            Route::get('/queue/{book}', [ReservationController::class, 'queue'])->name('queue');
            Route::post('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cancel');
            Route::post('/{reservation}/fulfill', [ReservationController::class, 'fulfill'])->name('fulfill');
            Route::get('/expire-overdue', [ReservationController::class, 'expireOverdue'])->name('expire-overdue');
        });
    });

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/books', [ReportController::class, 'books'])->name('books');
        Route::get('/members', [ReportController::class, 'members'])->name('members');
        Route::get('/borrowings', [ReportController::class, 'borrowings'])->name('borrowings');
        Route::get('/returns', [ReportController::class, 'returns'])->name('returns');
        Route::get('/fines', [ReportController::class, 'fines'])->name('fines');
        Route::get('/export/{type}/pdf', [ReportController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/export/{type}/excel', [ReportController::class, 'exportExcel'])->name('export-excel');
    });

    // Audit Logs Routes
    Route::prefix('audit')->name('audit.')->group(function () {
        Route::get('/activity-logs', [AuditController::class, 'activityLogs'])->name('activity-logs');
        Route::get('/login-histories', [AuditController::class, 'loginHistories'])->name('login-histories');
    });

    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'edit'])->name('edit');
        Route::put('/', [SettingController::class, 'update'])->name('update');
        Route::get('/announcements', [SettingController::class, 'announcements'])->name('announcements.index');
        Route::get('/announcements/create', [SettingController::class, 'createAnnouncement'])->name('announcements.create');
        Route::post('/announcements', [SettingController::class, 'storeAnnouncement'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [SettingController::class, 'editAnnouncement'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [SettingController::class, 'updateAnnouncement'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [SettingController::class, 'destroyAnnouncement'])->name('announcements.destroy');
    });
});
