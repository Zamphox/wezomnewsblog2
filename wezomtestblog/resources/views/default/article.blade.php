@extends('default.layouts.layout')
<title>{{ $article->name }}</title>
@section('header')
@include('default.header')
@endsection
@section('sidebar')
@include('default.sidebar')
@endsection


@section('content')
      <div class="col-md-10">

        @if(session('message'))
          <div class='alert alert-success row'>
            {{ session('message') }}
          </div>
        @endif

        @if($errors->has('text'))
            <div class='alert alert-danger row'>
              Запрещенные символы. Комментарий не добавлен.
          </div>
        @endif
        <div style="background: #e9ecef; border-radius: 10px; padding: 10 0 10 1" class="row">
        <div class="col-md-12">
          <div style="padding-bottom: 5px">
          <h5 class="text-center">{{ $article->name }}</h5>
          <img class="mx-auto d-block" style="width:90%; max-width: 850px; max-height: 500px; min-height: 200px" src="{{ asset('storage/images/'.$article->img) }}" alt="{{ asset('storage/images/'.$article->img) }}"><br>
          {!! nl2br(e($article->text)) !!}

          <div class="row" style="padding-top: 15px">
            <div class='col-md-6'>

				<a class="btn btn-secondary btn-sm" href="/category/{{ $article->category }}" role="button">{{ $article->category }}</a>
            @foreach($article->tags as $tag)
              <a class="btn btn-outline-dark btn-sm" href="/tag/{{ $tag['name'] }}" role="button">{{ $tag->name }}</a>
            @endforeach
            </div>
            <p class="col-md-3">{{ $article->created_at }}</p>
          @if(Auth::check() AND Auth::user()->has_admin_rights)
          <div class="col-md-3">
          <a class="btn btn-sm btn-info" style='padding-right: 10px' href="/article/{{ $article->id }}/{{ $article->name }}/edit">Редактировать</a>
          <a class="btn btn-sm btn-danger" href="/article/{{ $article->id }}/{{ $article->id }}/delete">Удалить</a>
          </div>
          </div>

		    @endif
        </div>
        <hr>

        <div>
        @if($comments->isEmpty())
          <p style="padding: 10px; margin: 10 0 10 0" class="well well-sm border bg-light rounded"> Комментариев нет</p>
        @else
          @foreach($comments as $comment)
              <div style="padding: 10 10 0 10; margin: 10 0 10 0" class="well well-sm border bg-light rounded">
                <div class="row">
                <div style="padding: 0 0 0 20" class="col-md-8">
                  <a style="background: #d1d1d1" class="badge badge-pill badge-secondary">{{ $comment->name }}</a> Создано: <p style="background: #f9f5c0" class="badge badge-pill badge-warning">{{ $comment->created_at }}</p>
                </div>

                  @if(Auth::check() AND Auth::user()->has_admin_rights)
                    <div style='padding: 0 20 0 0' align="right" class="col-md-4">
                    <a class="badge badge-pill badge-info" style='padding-right: 10px' href="/article/edit/comment/{{ $comment->id }}">Редактировать</a>
                    <a class="badge badge-pill badge-danger" href="/article/delete/comment/{{ $comment->id }}">Удалить</a>
                    </div>
                  @endif

                </div>
                <hr style="margin: 0">
                  <p style="padding: 10 0 0 10">{{ $comment->comment }}</p>

              </div>
       	 @endforeach
        		{{ $comments->links() }}
		@endif
        </div>
		@if(Auth::check())
       <div style="border-radius: 10px" class="well well-sm border bg-light">
          <form class="form-horizontal" action="/article/{{ $article->id }}/{{ $article->name }}" method="post">
            @csrf
          <fieldset>

            <div style="padding: 10px">
              <label class="col-md-3 control-label" for="text">Оставить комментарий</label>
                <textarea class="form-control {{ $errors->has('text') ? ' is-invalid' : '' }}" id="text" name="text" rows="4">{{ old('text') }}</textarea>
                @if ($errors->has('text'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('text') }}</strong>
                    </span>
                @endif
            </div>
            <div style="padding: 0 10 0 0">
              <div style="padding-right: 10px" class="text-right">
                <button  type="submit" class="btn btn-dark btn-md">Создать</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
		@else
			<p style="padding: 10px; margin: 10 0 10 0" class="well well-sm border bg-light rounded">Чтобы оставить комментарий необходимо
				<a href="{{ route('login') }}">войти</a></p>
		@endif
        </div>
         </div>
         <br><br><br>
@endsection