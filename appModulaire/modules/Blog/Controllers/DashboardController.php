<?php

namespace Modules\Blog\Controllers;


use Modules\Core\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    

    public function index(){

        $totalUsers = User::count();
        $totalComments = Comment::count();
        $totalCategories = Category::count();
        $totalArticles = Article::count();
        return view('Blog::admin.dashboard',
        compact('totalUsers','totalComments','totalCategories','totalArticles'));
    }
}

