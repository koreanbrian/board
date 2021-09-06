<!--게시판 리스트-->
<article id="board_area">
    <table>
        <!--게시판 목록-->
        <thead>
        <tr>
            <th scope="col">번호</th>
            <th scope="col">제목</th>
            <th scope="col">작성자</th>
            <th scope="col">조회수</th>
            <th scope="col">작성일</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $lt) { ?>
            <tr>
                <!--게시글 번호-->
                <th id="listnum" scope="row"><?php echo $lt->board_id; ?></th>
                <!--게시글 제목-->
                <td id="nameonlist">
                    <a id="listname" rel="external"
                       href="/bbs/index.php/<?php echo $this->uri->segment(1, 'board'); ?>/view/<?php echo $this->uri->segment(3, 'page'); ?>/<?php echo $lt->board_id; ?>"><?php echo $lt->subject; ?></a>
                </td>
                <!--게시글 작성자-->
                <td><?php echo $lt->name; ?></td>
                <!--게시글 조회수-->
                <td><?php echo $lt->hits; ?></td>
                <!--게시글 작성일-->
                <td>
                    <time datetime="<?php echo mdate("%Y-%M-%j", human_to_unix($lt->reg_date)); ?>">
                        <?php echo mdate("%Y-%M-%j", human_to_unix($lt->reg_date)); ?>
                    </time>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
        <tfoot>

            <th colspan="5" id="page"><a id="pagenum"><?php echo $pagination; ?></a></th>

    </table>
    <a href="/bbs/index.php/board/write/" class="btn btn-success">쓰기</a>
</article>
