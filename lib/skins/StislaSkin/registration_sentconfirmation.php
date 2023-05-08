<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <img src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/img/logo.svg" alt="logo" width="300">
            </div>

            <div class="alert alert-success">
                <div class="alert-primary">申请已发出！</div>
                感谢您的注册，您会在通过管理员的审核后收到提醒邮件。
            </div>

            <div class="mt-5 text-muted text-center">
                <a href="<?php echo url('/login'); ?>">现在登录！</a>
            </div>

            <div class="simple-footer">Copyright &copy; <?php echo SITE_NAME; ?> <?php echo date("Y"); ?></div>
        </div>
    </div>
</div>