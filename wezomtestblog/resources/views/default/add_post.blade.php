@extends('default.layouts.layout')
<title>Добавить пост</title>
@section('header')
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
<div class="col-md-8" style="margin-top: 75px">
@if(session('id'))
          <div class='alert alert-success row'>
            <p>Новый пост с id: {{ session('id') }} создан.</p>
            <a class="float-right" href="article/{{ session('id') }}/{{ session('name') }}">Перейти к посту.</a>
          </div>
@endif
	<div class="well well-sm">
          <form class="form-horizontal jumbotron" action="{{ route('admin_post') }}" method="post" enctype="multipart/form-data">
          	@csrf
          <fieldset>
            <legend class="text-center">Добавить новый пост</legend>

            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Заголовок</label>
                <input id="name" name="name" value='{{ old('name') }}' type="text" placeholder="Заголовок" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="img">Изображение</label>
                <input id="img" name="img" value='{{ old('img') }}' type="file" placeholder="Изображение" class="form-control {{ $errors->has('img') ? ' is-invalid' : '' }}">
                @if ($errors->has('img'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('img') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="text">Текст</label>
                <textarea class="form-control {{ $errors->has('text') ? ' is-invalid' : '' }}" id="text" name="text" placeholder="Описание поста" rows="4">{{ old('text') }}</textarea>
                @if ($errors->has('text'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('text') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group container">
				<div class="row">
					<label class="control-label col-md-3" for="category">Категория</label>
					<label class="col-md-9 ml-auto control-label" for="tags">Тэги (через запятую, максимум 5)</label>
				</div>
				<div class="row">
					<select class="col-md-3 form-control" name="category" id="category">
					  <option>Разное</option>
					  <option>Спорт</option>
					  <option>Политика</option>
					  <option>Економика</option>
					  <option>Технологии</option>
					</select>

                <input id="tags" name="tags" value='{{ old('tags') }}' type="text" placeholder="Культура, Технологии, и тд" class="col-md-9 ml-auto form-control {{ $errors->has('tags') ? ' is-invalid' : '' }}">
                @if ($errors->has('tags'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('tags') }}</strong>
                    </span>
                @endif
            </div>
			  </div>

             <div class="form-group">
              <label class="col-md-3 control-label" for="source">Источник</label>
                <input id="source" name="source" value='{{ old('source') }}' type="text" placeholder="Например ссылка. Можно оставить пустым" class="form-control {{ $errors->has('source') ? ' is-invalid' : '' }}">
              @if ($errors->has('source'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('source') }}</strong>
                    </span>
              @endif
            </div>

            <div class="form-group">
              <div class="text-right">
                <button type="submit" class="btn btn-primary btn-lg">Создать</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
</div>
</div>
</div>
@endsection