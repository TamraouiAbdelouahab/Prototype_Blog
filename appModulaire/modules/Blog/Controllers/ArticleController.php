<?php

namespace Modules\Blog\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Modules\Core\Controllers\Controller;
use Modules\Blog\app\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Services\ArticleService;
use Modules\Blog\Services\TagService;
use Modules\Blog\Services\CategoryService;
use Modules\Blog\app\Imports\ArticlesImport;
use Illuminate\Http\Request;
use Modules\Blog\app\Exports\ArticlesExport;

class ArticleController extends Controller
{

    protected $articleService;
    protected $tagService;
    protected $categoryService;

    public function __construct(ArticleService $articleService,TagService $tagService, CategoryService $categoryService)
    {
        $this->articleService = $articleService;
        $this->tagService = $tagService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = $this->articleService->paginate(4);
        return view('Blog::admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getAll();
        $tags = $this->tagService->getAll();
        return view('Blog::admin.article.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        // $valideted = $request->validate([
        //     'title'=> 'required',
        //     'content'=> 'required',
        //     'category'=> 'required',
        //     'tags'=>'array',
        //     'tags.*' => 'exists:tags,id'
        // ]);

        // $article = Article::create([
        //     'title'=> $valideted['title'],
        //     'content'=> $valideted['content'],
        //     'user_id'=>Auth::user()->id,
        //     'category_id'=> $valideted['category'],
        // ]);
        $validated = $request->validated();
        $validated["user_id"] = Auth::id();
        $validated["category_id"] = $request->category;
        $article = $this->articleService->create( $validated);

        $article->tags()->attach($request->tags);



        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = $this->articleService->find($id);
        if(!$article){
            abort(404);
        }
        return view('Blog::admin.article.show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(string $id)
    {
        $article = $this->articleService->find($id);
        if(!$article){
            abort(404);
        }
        $categories = $this->categoryService->getAll();
        $tags = $this->tagService->getAll();
        return view('Blog::admin.article.edit',compact('article','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, string $id)
    {
        $validated = $request->validated();
        $article = $this->articleService->find($id);
        if(!$article){
            abort(404);
        }
        $article->update([
            'title'=> $validated['title'],
            'content'=> $validated['content'],
            'category_id'=> $validated['category'],
        ]);
        $article->tags()->sync($request->tags);

        return redirect()->route('article.index')->with('success', 'Article créé avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = $this->articleService->find($id);
        if(!$article){
            abort(404);
        }
        // $article = Article::find($id);
        // $this->authorize('delete', $article);
        $article->delete();
        return redirect()->route('article.index')->with('success', 'Article supprimé avec succès.');
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);
        Excel::import(new ArticlesImport, $request->file('file'));
        return back()->with('success', 'Importation réussie !');
    }
    public function export()
    {
        return Excel::download(new ArticlesExport, 'articles.xlsx');
    }
}
