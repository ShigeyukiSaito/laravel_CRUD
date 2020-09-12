<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    /*
    public function index() {
        
    }
    */
    public function create(Request $request) {
        /*
        //すでに登録されている場合は、jsで「すでにアカウントが存在しています」を表示する。 
        //すでにメールアドレスが登録されている場合 
        if ($request->$email != null) {
            return
        }
        //すでにニックネームが登録されている場合
        if ($request->$nickname) {
            return
        }
        */
        
        //モデルを用いたDB追加
        $user = new User;
        
        $user->nickname = $request->nickname;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
        return view('user', compact('user'));
/*
        //Qiitaのサイト見て
        $nickname = $request->input('nickname');
        $email = $request->input('email');
        $password = $request->input('password');

        //DBへデータ追加
        //Laravelドキュメント見て作成。idはauto_inclementだから自動で追加される。
        DB::insert('insert into users (nickname, email, password) values (?, ?, ?)', [$nickname, $email, $password]);
*/
        //return view('user', compact('nickname', 'email', 'password'));

        /*
        //上の各変数は以下のように一括してuserページに渡すことも可能。
        $user_data = $request->all();
        return view('user', compact('user_data'));

        //userページで使う際は以下のように
        {{$user_data['nickname']}}
        */
    }

    public function password_reset() {
        return view('password_reset');
    }
}
