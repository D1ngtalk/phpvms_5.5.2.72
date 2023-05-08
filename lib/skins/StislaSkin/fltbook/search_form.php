<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<?php
    $pilotid = Auth::$userinfo->pilotid;
    $last_location = FltbookData::getLocation($pilotid);
    $last_name = OperationsData::getAirportInfo($last_location->arricao);
    if(!$last_location) {
        FltbookData::updatePilotLocation($pilotid, Auth::$userinfo->hub, TRUE);
    }
?>

<div class="section-header">
	<h1>预定航班</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item">预定航班</div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>航班查询</h4>
            </div>

            <div class="card-body">
                <form action="<?php echo url('/fltbook');?>" method="post">
                    <div class="alert alert-info">
                        <?php if($settings['search_from_current_location'] == 1) { ?>
                            <input id="depicao" name="depicao" type="hidden" value="<?php echo $last_location->arricao; ?>">
                            从 <?php echo $last_name->name; ?> (<?php echo $last_name->icao; ?>) 出发
                        <?php } else { ?>
                            从 <?php echo $last_name->name; ?> (<?php echo $last_name->icao; ?>) 出发
                        <?php } ?>
                    </div>

                    <?php if($settings['search_from_current_location'] == 0) { ?>
                    <div class="form-group">
                        <label>出发机场</label>
                        <select class="form-control" name="depicao">
                            <option value="" selected disabled>请选择</option>
                            <?php
                                foreach ($airports as $airport) {
                                    echo '<option value="'.$airport->icao.'">'.$airport->icao.' - '.$airport->name.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <?php } ?>

                    <div class="form-group">
                        <label>航司</label>
                        <select class="form-control" name="airline">
                            <option value="">所有</option>
                            <?php
                                foreach ($airlines as $airline) {
                                    echo '<option value="'.$airline->code.'">'.$airline->name.'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>飞机型号</label>
                        <select class="form-control" name="aircraft">
                            <option value="" selected>所有</option>
                            <?php
                                if($settings['search_from_current_location'] == 1) {
                                    $airc = FltbookData::routeaircraft($last_location->arricao);
                                    if(!$airc) {
                                        echo '<option>No Aircraft Available!</option>';
                                    } else {
                                        $lastaiicao = '';
                                        foreach ($airc as $air) {
                                            $ai = FltbookData::getaircraftbyID($air->aircraft);
                                            if(!strstr($lastaiicao, $ai->icao)){
                                                echo '<option value="'.$ai->icao.'">'.$ai->name.'</option>';
                                                $lastaiicao = $lastaiicao.$ai->icao;
                                            }
                                        }
                                    }
                                } else {
                                    $airc = FltbookData::routeaircraft_depnothing();
                                    if(!$airc) {
                                        echo '<option>No Aircraft Available!</option>';
                                    } else {
                                        $lastaiicao = '';
                                        foreach($airc as $ai) {
                                            if(!strstr($lastaiicao, $ai->icao)){
                                                echo '<option value="'.$ai->icao.'">'.$ai->name.'</option>';
                                                $lastaiicao = $lastaiicao.$ai->icao;
                                            }
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>目的地</label>
                        <select class="form-control" name="arricao">
                            <option value="">所有</option>
                            <?php
                                if($settings['search_from_current_location'] == 1) {
                                    $airs = FltbookData::arrivalairport($last_location->arricao);
                                    if(!$airs) {
                                        echo '<option>No Airports Available!</option>';
                                    } else {
                                        foreach ($airs as $air) {
                                            $nam = OperationsData::getAirportInfo($air->arricao);
                                            echo '<option value="'.$air->arricao.'">'.$air->arricao.' - '.$nam->name.'</option>';
                                        }
                                    }
                                } else {
                                    foreach($airports as $airport) {
                                        echo '<option value="'.$airport->icao.'">'.$airport->icao.' - '.$airport->name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <input type="hidden" name="action" value="search" />
                    <input type="submit" name="submit" value="查询" class="btn btn-primary mr-2" style="float: right;">
                </form>
            </div>
        </div>

        <?php if($settings['search_from_current_location'] == 1) { ?>
        <div class="card">
            <div class="card-header">
                <h4>加机组</h4>
            </div>

            <div class="card-body">
                <form action="<?php echo url('/Fltbook/jumpseat');?>" method="post">
                    <div class="form-group">
                        <label>目的地</label>
                        <select class="form-control" onchange="calculate_transfer(this.value)" name="depicao">
                            <option value="" selected disabled>请选择</option>
                            <?php
                                foreach($airports as $airport) {
                                    if($airport->icao == $last_location->arricao) {
                                        continue;
                                    }

                                    echo '<option value="'.$airport->icao.'">'.$airport->icao.' - '.$airport->name.'</option>';
                                }
                            ?>
                        </select>
                        <div style="margin-top: 5px;" id="errors"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>花费</label>
                                <input type="text" class="form-control" id="jump_purchase_cost" readonly>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>距离</label>
                                <input type="text" class="form-control" id="distance_travelling" readonly>
                            </div>
                        </div>
                    </div>

                    <input type="submit" id="purchase_button" disabled="disabled" class="btn btn-primary mr-1" style="float: right;" value="确认">
                    <input type="hidden" name="cost">
                    <input type="hidden" name="airport">
                </form>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>航线地图</h4>
            </div>

            <div class="card-body p-0">
                <?php require 'search_form_script.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php if($settings['search_from_current_location'] == 1) { ?>
<script type="text/javascript">
    function calculate_transfer(arricao) {
        var distancediv = $('#distance_travelling')[0];
        var costdiv     = $('#jump_purchase_cost')[0];
        var errorsdiv     = $('#errors')[0];
        errorsdiv.innerHTML = '';
        $.ajax({
            url: baseurl + "/action.php/Fltbook/get_jumpseat_cost",
            type: 'POST',
            data: { depicao: "<?php echo $last_location->arricao; ?>", arricao: arricao, pilotid: "<?php echo Auth::$userinfo->pilotid; ?>" },
            success: function(data) {
                data = $.parseJSON(data);
                console.log(data);
                if(data.error) {
                    $("#purchase_button").prop('disabled', true);
                    errorsdiv.innerHTML = "<font color='red'>没有足够的点数加机组！</font>";
                } else {
                    $("#purchase_button").prop('disabled', false);
                    distancediv.value = data.distance + "nm";
                    costdiv.value = data.total_cost + "￥";
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }
</script>
<?php } ?>
