<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録情報編集</title>

    <style>
        html, body {
            background-color: #DDDDDD;
            color: #000000;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0 ;
        }
        header {
            background-color: #DDDDDD;
            width: 100%;
            height: 10%;
            /*padding-left: 10%;*/
        }
        header label {
            position: absolute;
            margin-left: 20%;
            margin-top: 20px;
            font-size: 30px;
        }
        header a {
            color: dimgray;
            font-size: 20px;
            font-weight: bold;
            padding: 0 25px;
            position: absolute;
            right: 20%;
            top: 5%;
        }
        main {
            background-color: #FFFFFF;
            width: 60%;
            height: 80%;
            /*position: absolute;
            left: 10%;*/
            margin: 0 auto;
        }
        aside {
            background-color: #808080;
            width: 15%;
            height: 100%;
            float: left;
        }
        .sidebar_tag {
            width: 100%;
            margin-bottom: 1%;
            position: relative;
            top: 10%;
            text-align: center;
            height: 15%;
            border: solid #000000;
            box-sizing: border-box;/*ボーダーを含んだサイズにする*/
            z-index: 0; /* 必要であればリンク要素の重なりのベース順序指定 */
        }
        .sidebar_tag a {
            display: block;
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: auto; /* 必要であればリンク要素の重なりのベース順序指定 */
        }
        .sidebar_tag a span{
            position: absolute;
            top: 50%; /*ここで下に50%ずらす*/
            left: 0;
            width: 100%;
            color: #000000;
            transform : translateY(-50%); /*ここで上に50%戻す*/
            z-index: auto; /* 必要であればリンク要素の重なりのベース順序指定 */
        }
        .content {
            width: 85%;
            height: 100%; 
            position: relative;
            left: 15%;
        }
        .content form {
            width: 100%;
            height: 100%; 
        }
        #imageBox {
            width: 40%;
            height: 40%;
            position: relative;
            left: 30%;
            top: 10%;
        }
        #image {
            height: 100%;
            width: auto;
            position: absolute;
            top: 0;
            left: 0;
        }
        #avatar {
            display: none;
        }
        #profileBox {
            height: 30%;
            position: relative;
            top: 20%;
        }
        .profile {
            width: 80%;
            height: 40%;
            position: relative;
            left: 10%;
            /*margin-bottom: 3%;*/
        }
        .input_form {
            height: 30px;
            width: 30%;
        }
        #button {
            position: absolute;
            right: 20%;
            margin-top: 3%;
            color: red;
            text-decoration: none; 
        }
        #error_nickname {
            font-size: 12px;
            color: red;
            position: relative;
            left: 28%;
        }
        #error_email {
            font-size: 12px;
            color: red;
            position: relative;
            left: 31%;
        }
        footer {
            height: 10%;
        }
    </style>
</head>
<body>
    <header>
        <label>{{ Session::get('user.nickname') }}のページ</label>
        <a href="/">ログアウト</a>
    </header>
    
    <main>
        <aside>
            <div class="sidebar_tag">
                <a href=""><span>基本情報</span></a>  
            </div>
            <div class="sidebar_tag">
                <a href=""><span>交換履歴</span></a>  
            </div>
            <div class="sidebar_tag">
                <a href=""><span>設定</span></a>  
            </div>
            <div class="sidebar_tag">
                <a href=""><span>その他</span></a>  
            </div>
        </aside>
        <div class="content">
            <form action="/user/home" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div id="imageBox">
                <?php
                    if(\File::exists('storage/profile_images/'.Session::get('user.profile_image'))):
                    //以下のように2行に分けて書いた場合、プロフ画像は表示されない
                    //$save_path = 'public/profile_images/'.$user->profile_image; 
                    //if(\File::exists($save_path)):  
                ?>
                    <img id="image" src="{{ asset('storage/profile_images/'.Session::get('user.profile_image')) }}" alt="プロフィール画像" onclick="clickImage()"/>
                <?php else: ?>
                    <img id="image" src="{{ Session::get('user.profile_image') }}" alt="プロフィール画像" onclick="clickImage()"/>
                <?php endif; ?>
                    <input type="file" id="avatar" name="profile_image" accept="image/png, image/jpeg" onchange="previewImage(this);">
                </div>
                <div id="profileBox">
                    <div class="profile">
                        <label>新しいニックネーム：</label>
                        <input type="text" class="input_form" name="nickname" class="form_input" value="{{ Session::get('user.nickname') }}" onblur="check_nickname(this)" />
                    </div>
                    <div class="profile">
                        <label>新しいメールアドレス：</label>
                        <input type="text" class="input_form" name="email" class="form_input" value="{{ Session::get('user.email') }}" onblur="check_email(this)" />
                    </div>
                    <div class="profile">
                        <input type="submit" id="button" value="更新する" disabled/>
                    </div>
                </div>
            </form>
        </div>
    </main>
    
    <footer></footer>
    <script>
        //入力バリデーション用変数
        //各フォームの正規表現（RegExp）
        const match_nickname = /[\S]/;
        const match_email = /[\w\-._]+@[\w\-._]+\.[A-Za-z]+/;

        //エラーメッセージを生成したかどうかのチェック
        let nickname_error_message_created = false;
        let email_error_message_created = false;
        
        //エラーメッセージのタグid
        const nickname_error_id = "error_nickname";
        const email_error_id = "error_email";
        
        //送信ボタン
        const button = document.getElementById('button');

        //エラーメッセージの内容
        const null_error_message = "入力してください。";
        //ニックネーム
        const nickname_error_message = "フォーマットが正しくありません。";
        //メールアドレス
        const email_error_message = "フォーマットが正しくありません。";

        //入力エラーでてないかチェック。エラーなければ送信ボタン押せる。
        function inputable_check() {
            if(nickname_error_message_created == true || email_error_message_created == true) {
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        }
        function check_nickname(obj) {
            let result = obj.value.match(match_nickname);

            if(result != null) {
                const errorMessage = document.getElementById(nickname_error_id);
                if(errorMessage) {
                    errorMessage.parentNode.removeChild(errorMessage);
                    nickname_error_message_created = false;
                }
            }
            else if(result == null) {
                if(nickname_error_message_created == false) {
                    //div生成チェック
                    nickname_error_message_created = true;

                    switch (obj.value) {
                        case "":
                            make_error_message(obj, nickname_error_id, null_error_message);
                            break;
                        default :
                            make_error_message(obj, nickname_error_id, email_error_message);
                    }
                }
                else if(nickname_error_message_created == true) {
                    switch (obj.value) {
                        case "":
                            change_error_massage(nickname_error_id, null_error_message);
                            break;
                        default :
                            change_error_massage(nickname_error_id, nickname_error_message);   
                    }
                }
            }
            inputable_check();
        }
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
            inputable_check();
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

        //画像クリックしたら、fileボタンがクリックされた判定
        function clickImage() {
            const avatar = document.getElementById('avatar');
            avatar.click();
        }
        //画像ファイル変更時に、プレビューも変化する
        function previewImage(obj) {
            var fileReader = new FileReader();
            fileReader.onload = (function() {
                document.getElementById('image').src = fileReader.result;
            });
            fileReader.readAsDataURL(obj.files[0]);
        }

    </script>
</body>
</html>