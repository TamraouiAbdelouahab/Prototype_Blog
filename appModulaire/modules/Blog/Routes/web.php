<?php


use Modules\Blog\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Controllers\ArticleController;
use Modules\Blog\Controllers\CategoryController;
use Modules\Blog\Controllers\CommentController;
use Modules\Blog\Controllers\TagController;
use Modules\Blog\Controllers\UserController;



Route::get('/', function () {
    return view('Blog::auth.login');
});
// Route::get('/', function () {
//     return view('Blog::auth.login');
// })->middleware('guest');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('articles/{article}/comments', [CommentController::class, 'indexByArticle'])->name('comment.indexByArticle');
Route::delete('articles/comment/{comment}', [CommentController::class, 'destroyByArticle'])->name('comment.destroyByArticle');



Route::resource('/dashboard/comment',CommentController::class);
Route::resource('/dashboard/article',ArticleController::class);
Route::resource('/dashboard/category',CategoryController::class);
Route::resource('/dashboard/tag',TagController::class);


Route::get('/home', [Modules\Blog\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/public', [Modules\Blog\Controllers\HomeController::class, 'publicIndex'])->name('public.public.index');
Route::get('/public/article/{id}', [Modules\Blog\Controllers\HomeController::class, 'publicShow'])->name('public.public.show');
Route::post('/articles/{id}/comments', [Modules\Blog\Controllers\CommentController::class, 'store'])->name('public.article.comments.store');


// Admin Routes with 'admin' role middleware
Route::group(['middleware' => ['permission:view admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard/article', ArticleController::class);
    Route::resource('/dashboard/category', CategoryController::class);
    Route::resource('/dashboard/tag', TagController::class);
    Route::resource("/dashboard/user",UserController::class);

});



// Route::get('change', [LanguageController::class, 'change'])->name("lang.change");