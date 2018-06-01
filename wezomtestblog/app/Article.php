<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['name','img','text','source', 'tag', 'article_id', 'category'];

    public function user(){
	return $this->belongsTo('App\User');
}

    public function tags(){
    	return $this->belongsToMany('App\Tag');
    }

    public function comments(){
    	return $this->hasMany('App\Comment');
    }

	public function category(){
    	return $this->belongsTo('App\Category');
    }
}