<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomizedController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [CustomizedController::class, 'login'])->name('login')->middleware('alreadyLoggedIn');
Route::get('/registrationUser', [CustomizedController::class, 'registrationUser'])->name('registrationUser')->middleware('alreadyLoggedIn');
Route::get('/registrationAgency', [CustomizedController::class, 'registrationAgency'])->name('registrationAgency')->middleware('alreadyLoggedIn');

Route::get('/', [CustomizedController::class, 'homepage'])->name('homepage');

Route::post('/loginUser', [CustomizedController::class, 'loginUser'])->name('loginUser');
Route::post('/register-User', [CustomizedController::class, 'registerUser'])->name('register-User');
Route::post('/register-Agency', [CustomizedController::class, 'registerAgency'])->name('register-Agency');
Route::get('/logout', [CustomizedController::class, 'logout'])->name('logout');

Route::get('/profile', [CustomizedController::class, 'profile'])->middleware('isLoggedIn')->name('profile');
Route::put('/profile-edit/{email}', [CustomizedController::class, 'updateProfile'])->middleware('isLoggedIn')->name('update.profile');
Route::get('/profile-edit', [CustomizedController::class, 'editProfile'])->middleware('isLoggedIn')->name('edit.profile');


Route::get('/emailVerify', [CustomizedController::class, 'emailVerifyGet'])->name('email.verify.get');
Route::post('/email-verify', [CustomizedController::class, 'emailVerifyPost'])->name('email.verify.post');
Route::get('/password-reset/{token}', [CustomizedController::class, 'passwordResetGet'])->name('password.reset.get');
Route::post('/password-reset', [CustomizedController::class, 'passwordResetPost'])->name('password.reset.post');
Route::delete('/delete-account/{email}', [CustomizedController::class, 'deleteAccount'])->name('delete.account');
Route::put('/update-password/{email}', [CustomizedController::class, 'updatePassword'])->name('update.password');

Route::get('/show-posts-agency', [CustomizedController::class, 'showPostsAgency'])->name('show.posts.agency');

Route::get('/location', [CustomizedController::class, 'location'])->name('location');

Route::get('/myAds', [CustomizedController::class, 'showMyAds'])->name('show.my.ads');


// Route::controller(CustomizedController\)