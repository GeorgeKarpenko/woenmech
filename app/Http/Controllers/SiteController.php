<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\MenusRepository;

use App\Page;

use Menu;

class SiteController extends Controller
{
    //
/*
    protected $m_rep;
    protected $a_rep;
    protected $s_rep;
    protected $f_rep;

    protected $temlate;

    protected $vars = array();

    public function __construct(){
        
    }

    protected function renderOutput($idURL = ['id' => 0, 'url' => '']){
        $menu = $this->getMenu($this->m_rep, 'MyNav', $idURL['id'], $idURL['url']);
        //dd($menu->items);

        $nav = view(env('THEME').'.nav')->with('menu',$menu)->render();

        $this->vars = array_add($this->vars,'nav',$nav);
        //dd(view($this->template)->with($this->vars));
        return view($this->template)->with($this->vars);
    }
*/
    protected function getMenu($name, $menu, $menu2 = null, $url = ''){

        $mBuilder = Menu::make($name, function($m) use($menu, $menu2, $url){

            foreach($menu as $item){
                $m->add($item->name, $url . $item->path);
            }
            
            if($menu2){
                foreach($menu2 as $item){
                    $page = Page::findOrFail($item->page_id);
                    $m->add($item->name, $page->path . '/' . $item->path);
                }
            }
        });
        return $mBuilder;
    }

    protected function navBack($page){

        $pages = Page::all();
        $m = [];
        $i = 0;
        while (true){
            if($page->page_id){
                $page = $pages->where('id', '=', $page->page_id)->first();
                $m[$i] = new \stdClass();
                $m[$i]->name = $page->name;
                $m[$i]->path = $page->path;
            }
            else{
                $m[$i] = new \stdClass();
                $m[$i]->name = \Lang::get('messages.main');
                $m[$i]->path = '';
                break;
            }
            $i += 1;
        }
        return $m;
    }

    protected function nav_back_up($nav, $url = ''){

        $st = '';
        foreach ($nav as $item){
            $st .= "<a href=\"/$url$item->path\">$item->name</a>->";
        }
        return $st;
    }

}
