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

Route::get('faq', function () {
    return view('faq');
})->name('faq');

Route::get('demo', function () {
    return view('demo');
})->name('demo');

Route::get('features', function () {
    return view('features');
})->name('features');

Route::post('contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('faq', function () {
    return view('faq');
})->name('faq');

Route::get('/dashboard', function () {
    $user = auth()->user();

    $stats = Ticket::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

    $recentTickets = Ticket::where('user_id', $user->id)->latest()->take(3)->get();

    if ($user->isAdmin()) {
        $allTickets = Ticket::with(['user', 'comments.user'])->latest()->get();
        return view('dashboard', compact('stats', 'recentTickets', 'allTickets'));
    }

    return view('dashboard', compact('stats', 'recentTickets'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/request-closure', [TicketController::class, 'requestClosure'])->name('tickets.requestClosure');
    Route::post('/tickets/{ticket}/closure', [TicketController::class, 'handleClosure'])->name('tickets.handleClosure');
});

Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.contact.index');
    })->name('admin.index');
    Route::get('contact', [AdminContactController::class, 'index'])->name('admin.contact.index');
});

require __DIR__.'/auth.php';
