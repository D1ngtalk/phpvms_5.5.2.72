<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <img src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/img/logo.svg" alt="logo" width="300">
            </div>

            <div class="card card-primary">
                <div class="card-header"><h4>忘记密码</h4></div>

                <div class="card-body">
                    <p class="text-muted">我们将发送一个链接来重置您的密码</p>
                    <form action="<?php echo url('/login/forgotpassword');?>" method="POST">
                        <div class="form-group">
                            <label for="email">邮箱</label>
                            <input type="email" name="email" class="form-control" tabindex="1" required autofocus>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="action" value="resetpass" />
                            <input class="btn btn-primary btn-lg btn-block" type="submit" name="submit" value="忘记密码" tabindex="4"/>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-5 text-muted text-center">
                已经有账号了？ <a href="<?php echo url('/login'); ?>">现在登录</a>
            </div>

            <div class="simple-footer">Copyright &copy; <?php echo SITE_NAME; ?> <?php echo date("Y"); ?></div>
        </div>
    </div>
</div>