<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Common;
use App\Comment;
use App\Category;

class ArticleController extends Controller
{
    //
    public function show($id){

    	$article = Article::find($id);
    	if(!$article){
    	$header_info = ['title'=>'Ошибка','description'=>'Данной новости не существует'];
    	return view('default.doesnt_exist')->with(['header_info'=>$header_info]);
    	}
    	$article->source ? : $article->source = 'Не указан';
    	$header_info = ['title'=>'Источник:','description'=>$article->source];
		$category = Category::where('id', '=', $article->category_id)->get();
        $comments = Comment::where('article_id', '=', $article->id)->orderBy('created_at','asc')->paginate(15);
    	return view('default.article')->with(['article'=>$article, 'header_info'=>$header_info, 'comments'=>$comments, 'category'=>$category]);
    }
}