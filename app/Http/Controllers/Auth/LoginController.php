<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //Googleログイン関連
    public function redirectToGoogle()
    {
        // Google へのリダイレクト
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // Google 認証後の処理
        // あとで処理を追加しますが、とりあえず dd() で取得するユーザー情報を確認
        $gUser = Socialite::driver('google')->stateless()->user();
        //dd($gUser);//リダイレクトページに、ログイン承認されたユーザの情報がJSONで渡される。

        $user = User::where('email', $gUser->email)->first();
        // 見つからなければ新しくユーザーを作成
        if ($user == null) {
            $user = $this->createUserByGoogle($gUser);
        }
        // ログイン処理
        \Auth::login($user, true);
        return redirect('/home');

        //以下のコードでは、ただビューを表示するのみなので、リロードしたら/homeに遷移する
        //return view('user', compact('user'));
    }

    public function createUserByGoogle($gUser)
    {
        //Qiita記事を参照
        $user = User::create([
            'nickname'     => $gUser->name,
            'email'    => $gUser->email,
            'password' => \Hash::make(uniqid()), //ここよくわからん
        ]);
        /*ユーザ登録機能は、以下のようにUserControllerとほぼ同じでも良い
        $user = new User;
        
        $user->nickname = $gUser->name;
        $user->email = $gUser->email;
        $user->password = \Hash::make(uniqid());//$gUser->passwordはダメ。なぜなら、$gUserにpasswordは存在しないから。;
        
        $user->save();
        */
        return view('user', compact('user'));
    }
}
