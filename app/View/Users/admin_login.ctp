<!DOCTYPE html>
<html class="bg-light-blue">
<?php echo $this->element('Admin/Common/head'); ?>

    <body class="bg-light-blue">
        <div class="form-box" id="login-box">
            <div class="header">WeChatAdmin</div>
            <?php echo $this->Form->create('User', array('action' => 'login', 'admin' => true)); ?>

                <div class="body bg-gray">
<?php if ($this->Session->check('Message.Admin')) : ?>
                    <div class="form-group">
<?php echo $this->Session->flash('Admin'); ?>

                    </div>
<?php endif;?>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <?php echo $this->Form->text('username', ['class' => 'form-control', 'placeholder' => '用户名或邮箱']); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <?php echo $this->Form->password('password', ['class' => 'form-control', 'placeholder' => '登陆密码']); ?>

                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn btn-lg btn-primary btn-block btn-flat">登陆系统</button>
                </div>
            <?php echo $this->Form->end(); ?>

            <div class="margin text-center">
                <span>&copy;2014 WeChatAdmin Powered By will.lee</span>
            </div>
        </div>
<?php echo $this->element('Admin/Common/footer'); ?>
    </body>
</html>