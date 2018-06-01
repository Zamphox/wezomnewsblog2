@extends('default.layouts.layout')
<title>Редактирование комментария</title>
@section('header')
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
<div class="col-md-8" style="margin-top: 75px">
  @if(session('message'))
          <div class='alert alert-success row'>
            {{ session('message') }}
          </div>
@endif
	<div class="well well-sm">
          <form class="form-horizontal jumbotron" action="/article/edit/comment/{{ $comment->id }}" method="post">
          	@csrf
          <fieldset>
            <legend class="text-center">Редактировать комментарий с id: {{ $comment->id }}</legend>


            <div class="form-group">
              <label class="col-md-3 control-label" for="text">Текст</label>
                <textarea class="form-control {{ $errors->has('text') ? ' is-invalid' : '' }}" id="text" name="text" placeholder="Описание поста" rows="4">{{ $errors->has('text') ? old('text') : $comment->comment}}</textarea>
                @if ($errors->has('text'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('text') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
              <div class="text-right">
                <button type="submit" class="btn btn-primary btn-lg">Редактировать</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
</div>
</div>
</div>
@endsection