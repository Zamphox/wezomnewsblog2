<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Common;
use App\Category;
use App\Article;

class TagController extends Controller
{
    //
    public function showTags(){

    	$tags = Tag::all();
    	$header_info = ['title'=>'Тэги','description'=>'"Ctrl+F" для поиска'];
    	foreach($tags as $tag){
    		$tag->count = Common::getPopularity($tag->id);
    	}
        $tags = $tags->sortByDesc('count');
    	return view('default.tags')->with(['tags'=>$tags, 'header_info'=>$header_info]);
    }

    public function showTag($tag){

    	$tagSelect = Tag::where('name', '=', $tag)->first();
    	$header_info = ['title'=>$tag,'description'=>'<br>'];
    	if(!$tagSelect){
    	$header_info = ['title'=>$tag,'description'=>'Новостей с тэгом '.$tag.' не найдено'];
    	return view('default.doesnt_exist')->with(['header_info'=>$header_info]);
    	}
    	$articles = $tagSelect->articles()->orderBy('created_at','desc')->paginate(5);

        foreach($articles as $article){
            $article_words = explode(' ', $article->text);
            $first_words = array_slice($article_words, 0, 25);
            $text_short = implode(' ', $first_words) . ' ...';
            $article->text_short = $text_short;
			$article->name_translit = Common::translit($article->name);
        }

    	return view('default.tag')->with(['articles'=>$articles, 'header_info'=>$header_info]);
    }

	 public function showCategory($category){

		$articles = Article::where('category', '=', $category)->orderBy('created_at','desc')->paginate(5);
    	$header_info = ['title'=>$category,'description'=>'<br>'];
    	if(!$articles){
    	$header_info = ['title'=>$category,'description'=>'Раздел '.$category.' не найден'];
    	return view('default.doesnt_exist')->with(['header_info'=>$header_info]);
    	}

        foreach($articles as $article){
            $article_words = explode(' ', $article->text);
            $first_words = array_slice($article_words, 0, 25);
            $text_short = implode(' ', $first_words) . ' ...';
            $article->text_short = $text_short;
			$article->name_translit = Common::translit($article->name);
        }

    	return view('default.tag')->with(['articles'=>$articles, 'header_info'=>$header_info]);
    }
}