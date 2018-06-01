<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


use App\Article;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Common;
use App\Tag;
use Validator;
use App\Category;
class AdminController extends Controller
{
    //
    public function show(Request $request){
    	return view('default.add_post');
    }

	public function show_image($filename){
    	$file = Storage::get('images/'.$filename);
		return $file;
    }

    public function create(Request $request){

    	$validate = Validator::make($request->all(),[
    		'name'=>'required|max:100|regex:/^[\p{L}\p{N}\s!$"’?)(-»«–]+$/u',
    		'img'=>'required|image',
    		'text'=>'required|max:5000|regex:/^[\p{L}\p{N}\s\V!@#№%&*)(-=+"?’»–«,\.]+$/u',
    		'source'=>[
    			'nullable',
    			'max:250',
    			'regex:/^$|^[\p{L}\p{N}\s!@#№%&*)(-=+"?\/\:_]+$/u'
    					],
    		'tags'=>'required|max:250|regex:/^[\p{L}\p{N}\s-?’,_\^]+$/u'
    	]);

    	$data = $request->all();
    	$user = Auth::user();
    	$tags = explode(',',str_replace(' ', '', $data['tags']));

    	if($validate->fails()){
    		if(count($tags) > 5){
    			$validate->getMessageBag()->add('tags', 'Максимум 5 тэгов');
    	}
    		return redirect()->back()->withInput()->withErrors($validate);
    	}

    	if(count($tags) > 5){
    		$validate->getMessageBag()->add('tags', 'Максимум 5 тэгов');
    		return redirect()->back()->withInput()->withErrors($validate);
    	}

    	filter_var($data['source'], FILTER_VALIDATE_URL) ?
    				$data['source'] = "<a href='".$data['source']."'>".$data['source']."</a>"
    			:	'';

    	$image = $request->file('img');

    	$new_name = strftime('_%d-%m-%y_%H_%M_%S.').$image->getClientOriginalExtension();
    	//Storage::disk('public')->put($new_name, $image);
		$request->file('img')->storeAs('images', $new_name);
    //Storage::putFileAs('images', $request->file('imd'), $new_name);
		//Storage::putFileAs('images', $image, $new_name);
		//Storage::disk('local')->put('images/'.$new_name, $image);

		$category = Category::where('name', '=', $data['category'])->first();

    	$res = $user->articles()->create([
    		'name'=>$data['name'],
    		'text'=>$data['text'],
    		'img'=>$new_name,
    		'source'=>$data['source'],
			'category' => $category->name,
    	]);


		$res->category()->associate($res);

    	foreach($tags as $tag){
			if(Tag::where('name', '=', $tag)->exists()){
				$old_tag = Tag::where('name', '=', $tag)->first();
				$res->tags()->sync($old_tag->id, false);
			}else{
    		$new_tag = new Tag;
    		$new_tag->name = $tag;
    		$new_tag->save();
    		$res->tags()->sync($new_tag->id, false);
    		}
    	}
    	return redirect()->back()->with(['id'=> $res['id'], 'name'=>Common::translit($res['name']) ]);
    }

    public function show_edit($id){
    	$article = Article::find($id);
		$tags = $article->tags()->get();
		$tagsArray = array();
		foreach($tags as $tag){
			$tagsArray[] = $tag->name;
		}
		$tagstring = implode(',',$tagsArray);
		$source = strip_tags($article->source);
    	return view('default.edit_post')->with(['article'=>$article, 'tagstring'=>$tagstring, 'source'=>$source]);
    }

    public function edit(Request $request,$id){

    	$validate = Validator::make($request->all(),[
    		'name'=>[
    				'max:100',
    				'nullable',
    				'regex:/^$|^[\p{L}\p{N}\s!$?)(-»"–«]+$/u'
    				],
    		'img'=>'image|nullable',
    		'text'=>[
    				'nullable',
					'max:5000',
    				'regex:/^$|^[\p{L}\p{N}\s\V!@#№%&*)(-–’=+"?»«,\.]+$/u'
    				],
    		'source'=>[
    			'nullable',
    			'max:250',
    			'regex:/^$|^[\p{L}\p{N}\s!@#№%&*)(-=+"?\/\:_]+$/u'
    					],
    		'tags'=>[
    			'nullable',
    			'max:250',
    			'regex:/^$|^[\p{L}\p{N}\s-?’_,\^]+$/u'
    				]
    	]);

    	$data = $request->all();
    	$article = Article::find($id);
    	$user = Auth::user();

    	if($validate->fails()){
    		if(count($data['tags']) > 5){
    			$validate->getMessageBag()->add('tags', 'Максимум 5 тэгов');
    	}
    		return redirect()->back()->withInput()->withErrors($validate);
    	}

    	empty($data['name']) ? $data['name'] = $article->name : '';
    	empty($data['text']) ? $data['text'] = $article->text : '';
    	empty($data['source']) ? $data['source'] = $article->source : '';
    	empty($data['tags']) ? '' : $data['tags'] = explode(',',str_replace(' ', '', $data['tags']));

        // dd($data['tags']);
    	if(!empty($data['img'])){
	    	$image = $request->file('img');
	    	$new_name = strftime('_%d-%m-%y_%H_%M_%S.').$image->getClientOriginalExtension();
	    	Storage::putFileAs('images', $image, $new_name);
	    	Storage::delete('images/'.$article->img);
	    	$article->img = $new_name;
	    	$article->save();
    	}

    	filter_var($data['source'], FILTER_VALIDATE_URL) ?
			$data['source'] = "<a href='".$data['source']."'>".$data['source']."</a>"
		:	'';

		$category = Category::where('name', '=', $data['category'])->first();

    	$article->update([
    		'name'=>$data['name'],
    		'text'=>$data['text'],
    		'source'=>$data['source'],
			'category' => $category->name
    	]);


		$article->category()->dissociate();
		$article->category()->associate($article);

        if(!empty($data['tags'])){
        	$article->tags()->detach();

        	foreach($data['tags'] as $tag){

        		if(Tag::where('name', '=', $tag)->exists()){
    				$old_tag = Tag::where('name', '=', $tag)->first();
    				$article->tags()->sync($old_tag->id, false);
    			}else{
        		$new_tag = new Tag;
        		$new_tag->name = $tag;
        		$new_tag->save();
        		$article->tags()->sync($new_tag->id, false);
        		}
            }
    	}

    	return redirect('/article/'.$article->id.'/'.$article->name)->with(['message'=>'Пост с id: '.$article->id. ' успешно редактирован.', 'article'=>$article]);
    }

    public function delete($id){

    	$article = Article::find($id);
        $tags = $article->tags()->get();
    	$article->tags()->detach();
        $article->comments()->delete();
		$article->category()->dissociate();
        foreach($tags as $tag){
                if(Common::getPopularity($tag['id']) == 0){
                    $db_tag = Tag::find($tag['id']);
                    $db_tag->delete();
                }
            }
        $article->delete();

    	return redirect('/')->with('message', 'Пост с id: '.$id. ' удален');
    }
}