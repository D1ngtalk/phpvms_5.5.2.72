<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<style>
    pre {
        display: block;
        padding: 9.5px;
        margin: 0 0 10px;
        font-size: 13px;
        line-height: 1.4;
        word-break: break-all;
        color: #333;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    
    .comments p {
        display: inline;
    }
</style>
<div class="section-header">
	<h1><?php echo $pirep->code . $pirep->flightnum; ?></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item"><a href="javascript::">我的报告</a></div>
        <div class="breadcrumb-item"><?php echo $pirep->code . $pirep->flightnum; ?></div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>航班信息</h4>
                <div class="card-header-action">
                    <ul class="nav nav-pills" id="myTab3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">详情</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="log-tab" data-toggle="tab" href="#log" role="tab" aria-controls="log" aria-selected="false">日志</a>
                        </li>
                    </ul>
				</div>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent2">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>飞行员:</strong>
                                        <a href="<?php echo SITE_URL.'/index.php/profile/view/'.$pirep->pilotid?>"><?php echo $pirep->firstname.' ('.PilotData::GetPilotCode($pirep->code, $pirep->pilotid).')'; ?></a>
                                    </li>
                                    <li>
                                        <strong>飞机:</strong>
                                        <a href="<?php echo SITE_URL; ?>/index.php/fleet/view/<?php echo $pirep->aircraftid; ?>"><?php echo $pirep->aircraft." ($pirep->registration)"?></a>
                                    </li>
                                    <li>
                                        <strong>出发机场:</strong>
                                        <a href="<?php echo SITE_URL; ?>/index.php/airports/get_airport?icao=<?php echo $pirep->depicao; ?>"><?php echo $pirep->depicao; ?></a>
                                    </li>
                                    <li>
                                        <strong>来源:</strong>
                                        <?php echo ucfirst($pirep->source); ?>
                                    </li>

                                    <br>

                                    <li>
                                        <strong>时长:</strong>
                                        <?php echo $pirep->flighttime_stamp; ?>
                                    </li>
                                    <li>
                                        <strong>距离:</strong>
                                        <?php echo $pirep->distance; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li>
                                        <strong>职级:</strong>
                                        <?php echo $pirep->rank; ?>
                                    </li>
                                    <li>
                                        <strong>呼号:</strong>
                                        <?php echo $pirep->code . $pirep->flightnum; ?>
                                    </li>
                                    <li>
                                        <strong>到达机场:</strong>
                                        <a href="<?php echo SITE_URL; ?>/index.php/airports/get_airport?icao=<?php echo $pirep->arricao; ?>"><?php echo $pirep->arricao; ?></a>
                                    </li>
                                    <li>
                                        <strong>提交日期:</strong>
                                        <?php echo date("Y/m/d", $pirep->submitdate);?>
                                    </li>

                                    <br>

                                    <li>
                                        <strong>接地率:</strong>
                                        <?php echo $pirep->landingrate; ?>
                                    </li>
                                    <li>
                                        <strong>状态:</strong>
                                        <?php
                                            if($pirep->accepted == PIREP_ACCEPTED)
                                                echo '<span class="text-success">已通过</span>';
                                            elseif($pirep->accepted == PIREP_REJECTED)
                                                echo '<span class="text-danger">已拒绝</span>';
                                            elseif($pirep->accepted == PIREP_PENDING)
                                                echo '<span class="text-warning">待审核</span>';
                                            elseif($pirep->accepted == PIREP_INPROGRESS)
                                                echo '<span class="text-info">飞行中</span>';
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                        <pre style="overflow-y: scroll; height: 300px;"><?php if(!$pirep->log) { echo '这个报告没有日志'; } else { echo str_replace('*',PHP_EOL,$pirep->log); } ?></pre>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($pirep->pilotid != Auth::$pilot->pilotid) { } else {?>
        <div class="card">
            <div class="card-header">
                <h4>备注</h4>
            </div>
            <div class="card-body">
                <div class="comments">
                    <?php 
                        $comments = PIREPData::GetComments($pirep->pirepid);
                        if(!$comments) {
                            echo '这个报告没有备注<br/><br/>';
                        } else {
                            foreach($comments as $comment) {
                    ?>
                    <strong><?php echo $comment->firstname. ' '. $comment->lastname ?>:</strong> 
                    <?php echo $comment->comment; ?> <br/><br/>
                    <?php } } ?>
                </div>

                <form action="<?php echo url('/pireps/viewpireps');?>" method="post">
                    <div class="form-group">
                        <textarea name="comment" rows="1" style="height: 39px !important;" class="form-control" placeholder="备注"></textarea>
                    </div>

                    <input type="hidden" name="action" value="addcomment" />
                    <input type="hidden" name="pirepid" value="<?php echo $pirep->pirepid?>" />
                    <input type="submit" name="submit" style="width: 100%" class="btn btn-primary" value="添加备注" />
                </form>
            </div>
        </div>
        <?php } ?>

        <div class="card">
            <div class="card-header">
                <h4>航班详情</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>总收益: <br /> 
                            (<?php echo $pirep->load;?> 乘客 / 每乘客 <?php echo FinanceData::FormatMoney($pirep->price);?>)</th>
                        <td align="right"><?php echo FinanceData::FormatMoney($pirep->load * $pirep->price);?></td>
                    </tr>
                    <tr>
                        <th>燃油花费: <br />
                            (<?php echo $pirep->fuelused;?> 千克 / 每千克 <?php echo FinanceData::FormatMoney($pirep->fuelunitcost);?>)</th>
                        <td align="right"><?php echo FinanceData::FormatMoney($pirep->fuelused * $pirep->fuelunitcost);?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>航路</h4>
            </div>
            <div class="card-body">
                <blockquote>
                    <?php 
                        if(!$pirep->route) {
                            echo '这个报告没有航路';
                        } else {
                            echo $pirep->route;
                        }  
                    ?>
                </blockquote>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>航班地图</h4>
            </div>
            <div class="card-body p-0">
                <?php require 'route_map.php'; ?>
            </div>
        </div>
    </div>
</div>
