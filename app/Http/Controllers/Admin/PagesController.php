<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Menu;

use App\Page;

use Illuminate\Validation\Rule;

class PagesController extends AdminController
{
    //

    public function index($path){
        $page = Page::where('path', '=' , $path)->where('status', '<' , 4)->first();
        if($page->status == 0){
            $article = $page;
            $nav = Page::where('page_id', '=', 0)->where('status', '<' , 4)->orderBy('priority', 'ASC')->get();
            $nav = $this->getMenu('nav', $nav, null, 'admin/');

            $nav_back = $this->navBack($page);
            $nav_back = array_reverse($nav_back); 
            $nav_back_up = $nav_back;
            $nav_back_up = $this->nav_back_up($nav_back_up, 'admin/');
            $nav_back_up .= "<p>$article->name</p>";
            
            $nav_back = $this->getMenu('nav_back', $nav_back, null, 'admin/');

            return view('admin.article', compact('nav_back_up', 'nav_back', 'article', 'nav'));
        }
        $nav_back = $this->navBack($page);
        $nav_back = $this->getMenu('nav_back', array_reverse($nav_back), null, 'admin/');
        $nav = Page::where('page_id', '=' , $page->id)->where('status', '<' , 4)->orderBy('priority', 'ASC')->get();
        //$nav = $this->getMenu('nav', $nav, null, 'admin/');
        $articles = Page::where('page_id', '=' , $page->id)->where('status', '>=' , 4)->orderBy('priority', 'ASC')->get();
        //$articles = $this->getMenu('articles', $articles, null, 'admin/');
        if($page->status == 2){
            $page->imgLeft = json_decode($page->imgLeft);
            $page->imgRight = json_decode($page->imgRight);
        }
        return view('admin.page', compact('page', 'nav', 'articles', 'nav_back'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($path = '', $webPage = '')
    {
        $page = new \stdClass();
        $page->status = 1;
        if($path == 'newWebPage' && $webPage == 'newWebPage'){
            $path = '';
            $page->status = 0;
        }
        if($path == 'complexSection' && $webPage == 'complexSection'){
            $path = '';
            $page->status = 2;
        }
        return view('admin.page-update', compact('path', 'page'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function make(Request $request, $path = '')
    {

        $data = $request->only([
            'name', 'img', 'imgText', 'path', 'text', 'imgLeft', 'imgRight', 'status'
        ]);
        $data['page_id'] = 0;
        if($data['status'] == 2){
            if (strpos($data['img'], '\\') !== false) {
                $data['img'] = '/' . str_replace('\\', '/', $data['img']);
            }
            $col = count($data['imgLeft']);
            $imgLeft = [];
            for ($i=0; $i < $col; $i++) { 
                if (strpos($data['imgLeft'][$i], '\\') !== false) {
                    $imgLeft[$i] = '/' . str_replace('\\', '/', $data['imgLeft'][$i]);
                }
                else {
                    if(strpos($data['imgLeft'][$i], '/') !== false){
                        $imgLeft[$i] = $data['imgLeft'][$i];
                    }
                    else{
                        break;
                    }
                }
            }
            $col = count($data['imgRight']);
            $imgRight = [];
            for ($i=0; $i < $col; $i++) { 
                if (strpos($data['imgRight'][$i], '\\') !== false) {
                    $imgRight[$i] = '/' . str_replace('\\', '/', $data['imgRight'][$i]);
                }
                else {
                    if(strpos($data['imgRight'][$i], '/') !== false){
                        $imgLeft[$i] = $data['imgLeft'][$i];
                    }
                    else{
                        break;
                    }
                }
            }
            $data['imgLeft'] = json_encode($imgLeft);
            $data['imgRight'] = json_encode($imgRight);
        }
        
        if($path){
            $page = Page::where('path', '=' , $path)->where('status', '<' , 4)->first();
            
            $data['page_id'] = $page->id;

            $data['path'] = $page->path . '-' . $data['path'];
        }
        $page_id = $data['page_id'];
        $request->validate([
            'name' => Rule::unique('pages'),
            'path' => Rule::unique('pages')->where(function ($query) use($page_id) {
                $query->where('status', '!=','4');
            }),
        ]);
        $page = Page::create($data);


        //$page->users()->attach(\Auth::user()->id);
        return redirect()->route('admin.pages.index', $path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $path = '', $webPage = '')
    {
        if($path == 'newWebPage' && $webPage == 'newWebPage'){
            $path = '';
            $webPage = true;
        }
        $page = Page::findOrFail($id);

        $pathM =  explode('-', $page['path']);
        $page->path = $pathM[count($pathM) - 1];
        if($page->status == 2){
            $page->imgLeft = json_decode($page->imgLeft);
            $page->imgRight = json_decode($page->imgRight);
        }

        return view('admin.page-update', compact('path', 'page', 'webPage'));
    }

    public function update(Request $request, $id, $path = '')
    {
        $data = $request->only([
            'name', 'img', 'imgText', 'path', 'text', 'imgLeft', 'imgRight', 'status'
        ]);
        $data['page_id'] = 0;
        if($data['status'] == 2){
            if (strpos($data['img'], '\\') !== false) {
                $data['img'] = '/' . str_replace('\\', '/', $data['img']);
            }
            $col = count($data['imgLeft']);
            $imgLeft = [];
            for ($i=0; $i < $col; $i++) { 
                if (strpos($data['imgLeft'][$i], '\\') !== false) {
                    $imgLeft[$i] = '/' . str_replace('\\', '/', $data['imgLeft'][$i]);
                }
                else {
                    if(strpos($data['imgLeft'][$i], '/') !== false){
                        $imgLeft[$i] = $data['imgLeft'][$i];
                    }
                    else{
                        break;
                    }
                }
            }
            $col = count($data['imgRight']);
            $imgRight = [];
            for ($i=0; $i < $col; $i++) { 
                if (strpos($data['imgRight'][$i], '\\') !== false) {
                    $imgRight[$i] = '/' . str_replace('\\', '/', $data['imgRight'][$i]);
                }
                else {
                    if(strpos($data['imgRight'][$i], '/') !== false){
                        $imgLeft[$i] = $data['imgLeft'][$i];
                    }
                    else{
                        break;
                    }
                }
            }
            $data['imgLeft'] = json_encode($imgLeft);
            $data['imgRight'] = json_encode($imgRight);
        }

        if($path){
            $page = Page::where('path', '=' , $path)->where('status', '<' , 4)->first();
            
            $data['page_id'] = $page->id;

            $data['path'] = $page->path . '-' . $data['path'];
        }
        $page_id = $data['page_id'];
        $request->validate([
            'name' => Rule::unique('pages')->ignore($id, 'id'),
            'path' => Rule::unique('pages')->where(function ($query) use($page_id) {
                $query->where('status', '!=','4');
            })->ignore($id, 'id'),
        ]);
        $page = Page::findOrFail($id);
        $page->update($data);

        return redirect()->route('admin.pages.index', $path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id, $path ='')
    {
        //dd($id);
        $pagesDel = $this->pagesDel($id);
        $pagesDel[] = $id;
        Page::destroy($pagesDel);
        return redirect()->route('admin.pages.index', $path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function priority(Request $request, $path = '')
    {
        $data = $request->only([
            'ids'
        ]);
        $pages = Page::findOrFail($data['ids']);
        
        foreach ($pages as $page) {
            foreach ($data['ids'] as $key => $value) {
                if($page->id == $value){
                    $page->priority = $key;
                    $page->update();
                    unset($data[$key]);
                    break;
                }
            }
        }
        return redirect()->route('admin.pages.index', $path);
    }

    function pagesDel($id)
    {
        $pages = Page::where('page_id', '=' , $id)->get()->keyBy('id')->toArray();
        $keys = array_keys($pages);
        //dd($keys);
        foreach ($keys as $key) {
            $keys = array_merge($keys, $this->pagesDel($key));
        }
        
        return $keys;
    }
}
