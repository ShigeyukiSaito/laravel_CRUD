<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>

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
        .form_tag {
            width: 50%;
            margin: 0 auto;
            /*background-color: #00DD00;*/
            position: relative;
            top: 30px;
            margin-bottom: 40px;
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
            bottom: 20%;
            height: 40px;
            font-size: 20px;
        }
        #password_reset {
            position: absolute;
            left: 25%;
            bottom: 10%;
            /*background-color: black;*/
        }
        
    </style>
</head>
<body>
<div class="content">
        <p class="title">ログイン</p>
        <hr>
        <form action="{{action('UserController@create')}}" method="post">
        @csrf
    <!--    <div class="form_tag">
                <label>ニックネーム</label> 
                <input type="text" name="nickname" class="form_input" placeholder="ニックネーム" /*onclick="onClick_form(this)"*/ />
            </div>
    -->
            <div class="form_tag">  
    <!--        <label>メールアドレス</label>   -->
                <input type="text" name="email" class="form_input" placeholder="メールアドレス" /*onclick="onClick_form(this)"*/ onmouseleave="check_email(this)"/>
            </div>
    
            <div class="form_tag">
    <!--        <label>パスワード</label>   -->
                <input type="text" name="password" class="form_input" placeholder="パスワード" /*onclick="onClick_form(this)"*/ onmouseleave="check_password(this)"/>
    <!--            <a href="/password_reset">パスワードをお忘れの方</a>  -->
            </div>
            <div class="button_tag">
                <input type="submit" id="button" value="確認に進む"/>
            </div>
            <div id="password_reset"><a href="/password_reset">パスワードをお忘れの方</a></div>
        </form>

        <script>
            //エラーメッセージの表示変数
            var nickname_error_message_created = false;
            var email_error_message_created = false;
            var password_error_message_created = false;

            function check_email(obj) {
                //正規表現はこのサイトを参照　https://qiita.com/str32/items/a692073af32757618042#%E3%83%A1%E3%83%BC%E3%83%AB%E3%82%A2%E3%83%89%E3%83%AC%E3%82%B9
                var result = obj.value.match(/[\w\-._]+@[\w\-._]+\.[A-Za-z]+/);

                if(result != null) {
                    //https://developer.mozilla.org/ja/docs/Web/API/Document/getElementsByTagName
                    var errorMessage = document.getElementById('error_email');
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
                            make_email_error_message(obj, "入力してください。");
                            break;
                        default :
                            make_email_error_message(obj, "メールアドレスが不正です。");
                        }
                    }
                    else if(email_error_message_created == true) {
                        switch (obj.value) {
                        case "":
                            change_email_error_message("入力してください。");
                            break;
                        default :
                            change_email_error_message("メールアドレスが不正です。");
                        }
                    }
                }
            }
            //メール入力エラーメッセージ生成
            function make_email_error_message(obj, message) {
                //タグの生成
                var errorMessage = document.createElement('div'); //pタグでもいい？
                errorMessage.setAttribute('id', 'error_email');

                //objの親要素に、子要素としてエラーメッセージを追加する
                obj.parentNode.appendChild(errorMessage);
                errorMessage.innerHTML = message;
            }
            //メール入力エラーメッセージ変更
            function change_email_error_message(message) {
                //すでに作ったエラーのdivを拾ってきて
                var errorMessage = document.getElementById('error_email');
                //中身変える
                errorMessage.innerHTML = message;
            }

            function check_password(obj) {
                var result = obj.value.match(/[\w\-._]{7,30}/);
                if(result != null) {
                    //https://developer.mozilla.org/ja/docs/Web/API/Document/getElementsByTagName
                    var errorMessage = document.getElementById('error_password');
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
                            make_password_error_message(obj, "入力してください。");
                            break;
                        default :
                            make_password_error_message(obj, "7文字以上30文字以下の半角英数字で入力してください");
                        }
                    }
                    else if(password_error_message_created == true) {
                        switch (obj.value) {
                        case "":
                            change_password_error_message("入力してください。");
                            break;
                        default :
                            change_password_error_message("7文字以上30文字以下の半角英数字で入力してください");
                        }
                    }
                }
            }
            //パスワード入力エラーメッセージ生成
            function make_password_error_message(obj, message) {
                //タグの生成
                var errorMessage = document.createElement('div'); //pタグでもいい？
                errorMessage.setAttribute('id', 'error_password');

                //objの親要素に、子要素としてエラーメッセージを追加する
                obj.parentNode.appendChild(errorMessage);
                errorMessage.innerHTML = message;
            }
            //パスワード入力エラーメッセージ変更
            function change_password_error_message(message) {
                //すでに作ったエラーのdivを拾ってきて
                var errorMessage = document.getElementById('error_password');
                //中身変える
                errorMessage.innerHTML = message;
            }
        </script>
    </div>
</body>
</html>