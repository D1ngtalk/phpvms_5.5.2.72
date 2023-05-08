<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1>确认加机组</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item"><a href="javascript::">航班查询</a></div>
        <div class="breadcrumb-item">确认加机组</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo url('/Fltbook/jumpseatPurchase');?>" method="post">
                    <table class="table">
                        <tr>
                            <td>目的地: <strong><?php echo $airport->name; ?></strong></td>
                        </tr>
                        <tr>
                            <td>出发日期: <strong><?php echo date('Y/m/d') ?></strong></td>
                        </tr>
                        <tr>
                            <td>总共花费: <strong><?php echo $cost; ?>￥</strong></td>
                        </tr>
                    </table>
                    <div style="text-align: center;">
                        <a href="<?php echo url('/Fltbook');?>"><input type="button" class="btn btn-danger" value="取消加机组"></a>
                        <input type="submit" class="btn btn-primary" value="确认加机组">
                    </div>
                    <input type="hidden" name="arricao" value="<?php echo $airport->icao; ?>" />
                </form>
            </div>
        </div>
    </div>
</div>