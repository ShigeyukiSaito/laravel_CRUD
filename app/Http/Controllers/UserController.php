<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index() {

    }
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

        //DBにあるデータとの照合
        $credentials = $request->only('nickname', 'email', 'password');
        /*$request->nickname*/
        /*
        if (Auth::attempt(['nickname' => $request->nickname , 'password' => $request->password])) {
            //このニックネームはすでに使用されています。
            return redirect('/signup');//->with('authentificated', false);
        }
        else if (Auth::attempt(['email' => $request->email , 'password' => $request->password])) {
            //このメールアドレスはすでに使用されています。
            return redirect('/signup');//->with('authentificated', false);
        }
        */
        $user_check_byNickname = User::where('nickname', $request->nickname)->first();//DB::table('users')->where('nickname', $request->nickname)->first()でも良い;
        $user_check_byEmail = User::where('email', $request->email)->first();
        
        if($user_check_byNickname != null && $user_check_byNickname != null) {
            return back()->with(array('error_message' => "そのニックネームとメールアドレスはすでに使用されています。", 'authentificated' => false));
        }
        else if($user_check_byNickname != null) {
            return back()->with(array('error_message' => "そのニックネームはすでに使用されています。", 'authentificated' => false));
        }
        else if($user_check_byEmail != null) {
            return back()->with(array('error_message' => "そのメールアドレスはすでに使用されています。", 'authentificated' => false));
        }
        else {
            //モデルを用いたDB追加
            $user = new User;
            
            $user->nickname = $request->nickname;
            $user->email = $request->email;
            //パスワード暗号化しないと、ログインvalidationされない（通過してまう）
            //$user->password = $request->password;
            $user->password = Hash::make($request->password);
            //$user->user_id = $request->user()->id(); //この書き方謎
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
    }

    public function show(Request $request) {
        //DBにあるデータとの照合
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // 認証に成功した
            $user = Auth::user();
            return view('user', compact('user'));//redirect('/user');//->intended('dashboard');
        }
        return redirect('/signin')->with('authentificated', false);
        // ログイン処理
        //\Auth::login($user, true);
    }

    public function GoogleLogin(Request $request) {
        /*JSONリクエストを受ける
        $user = $request->all();
        $nickname = $request->input('data.nickname');
        $email = $request->input('data.email');
        //$password = $request->input('data.password');
        */
        $nickname = $request->nickname;
        $email = $request->email;
        //return $nickname; //これだとGoogleアカウントの名前が出る。

        //$user_check_byNickname = User::where('nickname', $nickname)->first();//DB::table('users')->where('nickname', $request->nickname)->first()でも良い;
        $user = User::where('email', $email)->first();
        //$user = array("nickname" => $nickname, "email" => $email);
        //return $user["nickname"];// これだと文字化けする
        /*
        return response()->json([
            'error_message' => 'Googleでの登録情報はありません。他の方法でログインをお試しください。',
            'authentificated' => false
        ]);
        */
        if($user != null) {
            // 認証に成功した
            //$user = Auth::user(); //上のif文でAuth::attempts使ってないのにいきなりここで使えんのか？
            return view('user', compact('user'));//redirect('/user');//->intended('dashboard');
        } else {
            return back()->with(array('error_message' => "Googleでの登録情報はありません。他の方法でログインをお試しください。", 'authentificated' => false));
        }
    }

    public function Logout() {
        Auth::logout();
        return view('welcome');
    }

    //これ、別のコントローラに写した方がよくね？
    public function password_reset() {
        return view('password_reset');
    }
    /*
        $nickname = $request->input('data.nickname');
        $email = $request->input('data.email');
        $password = $request->input('data.password');
        */
        /*
        //Googleログインの場合。パスワードが存在しない
        if($nickname == null) {
            $user_check_byNickname = User::where('nickname', $nickname)->first();//DB::table('users')->where('nickname', $request->nickname)->first()でも良い;
            $user_check_byEmail = User::where('email', $email)->first();

            if($user_check_byNickname != null && $user_check_byNickname != null) {
                // 認証に成功した
                $user = Auth::user();
                return view('user', compact('user'));//redirect('/user');//->intended('dashboard');
            } else {
                return back()->with(array('error_message' => "Googleでの登録情報はありません。他の方法でログインをお試しください。", 'authentificated' => false));
            }
        */
}
