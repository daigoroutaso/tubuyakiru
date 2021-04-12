<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
//use Carbon\Carbon;
//use App\Library\Common;
use Auth;
//use Abraham\TwitterOAuth\TwitterOAuth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    /*
        $user = Auth::user();

        //インスタンス生成
        if($user){
            $twitter = new TwitterOAuth(
                env('TWITTER_CLIENT_ID'),
                env('TWITTER_CLIENT_SECRET'),  //自分のAPI Key,API Secret
                $user->token,
                $user->token_secret  //ログイン者のアクセストークン
            );       
            
            $timelines = $twitter->get('statuses/home_timeline',[
                    'count' => 200,             //200件取得
                    'exclude_replies' => 'true'  //リプライは除く
            ]);
            
            //タイムライン取得    
            foreach($timelines as $timeline){ //fruitsの先頭から１つずつ$fruitに代入する
                Log::Debug($timeline->text);
            }

        }
    */

}
