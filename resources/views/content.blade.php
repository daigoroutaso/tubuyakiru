@extends('layouts.app')

@section('twitter-card')
<meta name="twitter:card" content="summary_large_image"></meta>
<meta property="og:url" content="http://tubuyakiru.com/" />
<meta property="og:title" content="麻雀つぶや切る" />
<meta property="og:description" content="サクッと何切るを作って画像付きツイートできる麻雀ツールサービスです。" />
<meta property="og:image" content="http://tubuyakiru.com/storage/twitter-card/{{$contents[0]->id}}.png" />
@endsection

@section('content')
<div class="container-fluid bg-primary">

    <div class="row justify-content-center">
        <div class="sns-area">
            <a href="https://twitter.com/intent/tweet?text=東○局 △巡目 □家 &url=http://tubuyakiru.com/{{$contents[0]->id}} &hashtags=つぶや切る,麻雀,何切る問題" rel=”nofollow” onClick="window.open(encodeURI(decodeURI(this.href)),'twwindow','width=550, height=450, personalbar=0, toolbar=0, scrollbars=1'); return false;"><i class="fab fa-twitter fa-2x "></i></i></a>
            <url-copy-component></url-copy-component>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="pai-container">
            @for ($i = 0; $i < strlen($contents[0]->pais); $i = $i + 2)
                <div class="pai-item">
                    <img src="{{ asset('img/'.substr($contents[0]->pais,$i,2).'.gif')}}" alt="">
                </div>
            @endfor
            @if( $contents[0]->tumo !== '' )
                <div class="pai-item ml-2">
                    <img src="{{ asset('img/'.$contents[0]->tumo.'.gif')}}" alt="">
                    <p>ツモ</p>
                </div>
            @endif
            @if( $contents[0]->dora !== '' )
                <div class="pai-item ml-2">
                    <img src="{{ asset('img/'.$contents[0]->dora.'.gif')}}" alt="">
                    <p>ドラ</p>
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <poll-component v-bind:content="{{ $contents[0] }} "></poll-component>
    </div> 
</div>

@endsection
