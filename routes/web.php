<?php

use App\Http\Controllers\AdminMessageReplyController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SendMessageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserManagementController;
use App\Mail\CreateTicketMailbox;
use App\Mail\TestMail;
use App\Services\MailSlurpService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Jetstream\Http\Controllers\Inertia\ProfilePhotoController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

    Route::get('/usersManagement', [UserManagementController::class, 'index'])->name('usersManagement.index');
    Route::get('/usersManagement/create', [UserManagementController::class, 'create'])->name('usersManagement.create');
    Route::post('/usersManagement', [UserManagementController::class, 'store'])->name('usersManagement.store');
    Route::get('/usersManagement/{user}/edit', [UserManagementController::class, 'edit'])->name('usersManagement.edit');
    Route::put('/usersManagement/{user}', [UserManagementController::class, 'update'])->name('usersManagement.update');
    Route::delete('/usersManagement/{user}', [UserManagementController::class, 'destroy'])->name('usersManagement.destroy');

 });
 Route::resource('tickets', TicketController::class);
 Route::resource('ticket-categories', CategoryController::class);

Route::get('/sendemail', function () {
    $to = 'tickets@example.com';
    $subject = 'Teste de Ticket';
    $message = 'Este é um teste de ticket criado a partir do MailHog.';
    $headers = 'From: your-email@example.com';

    mail($to, $subject, $message, $headers);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])->name('user-profile-information.update');
    Route::delete('/user/profile-photo', [ProfilePhotoController::class, 'destroy'])->name('current-user-photo.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])->name('user-profile-information.update');
    Route::delete('/user/profile-photo', [ProfilePhotoController::class, 'destroy'])->name('current-user-photo.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::apiResource('users', UserManagementController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('tickets', TicketController::class);
});

Route::get('/create-inbox', function (MailSlurpService $mailSlurpService) {
    $inbox = $mailSlurpService->createInbox();
    return response()->json($inbox);
});
