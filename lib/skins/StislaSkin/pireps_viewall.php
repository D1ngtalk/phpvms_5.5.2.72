<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1>我的报告</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item">我的报告</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                    if(!$pireps) {
                        echo '<div class="alert alert-primary mb-2" role="alert"><strong>No Reports Found!</strong> You have not filed any reports. File one through the ACARS software or manual report submission to see its details and status on this page.</div>';
                    } else {
                ?>
                <?php require 'flown_routes_map.php'; ?>
                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="row">航班号</th>
                                <th scope="row">出发机场</th>
                                <th scope="row">到达机场</th>
                                <th scope="row">飞机</th>
                                <th scope="row">飞行时间</th>
                                <th scope="row">提交日期</th>
                                <th scope="row">状态</th>
                                <?php
                                    // Only show this column if they're logged in, and the pilot viewing is the owner/submitter of the PIREPs
                                    if(Auth::LoggedIn() && Auth::$userinfo->pilotid == $userinfo->pilotid) {
                                        echo '<th>选项</th>';
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($pireps as $report) {
                            ?>
                            <tr>
                                <td><a href="<?php echo url('/pireps/view/'.$report->pirepid);?>"><?php echo $report->code . $report->flightnum; ?></a></td>
                                <td><a href="<?php echo url('/airports/get_airport?icao='.$report->depicao);?>"><?php echo $report->depicao; ?></a></td>
                                <td><a href="<?php echo url('/airports/get_airport?icao='.$report->arricao);?>"><?php echo $report->arricao; ?></td>
                                <td><a href="<?php echo url('/fleet/view/'.$report->aircraftid);?>"><?php echo $report->aircraft . " ($report->registration)"; ?></td>
                                <td><?php echo intval($report->flighttime).'小时'.($report->flighttime - intval($report->flighttime)) * 100 .'分钟';?></td>
                                <td><?php echo date(DATE_FORMAT, $report->submitdate); ?></td>
                                <td>
                                    <?php
                                    if($report->accepted == PIREP_ACCEPTED)
                                        echo '<div id="success" class="label label-success text-success">已通过</div>';
                                    elseif($report->accepted == PIREP_REJECTED)
                                        echo '<div id="error" class="label label-danger text-danger">已拒绝</div>';
                                    elseif($report->accepted == PIREP_PENDING)
                                        echo '<div id="error" class="label label-info text-info">待审核</div>';
                                    elseif($report->accepted == PIREP_INPROGRESS)
                                        echo '<div id="error" class="label label-warning text-warning">飞行中</div>';
                                    ?>
                                </td>
                                <?php
                                    // Only show this column if they're logged in, and the pilot viewing is the owner/submitter of the PIREPs
                                    if(Auth::LoggedIn() && Auth::$userinfo->pilotid == $report->pilotid) {
                                ?>
                                <td>
                                    <a href="<?php echo url('/pireps/addcomment?id='.$report->pirepid);?>">添加备注</a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>