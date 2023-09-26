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
//Route for homepage
Route::get('/', [CustomizedController::class, 'homepage'])->name('homepage');



//Route for Authentications
Route::get('/login', [CustomizedController::class, 'login'])->name('login')->middleware('alreadyLoggedIn');
Route::post('/loginUser', [CustomizedController::class, 'loginUser'])->name('loginUser');
Route::get('/logout', [CustomizedController::class, 'logout'])->name('logout');
Route::get('/registrationUser', [CustomizedController::class, 'registrationUser'])->name('registrationUser')->middleware('alreadyLoggedIn');
Route::post('/register-User', [CustomizedController::class, 'registerUser'])->name('register-User');
Route::get('/registrationAgency', [CustomizedController::class, 'registrationAgency'])->name('registrationAgency')->middleware('alreadyLoggedIn');
Route::post('/register-Agency', [CustomizedController::class, 'registerAgency'])->name('register-Agency');



//Route for settings(Profile update,delete)
Route::get('/settings', [CustomizedController::class, 'settings'])->middleware('isLoggedIn')->name('settings');
Route::get('/user-profile/{email}', [CustomizedController::class, 'showUserProfile'])->middleware('isLoggedIn')->name('user.profile.show');
Route::put('/profile-edit/{email}', [CustomizedController::class, 'updateProfile'])->middleware('isLoggedIn')->name('update.profile');
Route::get('/profile-edit', [CustomizedController::class, 'editProfile'])->middleware('isLoggedIn')->name('edit.profile');
Route::delete('/delete-account/{email}', [CustomizedController::class, 'deleteAccount'])->name('delete.account');



//Route to change password
Route::put('/update-password/{email}', [CustomizedController::class, 'updatePassword'])->name('update.password');




//Route for password reset
Route::get('/emailVerify', [CustomizedController::class, 'emailVerifyGet'])->name('email.verify.get');
Route::post('/email-verify', [CustomizedController::class, 'emailVerifyPost'])->name('email.verify.post');
Route::get('/password-reset/{token}', [CustomizedController::class, 'passwordResetGet'])->name('password.reset.get');
Route::post('/password-reset', [CustomizedController::class, 'passwordResetPost'])->name('password.reset.post');



//Routes for Posts
Route::get('/create-posts/{email}', [CustomizedController::class, 'createPostGet'])->name('create.post.get');
Route::post('/create-posts-post/{email}', [CustomizedController::class, 'createPostPost'])->name('create.post.post');




//Just for debugging
Route::get('/request-list', [CustomizedController::class, 'showRequestList'])->name('show.requests');