<article id="board_area">
    <header><h1></h1></header>
    <?php // echo validation_errors();?>

    <?php
    if (form_error('email')) {
        $error_email = form_error('email');
    } else {
        $error_email = form_error('email_check');
    }
    ?>

    <form method="POST" class="form-horizontal">
        <fieldset>
            <legend style="font-size:25px"> 회원가입</legend>
            <!--이메일 입력-->
            <div class="control-group">
                <label class="control-label" for="input01">이메일</label>
                <div class="controls">
                    <input type="text" name="email" class="input-xlarge" id="input01"
                           value="<?php echo set_value('email'); ?>"/>
                    <p class="help-block" style="font-size:12px">
                        <?php
                        if ($error_email == FALSE) {
                            echo "이메일을 입력하세요.";
                        } else {
                            echo $error_email;
                        }
                        ?>
                    </p>
                </div>
            </div>
            <!--이름 입력-->
            <div class="control-group">
                <label class="control-label" for="input02">이름</label>
                <div class="controls">
                    <!-- set_rules -> input에 들어가는 것이 조건을 충족해야 함 -->
                    <input type="text" name="name" class="input-xlarge" id="input02"
                           value="<?php echo set_value('name'); ?>"/>
                    <p class="help-block" style="font-size:12px">이름를 입력하세요.</p>
                </div>
            </div>
            <!--비밀번호 입력-->
            <div class="control-group">
                <label class="control-label" for="input03">비밀번호</label>
                <div class="controls">
                    <input type="password" name="password" class="input-xlarge" id="input03"/>
                    <p class="help-block" style="font-size:12px">
                        <?php
                        if (form_error('password') == FALSE) {
                            echo '비밀번호를 입력하세요.';
                        } else {
                            echo form_error('password');
                        }
                        ?>
                    </p>
                </div>
            </div>
            <!--비밀번호 확인-->
            <div class="control-group">
                <label class="control-label" for="input04">비밀번호 확인</label>
                <div class="controls">
                    <input type="password" name="re_password" class="input-xlarge" id="input04"/>
                    <p class="help-block" style="font-size:12px">비밀번호를 한번 더 입력하세요.</p>
                </div>
            </div>

        </fieldset>

        <div><input type="submit" value="회원가입" class="btn btn-primary"/></div>
    </form>
</article>

