<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>

  <body>

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ route('home') }}">Новостной блог</a>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="{{ route('home') }}">Домой</a>
      <a class="nav-item nav-link" href="{{ route('about') }}">О проекте</a>
      <a class="nav-item nav-link" href="{{ route('contact') }}">Контакты</a>
      <a class="nav-item nav-link" href="{{ route('tags') }}">Тэги</a>
    </div>

    @if(!Auth::check())
    <div class='navbar-nav ml-auto'>
      <a class="nav-item nav-link" href="{{ route('login') }}">Логин</a>
      <a class="nav-item nav-link" href="{{ route('register') }}">Регистрация</a>
    </div>
    @else
    <div class='navbar-nav ml-auto'>
      @if(Auth::user()->has_admin_rights)
      <a class="nav-item nav-link" href="{{ route('admin') }}">Создать пост</a>
      @endif
      <a class="nav-item nav-link">{{ Auth::user()->name }}</a>
      <a class="nav-item nav-link" href="{{ url('/logout') }}">Выйти</a>
    </div>
    @endif
  </div>
</nav>
@show

    @yield('header')
    @yield('sidebar')

</div>
  @yield('content')
      </div>

      <hr>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js?hl=ru'></script>
  </body>
</html>