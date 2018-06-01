@extends('default.layouts.layout')
<title>Главная</title>
@section('navbar')
	@parent
@endsection

@section('header')
	@include('default.header')
@endsection

@section('sidebar')
	@include('default.sidebar')
@endsection

@section('content')
	@include('default.content')
 @endsection