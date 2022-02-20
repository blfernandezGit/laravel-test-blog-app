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

Route::get('/', function () {
    return view('posts');
});

// {post} wrapped in braces - wildcard, like :id - will be accessed using the $slug variable
Route::get('/posts/{post}', function ($slug) {
    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    if (! file_exists($path)) {
        dd('file does not exist'); //for quick debugging - dump and die (ddd not currently working)
    }

    $post = file_get_contents($path);

    return view('post', [
        'post' => $post
    ]);
});
