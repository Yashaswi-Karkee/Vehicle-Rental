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


//Route for filters
Route::get('/filter={val}', [CustomizedController::class, 'filteringPost'])->name('product.filter.post');
Route::post('/filter={val}', [CustomizedController::class, 'filteringGet'])->name('product.filter.get');



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
Route::get('/update-posts/{id}', [CustomizedController::class, 'updatePostGet'])->name('update.post.get');
Route::put('/update-posts-post/{id}', [CustomizedController::class, 'updatePostPost'])->name('update.post.post');
Route::delete('/delete-posts/{id}', [CustomizedController::class, 'deletePosts'])->name('delete.posts');




//Routes for orders
Route::get('/order/id={id}/by={userEmail}/from={ownerEmail}', [CustomizedController::class, 'getOrderPage'])->name('order.get');
Route::post('/order-post/id={id}/by={userEmail}/from={ownerEmail}', [CustomizedController::class, 'postOrderPage'])->name('order.post');
Route::delete('/order-delete/{id}', [CustomizedController::class, 'deleteOrder'])->middleware('isLoggedIn')->name('delete.order');
Route::get('/order-edit/{id}', [CustomizedController::class, 'editOrderView'])->name('edit.order.view');
Route::put('/order-update/{id}', [CustomizedController::class, 'editOrderPost'])->name('edit.order.post');
Route::get('/paymentSelection/{id}', [CustomizedController::class, 'paymentSelection'])->name('payment.select');
Route::post('/paymentSelectionPost/{id}/{userEmail}/{agencyEmail}', [CustomizedController::class, 'paymentSelectionPost'])->name('payment.select.post');
Route::get('/success/{id}', [CustomizedController::class, 'stripeSuccess'])->name('success.stripe');
Route::get('/fail/{id}', [CustomizedController::class, 'stripeFailure'])->name('fail.stripe');
Route::get('/success', [CustomizedController::class, 'esewaSuccess'])->name('success.esewa');
Route::get('/fail', [CustomizedController::class, 'esewaFailure'])->name('fail.esewa');






//Just for debugging
Route::get('/request-list', [CustomizedController::class, 'showRequestList'])->name('show.requests');