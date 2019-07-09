<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use App\Page;

use Menu;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        
        if($this->isHttpException($exception)){
            $statusCode = $exception->getStatusCode();
            switch ($statusCode) {
                case '404':
                    $nav = Page::where('page_id', '=', 0)->orderBy('priority', 'ASC')->get();

                    $nav = $this->getMenu('nav', $nav);

                    return response()->view('errors.404', compact('nav'));
                
            }
        }
        return parent::render($request, $exception);
    }

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

}
