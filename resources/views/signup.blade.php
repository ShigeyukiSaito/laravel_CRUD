<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規ユーザ登録</title>
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
            background-color: #00DD00;
            width: 50%;
            margin: 0 auto;
        }
        input#button{
            width: 50%;
            /*inline要素なので、margin: 0 auto;が使えない（box要素なら使える）*/
            /*なので、divタグやpタグで囲って、そいつにmargin: 0 auto;を当てる */
            position: absolute;
            bottom: 10%;
            height: 40px;
            font-size: 20px;
        }
        
    </style>
</head>
<body>
    <div class="content">
        <p class="title">会員情報入力</p>
        <hr>
        <!-- フォームの自動補完機能をoffにするには、フォームまたは各inputタグの属性にautocomplete="off"を指定する。-->
        <form action="{{action('UserController@create')}}" method="post" required>
        @csrf
            <div class="form_tag">
                <label>ニックネーム</label>
                <input type="text" name="nickname" class="form_input" placeholder="例）チンチラ大好き" /*onmouseleave*/ onblur="check_nickname(this)" required>
            </div>
            <div class="form_tag">
                <label>メールアドレス</label>
                <input type="text" name="email" class="form_input" placeholder="PC・携帯どちらでも可能"  /*onmouseleave*/ onblur="check_email(this)" required/>
            </div>
            <div class="form_tag">
                <label>パスワード</label>
                <input type="text" name="password" class="form_input" placeholder="7文字以上の半角英数字" /*onmouseleave*/ onblur="check_password(this)" required/>
            </div>
            <div class="button_tag">
                <input type="submit" id="button" value="確認に進む"/>
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

            //エラーメッセージの内容
            const null_error_message = "入力してください。";
            const email_error_message = "フォーマットが正しくありません。";
            const password_error_message = "7文字以上30文字以下の半角英数字で入力してください";

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
            }
            function check_password(obj) {
                let result = obj.value.match(match_password /*/[\w\-._]{7,30}/*/);

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
                errorMessage.setAttribute('id', id/*'error_password'など*/);

                //objの親要素に、子要素としてエラーメッセージを追加する
                obj.parentNode.appendChild(errorMessage);
                errorMessage.innerHTML = message;
            }
            //エラーメッセージ変更
            function change_error_massage(id, message) {
                //すでに作ったエラーのdivを拾ってきて
                let errorMessage = document.getElementById(id/*'error_password'など*/);
                //中身変える
                errorMessage.innerHTML = message;
            }
        </script>
    </div>
</body>
</html>