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
	<h1>我的航班</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item">我的航班</div>
    </div>
</div>

<div class="row">
    <?php
        $bids = FltbookData::getBidsForPilot(Auth::$userinfo->pilotid);
        if(!$bids) {
            echo '<div class="col-md-12"><div class="alert alert-danger">您未预定任何航班</div></div>';
        } else {
            foreach($bids as $bid) {
                $depAirport = OperationsData::getAirportInfo($bid->depicao);
                $arrAirport = OperationsData::getAirportInfo($bid->arricao);
    ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>航班信息</h4>
                <div class="card-header-action">
                   <a href="<?php echo SITE_URL;?>/index.php/Weather" target="_blank" class="btn btn-primary">天气查询</a>
				</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li>
                                <strong>出发机场:</strong>
                                <a href="javascript::" data-toggle="tooltip" data-placement="bottom" title="<?php echo $depAirport->name; ?>"><?php echo $bid->depicao; ?></a>
                            </li>
                            <li>
                                <strong>呼号:</strong>
                                <?php echo $bid->code . $bid->flightnum; ?>
                            </li>
                            <li>
                                <strong>巡航高度:</strong>
                                <?php echo $bid->flightlevel;?>
                            </li>
                            <li>
                                <strong>距离:</strong>
                                <?php echo $bid->distance;?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li>
                                <strong>到达机场:</strong>
                                <a href="javascript::" data-toggle="tooltip" data-placement="bottom" title="<?php echo $arrAirport->name; ?>"><?php echo $bid->arricao; ?></a>
                            </li>
                            <li>
                                <strong>飞机:</strong>
                                <?php echo $bid->aircraft; ?> (<?php echo $bid->registration?>)
                            </li>
                            <li>
                                <strong>票价:</strong>
                                <?php echo $bid->price; ?>￥
                            </li>
                            <li>
                                <strong>时长:</strong>
                                <?php echo date("H:i", strtotime($bid->flighttime));?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>航班选项</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                        $bidid = $bid->bidid;
                        $url = url('/schedules/brief/'.$bid->id);
                        $col = "col-md-12";
                        
                        $buttonname = '生成Simbrief简报';
                        $brief = Simbrief::getBrief(Auth::$userinfo->pilotid, $bidid);
                        if($brief) $col = "col-md-6";
                        echo "<div class=\"".$col."\">";
                        echo "<a href=\"".$url."\" class=\"btn btn-primary\" style=\"width: 100%\">".$buttonname."</a>";
                        echo "<br/><br/>";
                        echo "</div>";
                        if($brief){
                            $url = url('/SimBrief?ofp_id='.$brief->ofpid);
                            $buttonname = '查看Simbrief简报';
                            echo "<div class=\"".$col."\">";
                            echo "<a href=\"".$url."\" class=\"btn btn-primary\" style=\"width: 100%\">".$buttonname."</a>";
                            echo "<br/><br/>";
                            echo "</div>";
                        }
                    ?>
                    
                    
                    <div class="col-md-12">
                        <a id="<?php echo $bid->bidid; ?>" class="deleteitem btn btn-danger" href="<?php echo url('/schedules/removebid');?>" style="width: 100%">取消航班</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>备注</h4>
            </div>
            <div class="card-body">
                <blockquote><?php echo $bid->notes;?></blockquote>
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
                        if(!$bid->route) {
                            echo '无';
                        } else {
                            echo $bid->route;
                        }  
                    ?>
                </blockquote>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>计划地图</h4>
            </div>
            <div class="card-body p-0">
                <?php require 'bids_map.php'; ?>
            </div>
        </div>
    </div>
    <?php } } ?>
</div>

<!-- REMOVE BIDS HELPER - START -->
<script>
    $('.deleteitem').on('click', function() {
        var bid_id = $(this).attr("id");
        console.log(bid_id);
        $.ajax({
            type: "POST",
            url: "<?= url('/schedules/removebid') ?>",
            data:{
                id: bid_id
            },
            success:function(response) {
                $('#bid'+bid_id).fadeOut( "slow" );
                Swal.fire({
                    title: '完成', 
                    html: "你的航班已取消", 
                    icon: "success"
                }).then(function() {
                    window.location = "<?php echo SITE_URL; ?>";
                });
            },
            error:function(){
                Swal.fire({
                    title: '糟糕', 
                    html: "取消航班时出现了一点问题", 
                    icon: "error"
                }).then(function() {
                    window.location = "<?php echo SITE_URL; ?>";
                });
            }
        });
        
        return false;
    });
</script>
<!-- REMOVE BIDS HELPER - END -->
