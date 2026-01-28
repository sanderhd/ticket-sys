<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminContactController;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;

Route::get('/', function () {
    return view('welcome');
});

Route::get('over-ons', function () {
    return view('over-ons');
})->name('over-ons');

Route::get('prijzen', function () {
    return view('prijzen');
})->name('prijzen');

Route::get('contact', function () {
    return view('contact');
})->name('contact');

Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('faq', function () {
    return view('faq');
})->name('faq');

Route::get('/dashboard', function () {
    $stats = Ticket::where('user_id', auth()->id())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('tickets', TicketController::class);
});

Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('contact', [AdminContactController::class, 'index'])->name('admin.contact.index');
});

require __DIR__.'/auth.php';
