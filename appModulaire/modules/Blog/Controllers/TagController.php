<?php

namespace Modules\Blog\Controllers;


use Modules\Core\Controllers\Controller;
use Modules\Blog\Models\Tag;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Blog\app\Exports\TagsExport;
use Modules\Blog\app\Imports\TagsImport;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::paginate(4);
        // dd($tags->toSql());
        // dd( $tags->currentPage());

        return view('Blog::admin.tag.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Blog::admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug'  => 'required|max:255',
        ]);

        Tag::create([
            'name' => $validated['title'],
            'slug'=> $validated['slug']
        ]);

        return redirect()->route('tag.index')->with('success', 'Catégorie créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return view('Blog::admin.tag.show',compact('tag'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('Blog::admin.tag.edit',compact('tag'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug'  => 'required|max:255',
        ]);

        $tag->update([
            'name' => $validated['title'],
            'slug'=> $validated['slug']
        ]);

        return redirect()->route('tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
            $tag->delete();
        return redirect()->route('tag.index');
    }
    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xlsmax:10240'
        ]);

        Excel::import(new TagsImport, $request->file('file'));
        return back()->with('success', 'Importation réussie !');
    }
    public function export()
    {
        return Excel::download(new TagsExport, 'Tags.xlsx');
    }
}
