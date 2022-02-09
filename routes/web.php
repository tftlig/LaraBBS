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
// 2.6章 首页
// Route::get('/','PagesController@root')->name('root');
Route::get('/', 'TopicsController@index')->name('root');


// 3.1章：用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 3.1章：用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 3.1章：密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 3.1章：Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// 4.1章：注册user资源控制器的路由，遵循 RESTful URI 的规范
Route::resource('users','UsersController',['only' => ['show','update','edit']]);
// 上面代码等同于
// Route::get('/users/{user}', 'UsersController@show')->name('users.show');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');




// 6.8 slug翻译
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');


// 5.7章 分类下的话题列表
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

// 7.3章 发布回复路由
Route::resource('replies', 'RepliesController', ['only' => ['store','destroy']]);


// 7.5章 通知列表
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

// 8.8章 无权限提醒页面
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');
