<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Repositories\MenusRepository;

use Menu;

class AdminController extends \App\Http\Controllers\SiteController
{
    //


    public function __construct(){
        $this->middleware('auth');
    }


}
