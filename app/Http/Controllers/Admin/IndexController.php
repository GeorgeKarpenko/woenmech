<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\ArticlesRepository;

use Menu;

use App\Page;

class IndexController extends AdminController
{
    //

    public function index(){
        $nav = Page::where('page_id', '=', 0)->orderBy('priority', 'ASC')->get();
        return view('admin.index', compact('nav'));
    }



}
