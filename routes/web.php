<?php

use App\Livewire\DeelthemaComp;
use App\Livewire\ZelftoetsComp;
use App\Livewire\HoofdthemaComp;
use App\Livewire\HomeComp;
use App\Livewire\DashboardComp;
use App\Livewire\ValidatieComp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth.login');
});
Route::middleware('auth')->group(function () {

Route::get('/home', HomeComp::class)->name('home');

Route::get('/help', [HelpController::class, 'index'])->name('help');
Route::post('/help', [HelpController::class, 'submit'])->name('help.submit');

Route::get('/hoofdthema', HoofdthemaComp::class)->name('hoofdthema');
Route::get('/deelthema/{id}', DeelthemaComp::class)->name('deelthema');
Route::get('/zelftoets/{hoofdthema}', ZelftoetsComp::class)->name('zelftoets');
Route::get('/dashboard', DashboardComp::class)->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/validatie/{user_id}/{token}', ValidatieComp::class)->name('validatie');

require __DIR__.'/auth.php';
