<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

use App\Repositories\ArticlesRepository;

use Menu;

use App\Page;

class SearchController extends SiteController
{
    //

    public function __construct(){

        
    }

    public function index(){
        $nav = Page::where('page_id', '=' , 0)->where('status', '!=' , 4)->orderBy('priority', 'ASC')->get();
        $nav = $this->getMenu('nav', $nav);

        $search = Input::get('query');

        $max_page = 24;
        //Полнотекстовый поиск с пагинацией
        $articles = $this->search($search, $max_page);
/*
        for ($i=0; $i < count($articles) - 1; $i++) { 
            $articles[$i]->text = explode("</p>", strip_tags($articles[$i]->text, '<p>'))[0] . '</p>';
        }*/
        //$articles = Page::whereRaw("MATCH(name,text) AGAINST(? IN BOOLEAN MODE)", $search)->get();

        return view('search', compact('articles', 'search', 'nav'));
    }


    /**
     * Полнотекстовый поиск.
     *
     * @param string $q Строка содержащая поисковый запрос. Может быть несколько фраз разделенных пробелом.
     * @param integer $count Количество найденных результатов выводимых на одной странице (для пагинации)
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function search($q, $count){
        $query = mb_strtolower($q, 'UTF-8');
        $arr = explode(" ", $query); //разбивает строку на массив по разделителю
        /*
         * Для каждого элемента массива (или только для одного) добавляет в конце звездочку,
         * что позволяет включить в поиск слова с любым окончанием.
         * Длинные фразы, функция mb_substr() обрезает на 1-3 символа.
         */
        $query = [];
        foreach ($arr as $word)
        {
            $len = mb_strlen($word, 'UTF-8');
            switch (true)
            {
                case ($len <= 3):
                {
                    $query[] = $word . "*";
                    break;
                }
                case ($len > 3 && $len <= 6):
                {
                    $query[] = mb_substr($word, 0, -1, 'UTF-8') . "*";
                    break;
                }
                case ($len > 6 && $len <= 9):
                {
                    $query[] = mb_substr($word, 0, -2, 'UTF-8') . "*";
                    break;
                }
                case ($len > 9):
                {
                    $query[] = mb_substr($word, 0, -3, 'UTF-8') . "*";
                    break;
                }
                default:
                {
                    break;
                }
            }
        }
        $query = array_unique($query, SORT_STRING);
        $qQeury = implode(" ", $query); //объединяет массив в строку
        // Таблица для поиска
        $results = Page::where('status', '=' , 4)->whereRaw(
            "MATCH(name,text) AGAINST(? IN BOOLEAN MODE)", // name,email - поля, по которым нужно искать
            $qQeury)->paginate($count) ;
        $ids = $results->where('status', '=' , 4)->pluck('page_id')->toArray();
        $pages = Page::find($ids);
        for ($i=0; $i < count($results); $i++) {
            foreach ($pages as $page) {
                if ($page->id == $results[$i]->page_id) {
                    $results[$i]->path = $page->path . '/' . $results[$i]->path;
                    break;
                }
            }
        }
        return $results;
    }

}
