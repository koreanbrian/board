<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <title>CodeIgniter</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"
            integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="/bbs/include/css/bootstrap.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&family=Roboto&display=swap" rel="stylesheet">
    <style>

        /*body {background-color: #ffffff;}
        article#board_area{ background-color: #ffffff;}
        ul {background-color: #00CC00;}
        p{background-color: #ffff00;}
        li{background-color: #ffddaa;}
        h1 {color: #0431fa; font-size: 30px; font-family:'Noto Sans KR', 'sans-serif'; font-weight: bold;}
        th {background-color: #0431fa; padding: 20px; text-align: center; margin: 10px; font-size: 20px; font-family:'Spoqa Han Sans Neo', 'sans-serif'; font-weight: 400; font-size: 15px; padding: 7px; color: #ffffff;}
        th#page {background-color: #ffffff; padding: 20px; text-align: center; margin: 10px; font-size: 20px; font-family:'Spoqa Han Sans Neo', 'sans-serif'; font-weight: 400; font-size: 15px; padding: 7px; color: #ffffff;}
        th#listnum {background-color: #ffffff; padding: 20px; text-align: center; margin: 10px; font-size: 20px; font-family:'Spoqa Han Sans Neo', 'sans-serif'; font-weight: 400; font-size: 15px; padding: 7px; color: #0431fa; border-collapse: collapse; border:1px #0431fa solid;}
        td {text-align: center; margin: 10px; font-size: 18px; font-family:'Spoqa Han Sans Neo', 'sans-serif'; font-weight: 300; font-size: 15px; color: #0431fa; padding : 10px;  border-collapse: collapse; border:1px #0431fa solid;}
        a { text-align: center; margin: 10px; font-size: 20px; font-family:'Spoqa Han Sans Neo', 'sans-serif'; font-weight: 300; font-size: 20px; color: #0431fa;}
        a#pagenum { text-align: center; margin: 10px; font-size: 20px; font-family:'Spoqa Han Sans Neo', 'sans-serif'; font-weight: 300; font-size: 20px; color: #0431fa;}
        a#nameonlist { text-align: center; margin: 10px; font-size: 20px; font-family:'Spoqa Han Sans Neo', 'sans-serif'; font-weight: 300; font-size: 20px; color: #ffffff;}
        a.btn {background-color: #0431fa; font-size:15px; color: #ffffff; border-radius: 0; margin-bottom: 10px; }
        *//*
                        a.btn:hover {background-color: #D3D3D3; font-size:15px; color: #ffffff; border-radius: 0; margin-bottom: 10px; }
        */

        table {padding: 20px; }

    </style>
    <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSansNeo.css' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="main">
    <header id="header" data-role="header" data-position="fixed">
            <h1>
                CodeIgniter 게시판
            </h1>
            <p>

                <?php
                // 로그인 했을 경우 이름 보여주기
                if (@$_SESSION["logged_in"] == TRUE) {
                    ?>
                    <?php echo $_SESSION["name"]; ?> 님 환영합니다. <a href="/bbs/index.php/auth/logout" class="btn">로그아웃</a>
                <?php } else { ?>
                    <a href="/bbs/index.php/auth/login" class="btn btn-primary"> 로그인 </a>
                <?php } ?>
            </p>
    </header>

    <ul class="nav pull-right">
    </ul>
    <nav id="gnb">
        <ul>
            <li>
                <a rel="external" href="/bbs/index.php/board/lists/ci_board/page/"> 게시판 프로젝트 </a>
            </li>
            <li>
                <a rel="external" href="/bbs/index.php/test"> 회원가입 </a>
            </li>

        </ul>
    </nav>