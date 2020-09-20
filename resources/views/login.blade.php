<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="250458634432-n9aab776rvsnas9a72o3opser147gafp.apps.googleusercontent.com">
    <title>ログイン</title>

    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- ここからGoogleログインボタンのデザイン-->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <script src="https://apis.google.com/js/api:client.js"></script>

    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->

    <script>
    let googleUser = {};
    //let authentificated = true;
    //window.onload = authentificate_error;

/*
    //認証エラーメッセージ生成
    window.onload = function() {
        let authError = document.getElementById("authError");
        window.alert("onloadが実行されました。");
        if( authentificated == false ) {
            authError.hidden = false;
        };
    };
*/
    let startApp = function() {
        gapi.load('auth2', function(){
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            client_id: '250458634432-n9aab776rvsnas9a72o3opser147gafp.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
        });
        attachSignin(document.getElementById('customBtn'));
        });
    };

    function attachSignin(element) {
        console.log(element.id);
        auth2.attachClickHandler(element, {},
            function(googleUser) {
            document.getElementById('name').innerText = "Signed in: " +
                googleUser.getBasicProfile().getName();
                //ユーザページへ移動
                let UserPageUri = "{{ route('user')}}";
                document.location.href = UserPageUri;
            }, function(error) {
            alert(JSON.stringify(error, undefined, 2));
            });
    }
    </script>
    <!-- ここまで-->
    <style type="text/css">
        html, body {
            background-color: #DDDDDD;
            color: #000000;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0 ;
        }
        .content {
            background-color: #FFFFFF;
            width: 40%;
            margin: 0 auto;
            font-size: 15px;
            position: relative;
            top: 10%;
            text-align: left;
            vertical-align: middle;
            height: 80%;
            padding-top:20px;
        }
        .title {
            text-align:center;
            font-size: 25px;
            font-weight: bolder;
        }
        .content hr {
            margin-bottom: 50px;
        }
        #form_tags {
            height: 70%;
        }
        .form_tag {
            width: 50%;
            height: 22%;
            margin: 0 auto;
            /*background-color: #00DD00;*/
            position: relative;
            top: 0px;
        }
        .form_tag a {
            margin-top: 20px;
            display: block;
        }
        input.form_input {
            width: calc(100% - 22px); /*padding-left つけてなくて-12%なので、paddingつけてたら-22%*/
            height: 40px;
            font-size: 16px;
            padding-left: 16px;
            margin-top: 8px;
        }
        #error_email {
            color: red;
            font-size: 12px;
        }
        #error_password {
            color: red;
            font-size: 12px;
        }
        .button_tag {
            background-color: #00DD00;
            width: 50%;
            margin: 0 auto;
        }
        input#button {
            width: 50%;
            /*inline要素なので、margin: 0 auto;が使えない（box要素なら使える）*/
            /*なので、divタグやpタグで囲って、そいつにmargin: 0 auto;を当てる */
            position: absolute;
            bottom: 18%;
            height: 40px;
            font-size: 20px;
        }
        #password_reset {
            position: absolute;
            left: 25%;
            bottom: 10%;
        }
        .g-signin2 {
            width: 50%;
            margin: 0 auto;
            background-color: #00DD00;
            position: relative;
            top: 30px;
            margin-bottom: 40px;
        }
        .g-signin2 > div{
            width: 200%;
            margin: 0 auto;
        }
        /* ここからGoogleボタンの改良デザイン*/
        #customBtn {
            /*display: inline-block;*/
            background: white;
            color: #444;
            width: 50%/*190px*/;
            margin: 0 auto;
            /*margin-bottom: 20px;*/
            border-radius: 5px;
            border: thin solid #888;
            box-shadow: 1px 1px 1px grey;
            white-space: nowrap;
        }
        #customBtn:hover {
            cursor: pointer;
        }
        span.label {
            font-family: serif;
            font-weight: normal;
        }
        span.icon {
            background: url('https://www.google.co.jp/favicon.ico') transparent 5px 50% no-repeat;
            /*background: url('/identity/sign-in/g-normal.png') transparent 5px 50% no-repeat;*/
            /*background: url('/storage/app/public/btn_google_light_normal_ios.svg') transparent 5px 50% no-repeat;*/
            display: inline-block;/*これ付けないとアイコン出なくなる。*/
            vertical-align: middle;
            width: 42px;
            height: 42px;
        }
        span.buttonText {
            display: inline-block;
            /*text-align: center;*/
            vertical-align: middle;
            padding-left: 42px;
            padding-right: 42px;
            font-size: 14px;
            /*font-weight: bold;*/
            /* Use the Roboto font that is loaded in the <head> */
            font-family: 'Roboto', sans-serif;
        }
        #logout {
           position: absolute;
           right: 0;
           bottom: 0;
        }
        #googleLoginLink{
            text-decoration: none;
            color:black;
        }
        .authErrorParent {
            height: 16%;
        }
        #authError {
            color: red;
            /*display: inline;*/
            position: relative;
            top: 40%;
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content">
        <p class="title">ログイン</p>
        <hr>

        <form id="form_tags" action="{{action('UserController@show')}}" method="post">
        @csrf
            <!--デフォルトのGoogleログインボタン-->
            <!--<div class="g-signin2" data-onsuccess="onSignIn"><div>Googleで</div></div>-->

            <!--カスタムログインボタン-->
            <div id="gSignInWrapper">
                <!--<span class="label">Sign in with:</span>-->
                <div id="customBtn" class="customGPlusSignIn" >
                    <span class="icon"></span>
                    <span class="buttonText"><!--<a href="/login/google" id="googleLoginLink">-->Googleでログイン</span>
                </div>
            </div>
            <!--<div id="name"></div>-->
            <script>startApp();</script>

            <!--ここにエラーメッセージ出す-->
            <div class="authErrorParent">
            @if (Session::has('authentificated'))
                <div id="authError">メールアドレスかパスワードが間違っています。</div>
            @endif
            </div>

            <div class="form_tag">  
    <!--        <label>メールアドレス</label>   -->
                <input type="text" name="email" class="form_input" placeholder="メールアドレス" /*onmouseleave*/ onblur="check_email(this)"/>
            </div>
            <div class="form_tag">
    <!--        <label>パスワード</label>   -->
                <input type="text" name="password" class="form_input" placeholder="パスワード" /*onmouseleave*/ onblur="check_password(this)"/>
    <!--        <a href="/password_reset">パスワードをお忘れの方</a>  -->
            </div>
            <div class="button_tag">
                <input type="submit" id="button" value="確認に進む"/>
            </div>
            <div id="password_reset"><a href="/password_reset">パスワードをお忘れの方</a></div>
            <div id="logout"><a href="/" onclick="signOut();">ログアウトする</a></div>
        </form>
        
        
        <script>
            function onSignIn(googleUser) {
                var profile = googleUser.getBasicProfile();
                console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                console.log('Name: ' + profile.getName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
            }
            //各フォームの正規表現（RegExp）
            const match_email = /[\w\-._]+@[\w\-._]+\.[A-Za-z]+/;
            const match_password =/[\w\-._]{7,30}/; 

            //エラーメッセージを生成したかどうかのチェック
            let nickname_error_message_created = false;
            let email_error_message_created = false;
            let password_error_message_created = false;
            
            //エラーメッセージのタグid
            const email_error_id = "error_email";
            const password_error_id = "error_password";

            //エラーメッセージの内容
            const null_error_message = "入力してください。";
            const email_error_message = "フォーマットが正しくありません。";
            const password_error_message = "7文字以上30文字以下の半角英数字で入力してください";
            const authentification_error_message = "メールアドレスかパスワードが間違っています。";

            function check_email(obj) {
                //正規表現はこのサイトを参照　https://qiita.com/str32/items/a692073af32757618042#%E3%83%A1%E3%83%BC%E3%83%AB%E3%82%A2%E3%83%89%E3%83%AC%E3%82%B9
                let result = obj.value.match(match_email);

                if(result != null) {
                    //https://developer.mozilla.org/ja/docs/Web/API/Document/getElementsByTagName
                    const errorMessage = document.getElementById(email_error_id);
                    //エラーメッセージの削除メソッドについてはMozillaのサイトを参考https://developer.mozilla.org/ja/docs/Web/API/Node/removeChild
                    if(errorMessage) {
                        errorMessage.parentNode.removeChild(errorMessage);
                        email_error_message_created = false;
                    }
                }
                else if(result == null) {
                    if(email_error_message_created == false) {
                        //div生成チェック
                        email_error_message_created = true;

                        switch (obj.value) {
                            case "":
                                make_error_message(obj, email_error_id, null_error_message);
                                break;
                            default :
                                make_error_message(obj, email_error_id, email_error_message);
                        }
                    }
                    else if(email_error_message_created == true) {
                        switch (obj.value) {
                            case "":
                                change_error_massage(email_error_id, null_error_message);
                                break;
                            default :
                                change_error_massage(email_error_id, email_error_message);   
                        }
                    }
                }
            }
            function check_password(obj) {
                let result = obj.value.match(match_password);

                if(result != null) {
                    //https://developer.mozilla.org/ja/docs/Web/API/Document/getElementsByTagName
                    const errorMessage = document.getElementById(password_error_id);
                    //エラーメッセージの削除メソッドについてはMozillaのサイトを参考https://developer.mozilla.org/ja/docs/Web/API/Node/removeChild
                    if(errorMessage) {
                        errorMessage.parentNode.removeChild(errorMessage);
                        password_error_message_created = false;
                    }
                }
                else if(result == null) {
                    if(password_error_message_created == false) {
                        //div生成チェック
                        password_error_message_created = true;
                        switch (obj.value) {
                            case "":
                                make_error_message(obj, password_error_id, null_error_message);
                                break;
                            default :
                                make_error_message(obj, password_error_id, password_error_message);
                            }
                        }
                    else if(password_error_message_created == true) {
                        switch (obj.value) {
                            case "":
                                change_error_massage(password_error_id, null_error_message);
                                break;
                            default :
                                change_error_massage(password_error_id, password_error_message);                                
                        }
                    }
                }
            }
            //エラーメッセージ生成
            function make_error_message(obj, id, message) {
                //タグの生成
                const errorMessage = document.createElement('div'); 
                errorMessage.setAttribute('id', id);

                //objの親要素に、子要素としてエラーメッセージを追加する
                obj.parentNode.appendChild(errorMessage);
                errorMessage.innerHTML = message;
            }
            //エラーメッセージ変更
            function change_error_massage(id, message) {
                //すでに作ったエラーのdivを拾ってきて
                let errorMessage = document.getElementById(id);
                //中身変える
                errorMessage.innerHTML = message;
            }
            function signOut() {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                console.log('User signed out.');
                });
            }
        </script>
    </div>
</body>
</html>