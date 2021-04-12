@extends('layouts.app')

@section('twitter-card')
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
        <img src="{{ asset('img/top.png') }}" class="img-thumbnail rounded-circle" width=30% alt="">
    </div>

    <div class="row justify-content-center">
        <p class="lead sub-title text-light">5秒で何切るを作ってSNSで共有しよう！</p>
    </div>

    <mahjong-input-component  :csrf="{{json_encode(csrf_token())}}"></mahjong-input-component>    

</div>


@endsection
