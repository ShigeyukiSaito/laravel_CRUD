<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザページ</title>

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
            margin-left: 10%;
            margin-top: 20px;
            font-size: 30px;
        }
        main {
            background-color: #FFFFFF;
            width: 80%;
            height: 80%;
            margin: 0 auto;
        }
        aside {
            background-color: #808080;
            width: 15%;
            height: 100%;
        }
        .sidebar_tag {
            /*width: 100%;*/
            
            height: 15%;
        }
        .sidebar_tag #button {
            vertical-align: middle;
            text-align: center;
        }
        footer {
            height: 10%;
        }
    </style>
</head>
<body>
    <header> 
        <label>{{$user->nickname}}のページ</label>
    </header>
    
    <main>
        <aside>
            <div class="sidebar_tag">
                <input type="submit" id="button" value="基本情報"/>   
            </div>
            <div class="sidebar_tag">基本情報</div>
            <div class="sidebar_tag">基本情報</div>
        </aside>
        <div class="content">

        </div>
    <!--
    <p>ニックネーム: {{$nickname ?? ''}}</p>
    <p>email: {{$email ?? ''}}</p> 
    <p>password: {{$password ?? ''}}</p>
    -->
    </main>
    
    <footer></footer>
</body>
</html>