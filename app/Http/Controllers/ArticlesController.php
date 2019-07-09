<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Menu;

use Carbon\Carbon; 

use App\Page;

class ArticlesController extends SiteController
{
    //

    public function __construct(){
        
    }

    public function index($path){
        $page = Page::where('path', '=' , $path)->where('status', '<' , 4)->first();

        if(!$page){
            abort(404);
        }

        if($page->status == 0){
            $article = $page;
            $nav = Page::where('page_id', '=', 0)->orderBy('priority', 'ASC')->get();
            $nav = $this->getMenu('nav', $nav);

            $nav_back = $this->navBack($page);
            $nav_back = array_reverse($nav_back); 
            $nav_back_up = $nav_back;
            $nav_back_up = $this->nav_back_up($nav_back_up);
            $nav_back_up .= "<p>$article->name</p>";
            
            $nav_back = $this->getMenu('nav_back', $nav_back);

            return view('article', compact('nav_back_up', 'nav_back', 'article', 'nav'));
        }
        
        $navPullDown = Page::where('page_id', '=', 0)->where('status', '<' , 4)->orderBy('priority', 'ASC')->get();
        $navPullDown = $this->getMenu('navPullDown', $navPullDown);
        
        $nav_back = $this->navBack($page);
        $nav_back = array_reverse($nav_back); 
        $nav_back_up = $nav_back;
        $nav_back_up = $this->nav_back_up($nav_back_up);
        $nav_back_up .= "<p>$page->name</p>";

        $nav_back = $this->getMenu('nav_back', $nav_back);
        $nav = Page::where('page_id', '=' , $page->id)->where('status', '<' , 4)->orderBy('priority', 'ASC')->get();
        $nav = $this->getMenu('nav', $nav);
        $articles = Page::where('page_id', '=' , $page->id)->where('status', '>=' , 4)->orderBy('priority', 'ASC')->get();
        //$articles = $this->getMenu('articles', $articles, null, $path . '/');
        if($page->status == 2){
            $page->imgLeft = json_decode($page->imgLeft);
            $page->imgRight = json_decode($page->imgRight);
        }
        return view('page', compact('nav_back_up', 'page', 'nav', 'articles', 'nav_back', 'navPullDown'));
    }

    public function show($path, $alias){


        
        $article = Page::where('path', '=' , $alias)->where('status', '=' , 4)->first();

        if(!$article){
            abort(404);
        }

        $nav_back = $this->navBack($article);
        $nav_back = array_reverse($nav_back);  
        $nav_back_up = $nav_back;
        $nav_back_up = $this->nav_back_up($nav_back_up);
        $nav_back_up .= '<p>' . str_limit($article->name, 30) . '</p>';

        if(!$article->author){
            $author = $article->users;
            $article->author = $author[0]->name;
        }
        
        $arr = [
            'январь',
            'февраль',
            'март',
            'апрель',
            'май',
            'июнь',
            'июль',
            'август',
            'сентябрь',
            'октябрь',
            'ноябрь',
            'декабрь'
        ];
        $month = $article->created_at->month-1;
        $dY = $article->created_at->format('d, Y');
        $article->created = $arr[$month] . ' ' . $article->created_at->format('d, Y');


        $nav_back = $this->getMenu('nav_back', $nav_back);
        
        $articles_page = Page::where('id', '!=', $article->id)
        ->where('page_id', '=', $article->page_id)
        ->where('status', '=' , 4)
        ->orderByRaw('RAND()')
        ->take(5)
        ->get();
        
        $articles_no_page = Page::where('page_id', '!=', $article->page_id)
        ->where('status', '=' , 4)
        ->orderByRaw('RAND()')
        ->take(5)
        ->get();
        
        $nav = $this->getMenu('articles_page', $articles_page, $articles_no_page, $path . '/');
        
        return view('article', compact('nav_back_up', 'nav_back', 'article', 'nav'));
    }


}
