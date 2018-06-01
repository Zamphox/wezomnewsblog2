<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\User;
use Auth;
use App\Article;
use App\Common;

class CommentsController extends Controller
{
    //
    public function create(Request $request, $id){
    	$this->validate($request, [
    		'text'=>'required|max:2000|regex:/^[\p{L}\p{N}\s!–’#№%&*)(-=+"?]+$/u'
    	]);

    	$article = Article::find($id);

    	$comment = $article->comments()->create([
    		'name' => Auth::user()->name,
    		'comment' => $request['text'],
    		'article_id' => $id,
    	]);
    	$comment->article()->associate($comment->id);

    	return redirect()->back()->with('message', 'Комментарий добавлен');
    }

    public function show_edit($id){

    	$comment = Comment::find($id);
    	return view('default.edit_comment')->withComment($comment);
    }

    public function edit(Request $request, $id){

    	$comment = Comment::find($id);
		$article = $comment->article()->first();
    	$this->validate($request, [
    		'text'=>'required|max:2000|regex:/^[\p{L}\p{N}\s!#№%&*)(-=+"?]+$/u'
    	]);

    	$comment->comment = $request['text'];
    	$comment->save();

    	return redirect('/article/'.$comment->article_id.'/'. Common::translit($article->name))->with('message', 'Комментарий с id: '.$id. ' успешно редактирован');
    }

    public function delete($id){

    	$comment = Comment::find($id);
    	$comment->delete();

    	return redirect()->back()->with('message', 'Комментарий с id: '.$id. ' удален');
    }
}