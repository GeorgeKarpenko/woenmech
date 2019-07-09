<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Menu;

use App\Page;

use Illuminate\Validation\Rule;

class ArticlesController extends AdminController
{
    //

    public function index($path, $alias){
        //$page = Page::where('path', '=' , $path)->where('status', '!=' , 4)->first();
        $article = Page::where('path', '=' , $alias)->where('status', '=' , 4)->first();
        $nav = Page::where('page_id', '=', 0)->orderBy('priority', 'ASC')->get();
        $nav = $this->getMenu('nav', $nav, null, 'admin/');

        $nav_back = $this->navBack($article);
        $nav_back = array_reverse($nav_back); 
        $nav_back_up = $nav_back;
        $nav_back_up = $this->nav_back_up($nav_back_up, 'admin/');
        $nav_back_up .= "<p>$article->name</p>";
        
        $nav_back = $this->getMenu('nav_back', $nav_back, null, 'admin/');

        return view('admin.article', compact('nav_back_up', 'nav_back', 'article', 'nav'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($path)
    {
        return view('admin.article-update', compact('path'));
    }

    public function audioCreate($path)
    {
        return view('admin.audio-update', compact('path'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function make($path, Request $request)
    {
        $data = $request->only([
            'name', 'path', 'text', 'author', 'status'
        ]);
        
        $page = Page::where('path', '=' , $path)->where('status', '<' , 4)->first();
        $page_id = $page->id;
        if($request->status == 5){
            $data = $request->only([
                'name', 'audio', 'status'
            ]);
            if (strpos($data['img'], '\\') !== false) {
                $data['img'] = '/' . str_replace('\\', '/', $data['img']);
            }
            $request->validate([
                'name' => Rule::unique('pages'),
                'aduio' => Rule::unique('pages')->where(function ($query) use($page_id) {
                    $query->where('status', '=','5')->where('page_id', $page_id);
                }),
            ]);
        }
        else{
            $request->validate([
                'name' => Rule::unique('pages'),
                'path' => Rule::unique('pages')->where(function ($query) use($page_id) {
                    $query->where('status', '=','4')->where('page_id', $page_id);
                }),
            ]);
        }
        $data['page_id'] = $page->id;

        $article = Page::create($data);
        if(isset($data['author']) && !$data['author']){
            $article->users()->attach(\Auth::user()->id);
        }

        return redirect()->route('admin.pages.index', $page->path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Page::findOrFail($id);

        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($path, $id)
    {
        if(!\Auth::user()->pages($id) && !\Auth::user()->isAdmin()){
            \App::abort(403);
        }
        $article = Page::findOrFail($id);

        if($article->status == 5){
            return view('admin.audio-update', compact('article', 'path'));
        }
        return view('admin.article-update', compact('article', 'path'));
    }

    public function update($path, $id, Request $request)
    {
        if(!\Auth::user()->pages($id) && !\Auth::user()->isAdmin()){
            \App::abort(403);
        }
        $data = $request->only([
            'name', 'path', 'text', 'status'
        ]);
        
        $page = Page::where('path', '=' , $path)->where('status', '<' , 4)->first();
        $page_id = $page->id; 
        if($request->status == 5){
            $data = $request->only([
                'name', 'audio'
            ]);
            if (strpos($data['img'], '\\') !== false) {
                $data['img'] = '/' . str_replace('\\', '/', $data['img']);
            }
            $request->validate([
                'name' => Rule::unique('pages')->ignore($id, 'id'),
                'aduio' => Rule::unique('pages')->where(function ($query) use($page_id) {
                    $query->where('status', '=','5')->where('page_id', $page_id);
                })->ignore($id, 'id'),
            ]);
        }
        else{
            $request->validate([
                'name' => Rule::unique('pages')->ignore($id, 'id'),
                'path' => Rule::unique('pages')->where(function ($query) use($page_id) {
                    $query->where('status', '=','4')->where('page_id', $page_id);
                })->ignore($id, 'id'),
            ]);
        }
        $data['page_id'] = $page->id;
        $article = Page::findOrFail($id);
        $article->update($data);

        return redirect()->route('admin.pages.index', $path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function priority(Request $request, $path)
    {
        
        $data = $request->only([
            'ids'
        ]);
        $articles = Page::findOrFail($data['ids']);
        
        foreach ($articles as $article) {
            foreach ($data['ids'] as $key => $value) {
                if($article->id == $value){
                    $article->priority = $key;
                    $article->update();
                    unset($data[$key]);
                    break;
                }
            }
        }
        return redirect()->route('admin.pages.index', $path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if(!\Auth::user()->pages($id) && !\Auth::user()->isAdmin()){
            \App::abort(403);
        }
        $article = Page::findOrFail($id);
        $page = Page::findOrFail($article->page_id);
        $article->delete();

        return redirect()->route('admin.pages.index', $page->path);
    }
}
