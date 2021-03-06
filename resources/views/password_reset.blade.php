<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>パスワードリセット</title>

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
            height: 75%;
            margin: 0 auto;
            font-size: 15px;
            position: relative;
            top: 10%;
            text-align: left;
            vertical-align: middle;
            padding-top:20px;
            
        }
        .title {
            text-align:center;
            font-size: 25px;
            font-weight: bolder;
        }
        #form_tags {
            height: 70%;
        }
        .form_tag {
            /*
            width: 50%;
            margin: 0 auto;
            position: relative;
            top: 30px;
            margin-bottom: 40px;
            */
            width: 50%;
            height: 30%;
            margin: 0 auto;
            /*background-color: #00DD00;*/
            position: relative;
            top: 10%;
        }
        .error_notice {
            color: red;
        }
        input.form_input {
            width: calc(100% - 22px); /*padding-left つけてなくて-12%なので、paddingつけてたら-22%*/
            height: 40px;
            font-size: 16px;
            padding-left: 16px;
            margin-top: 8px;
        }
        #notice {
            color: #696969;
            font-size: 12px;
            position: relative;
            top: 8%;
            left: 25%;
            width: 50%;
        }
        #error_email {
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
        <p class="title">パスワードをお忘れの方</p>
        <hr>
        <form id="form_tags" action="{{action('UserController@create')}}" method="post">
        @csrf
            <div class="form_tag">  
                <label>メールアドレス</label>
                <input type="text" name="email" class="form_input" placeholder="ご登録されたメールアドレス" /*onmouseleave*/ onblur="check_email(this)" />
            </div>
            <div id="notice">ご登録されたメールアドレスに、パスワード再設定のご案内が送信されます。</div>
            <div class="button_tag">
                <input type="submit" id="button" value="送信する"/>
            </div>
        </form>
        <script>
            //各フォームの正規表現（RegExp）
            const match_email = /[\w\-._]+@[\w\-._]+\.[A-Za-z]+/;

            //エラーメッセージを生成したかどうかのチェック
            let email_error_message_created = false;
            
            //エラーメッセージのタグid
            const email_error_id = "error_email";

            //エラーメッセージの内容
            const null_error_message = "入力してください。";
            const email_error_message = "フォーマットが正しくありません。";

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
        </script>
    </div>
</body>
</html>