<article id="board_area">
    <form class="form dl-horizontal" , method="POST" , action="" , id="written_action">
        <fieldset>
            <legend> 게시물 수정</legend>
            <div class="control-group">
                <label class="control-label" for="input01"> 제목 </label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="input01" name="subject"
                           value="<?php echo $views->subject; ?>"/>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input02"> 내용 </label>
                    <div class="controls">
                        <textarea class="input-xlarge" id="input02" name="contents" rows="5"><?php echo $views->contents ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="write_btn"> 수정</button>
                    </div>
                </div>
        </fieldset>
    </form>
</article>
</div>
