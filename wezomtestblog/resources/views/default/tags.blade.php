@extends('default.layouts.layout')
<title>{{ $header_info['title'] }}</title>
@section('header')
@include('default.header')
@endsection
@section('sidebar')
@include('default.sidebar')
@endsection

@section('content')
      <div class="col-md-10">
        <div class="row">
        <div class="col-md-12">
          @foreach($tags as $tag)
          	@if($tag['count'] < 1)
          	@else
            <a class="btn btn-sm btn-outline-dark" href="/tag/{{ $tag['name'] }}">{{ $tag['name'].' ['.$tag['count'].']' }}</a>			
            @endif
          @endforeach
        </div>
         </div>
@endsection