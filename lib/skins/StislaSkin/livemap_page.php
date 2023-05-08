<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1>在线地图</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行员中心</a></div>
        <div class="breadcrumb-item">在线地图</div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>在线地图</h4>
                <div class="card-header-action">
                    <a href="javascript::" class="btn btn-primary">在线飞行员: <?php echo ACARSData::getLiveFlightCount(); ?></a>
                </div>
            </div>
            <div class="card-body">
                <?php require 'livemap_script.php'; ?>
            </div>
        </div>
    </div>
</div>