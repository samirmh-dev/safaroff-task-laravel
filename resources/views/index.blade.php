@extends('layouts.master')

@section('elave-head')
    <title>{{$sehife['title']}}</title>
@endsection

@section('elave-css-file')
@endsection

@section('elave-css-style')
@endsection

@section('elave-js-file')
@endsection

@section('elave-js-script')
@endsection

@section('header')
    <header class="masthead" style="background-image: url('src/images/{{$sehife['sekil']}}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="site-heading">
                        <h1>{{$sehife['basliq']}}</h1>
                        <span class="subheading">{{$sehife['qisamezmun']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @foreach ($postlar as $post)
                    <div class="post-preview">
                        <a href="post/{{$post->link->link}}">
                            <h2 class="post-title">
                                {{ucfirst(mb_strtolower($post->title->title))}}
                            </h2>
                            <h3 class="post-subtitle">
                                {{ucfirst(mb_strtolower($post->title->title2))}}
                            </h3>
                        </a>
                        <p class="post-meta">Posted by
                            <a href="#">{{ucfirst(mb_strtolower($post->postu_yazan->name))}}</a>
                            on {{date('M j Y H:i', strtotime($post->created_at))}}</p>
                    </div>
                    <hr>
                @endforeach
                {{ $postlar->links() }}
            </div>
        </div>
    </div>
@endsection