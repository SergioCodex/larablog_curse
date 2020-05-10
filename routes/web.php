<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/*Route::get('home/{nombre?}', function ($nombre = "Invitado") {
    return view("home")->with([
        "nom" => $nombre,
        "blog" => "Blog"
    ]);
})->name("home");*/

Route::resource('dashboard/post', 'dashboard\PostController');

Route::post('dashboard/post/{post}/image', 'dashboard\PostController@image')->name('post.image');
Route::get('dashboard/post/image-download/{image}', 'dashboard\PostController@imageDownload')->name('post.image-download');
Route::delete('dashboard/post/image-delete/{image}', 'dashboard\PostController@imageDelete')->name('post.image-delete');
Route::post('dashboard/post/content-image', 'dashboard\PostController@contentImage');

Route::resource('dashboard/category', 'dashboard\CategoryController');
Route::resource('dashboard/user', 'dashboard\UserController');
Route::resource('dashboard/contact', 'dashboard\ContactController')->only([
    'index', 'show', 'destroy'
]);
Route::resource('dashboard/post-comment', 'dashboard\PostCommentController')->only([
    'index', 'show', 'destroy'
]);
Route::get('dashboard/post-comment/{post}/post', 'dashboard\PostCommentController@post')->name('post-comment.post');
Route::get('dashboard/post-comment/j-show/{postComment}', 'dashboard\PostCommentController@jshow');
Route::post('dashboard/post-comment/process/{postComment}', 'dashboard\PostCommentController@process');

Route::get('/', 'web\WebController@index')->name('index');
Route::get('/categories', 'web\WebController@index')->name('index');

Route::get('/detail/{id}', 'web\WebController@detail');
Route::get('/post-category/{category_id}', 'web\WebController@post_category');

Route::get('/contact', 'web\WebController@contact');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/charts', 'PaquetesController@charts')->name('charts');
Route::get('/image', 'PaquetesController@image')->name('image');
Route::get('/qr', 'PaquetesController@qr_generate')->name('qr');
Route::get('/stripe_create_customer', 'PaquetesController@stripe_create_customer');
Route::get('/stripe_payment_method_register', 'PaquetesController@stripe_payment_method_register');
Route::get('/stripe_payment_method_create', 'PaquetesController@stripe_payment_method_create');
Route::get('/stripe_payment_method', 'PaquetesController@stripe_payment_method');
Route::get('/stripe_create_only_pay_form', 'PaquetesController@stripe_create_only_pay_form');
Route::get('/stripe_create_only_pay', 'PaquetesController@stripe_create_only_pay');
Route::get('/stripe_subscription', 'PaquetesController@stripe_subscription');