<?php
use App\Livewire\Pricing;
use App\Livewire\CourseList;
use App\Livewire\ShowCourse;
use App\Livewire\WatchEpisode;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CheckoutController;




// Route::get('/courses', CourseList::class)->name('courses');
// Route::get('/courses/{course}', ShowCourse::class)->name('courses.show');

// Route::get('/pricing', Pricing::class)->name('pricing');
// Route::get('/billing', BillingController::class)->name('billing');
// Route::get('/checkout/success', CheckoutController::class)->name('checkout.success');



Route::view('/', 'welcome');

Route::get('/pricing',Pricing::class)->name('pricing');

Route::get('/courses',CourseList::class)->name('courses.index');
Route::get('/courses/{course?}',ShowCourse::class)
->name('courses.show');

Route::get('/courses/{course}/episodes/{episode?}',WatchEpisode::class)
->middleware(['auth'])
->name('courses.episodes.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
