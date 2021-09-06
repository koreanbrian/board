<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>코드이그나이터 게시판 </title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"
            integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="/include/css/bootstrap.css"/>
</head>
<body>

<article id="board_area">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">글번호: <?php echo $views->board_id; ?></th>
            <th scope="col">제목: <?php echo $views->subject; ?></th>
            <th scope="col">작성자: <?php echo $views->name; ?></th>
            <th scope="col">조회수: <?php echo $views->hits; ?></th>
            <th scope="col">등록일: <?php echo $views->reg_date; ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th colspan="5">
                <?php echo $views->contents; ?>
            </th>
        </tr>

        </tbody>
        <tfoot>
        <tr>
            <th colspan="5">
                <a href="/bbs/index.php/board/" class="btn btn-primary">목록 </a>
                <a href="/bbs/index.php/board/modify/board/board_id/<?php echo $views->board_id; ?>"
                   class="btn btn-warning"> 수정 </a>
                <a href="/bbs/index.php/board/delete/board/board_id/<?php echo $views->board_id; ?>"
                   class="btn btn-danger"> 삭제 </a>
                <a href="/bbs/index.php/board/write/board/"
                   class="btn btn-success">쓰기</a>
        </tr>
        </tfoot>
    </table>
</article>
</body>
</html>