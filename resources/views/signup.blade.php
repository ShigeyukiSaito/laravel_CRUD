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
            width: 50%;
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
        <form action="" method="post">
        @csrf
            <div class="form_tag">
                <label>ニックネーム</label>
                <input type="text" name="name" class="form_input" placeholder="例）チンチラ大好き" onclick="onClick_form(this)"/>
            </div>
            <div class="form_tag">
                <label>メールアドレス</label>
                <input type="text" name="age" class="form_input" placeholder="PC・携帯どちらでも可能" onclick="onClick_form(this)"/>
            </div>
            <div class="form_tag">
                <label>パスワード</label>
                <input type="text" name="password" class="form_input" placeholder="7文字以上の半角英数字" onclick="onClick_form(this)"/>
            </div>
            <div class="button_tag">
                <input type="submit" id="button" value="確認に進む"/>
            </div>
        </form>

        <script>
            function onClick_form(obj) {
                //obj.value = "　";
                obj.focus();
                obj.setSelectionRange(2, 2);
            }
        </script>
    </div>
</body>
</html>