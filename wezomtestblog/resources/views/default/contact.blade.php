@extends('default.layouts.layout')
<title>Контакты</title>
@section('header')
@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
<div class="col-md-8 jumbotron" style="margin-top: 75px">
        @if(session('success'))
        <h3 class="alert alert-success text-center">{{session('success')}}</h3>
        @endif

		@if(session('failed'))
          <h3 class="alert alert-danger text-center">{{session('failed')}}</h3>
        @endif

	<div class="well well-sm">
          <form class="form-horizontal" action="{{ route('contact') }}" method="post">
          	@csrf
          <fieldset>
            <legend class="text-center">Форма для связи</legend>
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Имя</label>
              <div class="col-md-12">
                <input id="name" name="name" value='{{ old('name') }}' type="text" placeholder="Фамилия Имя Отчество" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
              </div>
            </div>

            <div class="row">
            <div class="form-group col-md-6">
              <label class="col-md-6 control-label" for="phone">Телефон</label>
              <div class="col-md-12">
                <input id="phone" name="phone" value='{{ old('phone') }}' type="tel" placeholder="+380991234567" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">
                @if ($errors->has('phone'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
              </div>
            </div>

            <div class="form-group col-md-6">
              <label class="col-md-6 control-label" for="email">E-mail</label>
              <div class="col-md-12">
                <input id="email" name="email" value='{{ old('email') }}' type="text" placeholder="Ваш email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="message">Сообщение</label>
              <div class="col-md-12">
                <textarea class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" id="message" name="message" placeholder="Ваше сообщение..." rows="5">{{ old('message') }}</textarea>
                @if ($errors->has('message'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('message') }}</strong>
                    </span>
                @endif
              </div>
            </div>

            <div class="form-group row container">

				<div class="g-recaptcha col-md-6 " style='transform:scale(0.80)' data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>

				<div class="col-md-6 text-right">
                <button type="submit" class="btn btn-primary btn-lg" style='padding: 13px;margin-top:9px'>Отправить</button>
              </div>



            </div>
          </fieldset>
          </form>
        </div>
</div>
</div>
</div>
@endsection