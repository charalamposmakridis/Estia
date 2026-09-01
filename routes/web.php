<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ReviewController;

Route::get('/', [ListingController::class, 'index'])->name('listings.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');

    Route::get('/my-listings', [ListingController::class, 'myListings'])->name('listings.user');
    Route::get('/my-favourites', [FavouriteController::class, 'index'])->name('favourites.index');
    Route::post('/listings/{listing}/favourite', [FavouriteController::class, 'toggle'])->name('favourites.toggle');

    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');


    Route::get('/owner/bookings', [BookingController::class, 'ownerIndex'])->name('bookings.owner');

    Route::resource('listings.bookings', BookingController::class)->except(['index']);

    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');

    Route::patch('/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('bookings.accept');
    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

    Route::post('/listings/{listing}/reviews', [ReviewController::class, 'store'])->name('listings.reviews.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

require __DIR__.'/auth.php';
