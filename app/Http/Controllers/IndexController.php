<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;

class IndexController extends SiteController
{
    //

    public function __construct(){
        
    }

    public function index(){
        $nav = Page::where('page_id', '=', 0)->where('status', '!=' , 4)->orderBy('priority', 'ASC')->get();
        $nav = $this->getMenu('nav', $nav);
        return view('index', compact('nav'));
    }

}
