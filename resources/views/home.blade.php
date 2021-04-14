@extends('layouts.app')

@section('twitter-card')
<meta name="twitter:card" content="summary"></meta>
<meta property="og:url" content="http://tubuyakiru.com/" />
<meta property="og:title" content="麻雀つぶや切る" />
<meta property="og:description" content="５秒で何切る問題を作ってURLを画像付きツイートできる麻雀学習ツールサービスです。" />
<meta property="og:image" content="http://tubuyakiru.com/img/twitter-card-home.png" />
@endsection

@section('content')

{{--スマホサイズに固定--}}
<div class="container-fluid bg-primary">

    {{--タイトル--}}
    <div class="row justify-content-center">
        <h4 class="main-title text-light">麻雀つぶや切る</h4>
    </div>

    {{--トップ絵--}}
    <div class="row justify-content-center">
        <div class="col-4">
            <img src="{{ asset('img/top.png') }}" class="img-thumbnail rounded-circle img-fluid" alt="">
        </div>
    </div>

    <div class="row justify-content-center px-4">
        <p class="lead sub-title text-light text-center">５秒で何切るを作ってつぶやこう！</p>
    </div>

    <mahjong-input-component  :csrf="{{json_encode(csrf_token())}}"></mahjong-input-component>    

</div>


@endsection
