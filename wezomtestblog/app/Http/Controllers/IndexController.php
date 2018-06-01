<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Common;

class IndexController extends Controller
{
    //
    public function show(){
    	$articles = Article::orderBy('created_at','desc')->paginate(5);
    	foreach($articles as $article){
    		$article_words = explode(' ', $article->text);
    		$first_words = array_slice($article_words, 0, 25);
    		$text_short = implode(' ', $first_words) . ' ...';
    		$article->text_short = $text_short;
			$article->name_translit = Common::translit($article->name);
    	}
    	$header_info = ['title'=>'Главная','description'=>'Добро пожаловать на главную страницу сайта'];
    	return view('default.index')->with(['articles'=>$articles, 'header_info'=>$header_info]);
    }
}