<article id="board_area">
    <header><h1></h1></header>

    <?php
    $attributes = array(
        'class' => 'form_horizontal',
        'id' => 'auth_login'
    );
    echo form_open('index.php/auth/login', $attributes);
    ?>
    <fieldset>
        <!--로그인-->
        <legend>로그인</legend>
        <div class="control-group">
            <label class="control-label" for="input1">이메일</label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="input1" name="email"
                       value="<?php echo set_value('email'); ?>"/>
                <p class="help-block"></p>
            </div>
            <!--비밀번호-->
            <div class="control-group">
                <label class="control-label" for="input2">비밀번호</label>
                <div class="controls">
                    <p class="help-block"></p>
                </div>

                <div class="controls">
                    <p class="help-block"><?php echo validation_errors(); ?> </p>
                </div>

                <div class="form_actions">
                    <button type="submit" class="btn btn-primary">확인</button>
                    <button class="btn" href="/bbs/index.php/board/">취소</button>
                </div>
            </div>
        </div>
    </fieldset>
</article>
