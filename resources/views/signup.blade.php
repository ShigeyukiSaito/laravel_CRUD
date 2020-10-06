<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="250458634432-n9aab776rvsnas9a72o3opser147gafp.apps.googleusercontent.com">
    <title>新規ユーザ登録</title>

    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- ここからGoogleログインボタンのデザイン-->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
    <script src="https://apis.google.com/js/api:client.js"></script>

    <script>
    let googleUser = {};
    //let authentificated = true;
    
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
                //Googleログインボタンを隠す
                element.hidden = true;
                //フォームにgoogleアカウントのデータを入力
                document.getElementById('user_nickname').value = googleUser.getBasicProfile().getName();
                document.getElementById('user_email').value = googleUser.getBasicProfile().getEmail();
                //document.getElementById('user_image').value = googleUser.getBasicProfile().getImageUrl();
            });
    }
    </script>

    <style>
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
            height: 86%;
            margin: 0 auto;
            font-size: 15px;
            position: relative;
            top: 10%;
            text-align: left;
            /*vertical-align: middle;*/
            padding-top:10px;
            
        }
        .title {
            text-align:center;
            font-size: 25px;
            font-weight: bolder;
        }
        #form_tags {
            height: 80%;
            position: relative;
            top: 5%;
        }
        .form_tag {
            width: 50%;
            height: 21%;
            margin: 0 auto;
            position: relative;
            top: 5%;
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
        .button_tag{
            width: 50%;
            height: 9%;
            margin: 0 auto;
            position: relative;
            top: 7%;
        }
        input#button{
            width: 100%;
            height: 100%;
            /*inline要素なので、margin: 0 auto;が使えない（box要素なら使える）*/
            /*なので、divタグやpタグで囲って、そいつにmargin: 0 auto;を当てる */
            position: relative;
            font-size: 20px;
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
        .authErrorParent {
            height: 30px;
        }
        #authError {
            color: red;
            /*display: inline;*/
            position: relative;
            top: 20px;
            /*vertical-align: middle;*/
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="content">
        <p class="title">会員情報入力</p>
        <hr>
        <!-- フォームの自動補完機能をoffにするには、フォームまたは各inputタグの属性にautocomplete="off"を指定する。-->
        <form id="form_tags" action="{{ action('UserController@create') }}"  method="post" required>
        @csrf
            <!--カスタムログインボタン-->
            <div id="gSignInWrapper">
                <div id="customBtn" class="customGPlusSignIn" >
                    <span class="icon"></span>
                    <span class="buttonText"><!--<a href="/login/google" id="googleLoginLink">-->Googleで新規登録</span>
                </div>
            </div>
            <div id="name"></div>
            <script>startApp();</script>

            <!--ここにエラーメッセージ出す-->
            <div class="authErrorParent">
            @if (Session::has('authentificated'))
                <div id="authError">{{ session('error_message') }}</div>
            @endif
            </div>

            <div class="form_tag">
                <label>ニックネーム</label>
                <input type="text" id="user_nickname" name="nickname" class="form_input" placeholder="例）チンチラ大好き" onblur="check_nickname(this)" autocomplete="off" /*onmouseleave="check_nickname(this)"*/ required>
            </div>
            <div class="form_tag">
                <label>メールアドレス</label>
                <input type="text" id="user_email" name="email" class="form_input" placeholder="PC・携帯どちらでも可能"  onblur="check_email(this)" autocomplete="off" /*onmouseleave="check_email(this)"*/ required/>
            </div>
            <div class="form_tag">
                <label>パスワード</label>
                <input type="text" id="user_password" name="password" class="form_input" placeholder="7文字以上の半角英数字" onblur="check_password(this)" autocomplete="off" /*onmouseleave="check_password(this)"*/ required/>
            </div>
            <!--画面上に表示しない-->
            <!--
            <div class="form_tag" hidden>
                <label>プロフィール画像</label>
                <input type="text" id="user_image" name="image" class="form_input" />
            </div>
    -->
            <div class="button_tag">
                <input type="submit" id="button" value="確認に進む" disabled/>
            </div>
        </form>
        
        <script>
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

            const button = document.getElementById('button');

            //エラーメッセージの内容
            const null_error_message = "入力してください。";
            const email_error_message = "フォーマットが正しくありません。";
            const password_error_message = "7文字以上30文字以下の半角英数字で入力して下さい";

            //入力エラーでてないかチェック。エラーなければ送信ボタン押せる。
            function inputable_check() {
                if(nickname_error_message_created == true || email_error_message_created == true || password_error_message_created == true) {
                    button.disabled = true;
                } else {
                    button.disabled = false;
                }
            }
            function check_nickname(obj) {
                
            }
            function check_email(obj) {
                //正規表現はこのサイトを参照　https://qiita.com/str32/items/a692073af32757618042#%E3%83%A1%E3%83%BC%E3%83%AB%E3%82%A2%E3%83%89%E3%83%AC%E3%82%B9
                let result = obj.value.match(match_email/*/[\w\-._]+@[\w\-._]+\.[A-Za-z]+/*/);

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
                inputable_check();
            }
            function check_password(obj) {
                let result = obj.value.match(match_password /*/[\w\-._]{7,30}/*/);

                if(result != null) {
                    const errorMessage = document.getElementById(password_error_id);

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
                inputable_check();
            }
            //エラーメッセージ生成
            function make_error_message(obj, id, message) {
                //タグの生成
                const errorMessage = document.createElement('div'); 
                errorMessage.setAttribute('id', id/*'error_password'など*/);

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
        </script>
    </div>
</body>
</html>