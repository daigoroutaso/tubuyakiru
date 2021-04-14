<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Abraham\TwitterOAuth\TwitterOAuth;

use App\Models\User;
use App\Models\Content;
use App\Http\Controllers\ContentController;

use Log;
use File;

//
// コンテンツコントローラー 
//
class ContentController extends Controller
{

    //
    // コンテンツ表示
    //
    public function index($page_id){

        $contents  = Content::where('id',$page_id)->get();
        $users     = User::where('email',$contents[0]->user_id)->get();

        return view('content',compact('contents','users')); 

    }

    //
    // コンテンツ作成
    //
    public function create(Request $request){

        //判定用にreplace
        $input_pais = $request->input('input-pais');
        $input_pais = str_replace('ツモ','T',$input_pais);
        $input_pais = str_replace('ドラ','D',$input_pais);
        $input_pais = str_replace('東','1z',$input_pais);
        $input_pais = str_replace('南','2z',$input_pais);
        $input_pais = str_replace('西','3z',$input_pais);
        $input_pais = str_replace('北','4z',$input_pais);
        $input_pais = str_replace('白','5z',$input_pais);
        $input_pais = str_replace('發','6z',$input_pais);
        $input_pais = str_replace('中','7z',$input_pais);

        $mspz = '';
        $tumo = '';
        $dora = '';
        $pais = '';

        //テキストの反対側から取り出していく
        for($i = strlen($input_pais) - 1; $i >= 0; --$i){

            if(preg_match('/[mspz]/',$input_pais[$i])){

                $mspz = $input_pais[$i];

            }else if(preg_match('/[1-9]/',$input_pais[$i])){

                $pais = $input_pais[$i].$mspz.$pais;

            }else if(preg_match('/[T]/',$input_pais[$i])){

                $tumo = substr($pais,0,2);
                $pais = substr($pais,2);

            }else if(preg_match('/[D]/',$input_pais[$i])){

                $dora = substr($pais,0,2);
                $pais = substr($pais,2);
                
            }
        }

        //contentsレコード生成
        $newcontent = new Content;
        if(Auth::check()){
            $newcontent->user_id = Auth::user()->email;
        }else{
            $newcontent->user_id = '';
        }
        $newcontent->tumo = $tumo;
        $newcontent->dora = $dora;
        $newcontent->pais  = $pais;
        $newcontent->save();

        $page_id = $newcontent->id;

        //ツイッターカード情報作成
        $template_image = imagecreatefrompng('img/twitter-card-template.png');
        $imagesize = getimagesize('img/twitter-card-template.png');
        $template_w = $imagesize[0];
        $template_h = $imagesize[1];

        $ofset_x  = 20;
        $ofset_y  = 200;
        for($i = 0; $i < strlen($pais); $i += 2){

            $pai_image = imagecreatefromgif('img/'.substr($pais,$i,2).'.gif');
            $imagesize = getimagesize('img/'.substr($pais,$i,2).'.gif');
            $pai_w = $imagesize[0];
            $pai_h = $imagesize[1];

            imagecopyresampled($template_image,$pai_image,$ofset_x + $i / 2 * $pai_w, $ofset_y ,0,0,$pai_w,$pai_h,$pai_w,$pai_h);
        }
        $moji = imagecreatefrompng('img/moji.png');

        $ofset_xx = 10;
        if($tumo !== ''){
            $pai_image = imagecreatefromgif('img/'.$tumo.'.gif');
            $imagesize = getimagesize('img/'.$tumo.'.gif');
            $pai_w = $imagesize[0];
            $pai_h = $imagesize[1];
            imagecopyresampled($template_image,$pai_image,$ofset_x + $ofset_xx + 13 * $pai_w, $ofset_y ,0,0,$pai_w,$pai_h,$pai_w,$pai_h);    
            imagecopyresampled($template_image,$moji,635, 265,0,0, 50,25,50,25);
        }

        if($dora !== ''){
            $pai_image = imagecreatefromgif('img/'.$dora.'.gif');
            $imagesize = getimagesize('img/'.$dora.'.gif');
            $pai_w = $imagesize[0];
            $pai_h = $imagesize[1];
            imagecopyresampled($template_image,$pai_image,$ofset_x + ($ofset_xx * 2) + 14 * $pai_w, $ofset_y ,0,0,$pai_w,$pai_h,$pai_w,$pai_h);    
            imagecopyresampled($template_image,$moji,693, 265,0,27,50,25,50,25);    
        }

        imagepng($template_image, storage_path().'/app/public/twitter-card/'.$page_id.'.png');

        session()->flash('flash_message', '作成に成功しました！');

        return redirect()->action([ContentController::class,'index'], ['page_id' => $page_id]);

    }

    //
    // 投票する
    //
    public function poll(Request $request)
    {

        DB::table('contents')
         ->where('id', '=', $request->page_id)
         ->increment('vote_'.$request->select_idx);

        return 0;
    }

}
