@extends('default.layouts.layout')

@section('content')
<div class="col-md-9">
        @if($errors->any())
          <div class='alert alert-danger' style="padding-bottom: 0">
            <ul>
              @foreach($errors->all() as $error)  
                <li>{{ $error }}</li>             
              @endforeach
            </ul>
          </div>
        @endif

        @if(session('message'))
          <div class='alert alert-success'>
            {{ session('message') }}
          </div>
        @endif

        @can('update',$article)  {{-- @can and @cannot are basicly if(){} which works here --}}
        <h1>shit works</h1>       {{-- but only for policies pretty much --}}
        @endcan                   {{-- where ('method name',$ObjectYoureWorkingWith) --}}

	<div class="well well-sm">
          <form class="form-horizontal" action="{{ route('admin_update_post_p') }}" method="post">
          	@csrf          	
          <fieldset>
            <legend class="text-center">Редактировать пост c id: {{ $article->id }}</legend>
    
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Заголовок</label>
              <input type="hidden" name='id' value='{{ $article->id }}'>
              <div class="col-md-9">
                <input id="name" name="name" value='{{ $article->name }}' type="text" placeholder="Заголовок" class="form-control">
              </div>
            </div>
    
            <div class="form-group">
              <label class="col-md-3 control-label" for="img">Изображение</label>
              <div class="col-md-9">
                <input id="img" name="img" value='{{ $article->img }}' type="text" placeholder="Изображение" class="form-control">
              </div>
            </div>
    
            <!-- Message body -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="text">Текст</label>
              <div class="col-md-9">
                <textarea class="form-control" id="text" name="text" placeholder="Описание поста" rows="4">{{ $article->text }}</textarea>
              </div>
            </div>
    
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg">Отправить</button>
              </div>
            </div>
          </fieldset>
          </form>
        </div>
</div>
@endsection