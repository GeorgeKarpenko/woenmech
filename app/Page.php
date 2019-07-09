<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'enName', 'img', 'imgText', 'enImgText', 'path', 'text', 'enText', 'page_id', 'imgLeft', 'imgRight', 'status', 'author', 'enAuthor', 'audio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function users(){
        return $this->belongsToMany('App\User', 'authors');
    }

}
