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
        // abort(404); //not found page
        return redirect('/'); //redirect to homepage
    }

    //Caching cache()->remember(key, expiry, func)
   $post =  cache()->remember("posts.{$slug}", now()->addHours(24) , function () use ($path) {
       //now()->addDays() now()->addMinutes - helpers to avoid manual conversions
       //need access to $path inside a closure -> use ($path)
        // var_dump('file_get_contents'); -> just display 'file_get_contents' string when not in cache
        return file_get_contents($path); 
    });

    return view('post', [
        'post' => $post
    ]);
})->where('post', '[A-z_\-]+');

//where('post', '[A-z_\-]+');
//constraint -> use wildcard 'post' -> regex -> gives 404 if wrong characters
//regex: look for anything A to z could be capital or not, + means find one or more of preceding character and nothing else [A-z]+
//add _ and -, use \ to escape to avoid '-' being registered as 'to'
//whereAlpha('post');
//upper or lower case letter only