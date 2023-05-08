<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<?php
    //simpilotgroup addon module for phpVMS virtual airline system
    //
    //simpilotgroup addon modules are licenced under the following license:
    //Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
    //To view full icense text visit http://creativecommons.org/licenses/by-nc-sa/3.0/
    //
    //@author David Clark (simpilot)
    //@copyright Copyright (c) 2009-2010, David Clark
    //@license http://creativecommons.org/licenses/by-nc-sa/3.0/

    $month_name = date( 'F', mktime(0, 0, 0, $month) );
?>

<div class="section-header">
	<h1><?php echo $year.'年'.$month.'月'; ?>排行榜</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行员中心</a></div>
        <div class="breadcrumb-item"><a href="javascript::">排行榜</a></div>
        <div class="breadcrumb-item"><?php echo $year.'年'.$month.'月'; ?>排行榜</div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php 
                    if(!$topflights) {
                        echo '<div class="alert alert-primary">本月没有报告</div>';
                    } else { 
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <?php $month_name = date('F', mktime(0, 0, 0, $topflights[0]->month)); ?>
                        <div class="alert alert-primary">航班数排行榜</div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="row">飞行员</th>
                                    <th scope="row">航班数</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($topflights as $top) {
                                        $pilot = PilotData::GetPilotData($top->pilot_id);
                                ?>
                                <tr>
                                    <td><?php echo $pilot->firstname.' '.$pilot->lastname.' - '.PilotData::GetPilotCode($pilot->code, $pilot->pilotid); ?></td>
                                    <td><?php echo $top->flights; ?>班次</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <div class="alert alert-primary">小时数排行榜</div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="row">飞行员</th>
                                    <th scope="row">小时数</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($tophours as $top) {
                                        $pilot = PilotData::GetPilotData($top->pilot_id);
                                ?>
                                <tr>
                                    <td><?php echo $pilot->firstname.' '.$pilot->lastname.' - '.PilotData::GetPilotCode($pilot->code, $pilot->pilotid); ?></td>
                                    <td><?php echo $top->hours; ?>小时</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-4">
                        <div class="alert alert-primary">里程数排行榜</div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="row">飞行员</th>
                                    <th scope="row">里程数</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($topmiles as $top) {
                                        $pilot = PilotData::GetPilotData($top->pilot_id);
                                ?>
                                <tr>
                                    <td><?php echo $pilot->firstname.' '.$pilot->lastname.' - '.PilotData::GetPilotCode($pilot->code, $pilot->pilotid); ?></td>
                                    <td><?php echo $top->miles; ?>海里</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <center>
            <form method="link" action="<?php echo url('TopPilot'); ?>">
                <input type="submit" class="mail btn btn-primary" value="本月排行榜">
            </form>
		</center>
    </div>
</div>