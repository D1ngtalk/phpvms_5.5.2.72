<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<?php
    $uri = $_SERVER['REQUEST_URI'];
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "https://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $query = parse_url($url);

    $ofp_id = str_replace("ofp_id=", "", $query["query"]);

    $pilotid = Auth::$userinfo->pilotid;
    $bids = FltbookData::getBidsForPilot($pilotid);
    $bidid = NULL;
    
    if($bids) {
        foreach($bids as $bid) {
            $bidid = $bid->bidid;
        }
    }
    
    if($pilotid and $ofp_id and $bidid){
        Simbrief::updateBrief($pilotid, $bidid, $ofp_id);
    }
?>
<div class="section-header">
	<h1>Simbrief飞行简报</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item"><a href="javascript::">我的航班</a></div>
        <div class="breadcrumb-item">Simbrief飞行简报</div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>航班信息</h4>
                <div class="card-header-action">
                    <a target="_blank" href="<?php echo (string) $info->prefile[0]->vatsim->link; ?>" class="btn btn-primary" style="width: 100%">提交Vatsim计划</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" style="text-align: center;">
                        <h5><strong><?php echo (string) $info->general[0]->icao_airline.''.(string) $info->general[0]->flight_number; ?></strong></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-unstyled">
                            <h5><a href="javascript::" data-toggle="tooltip" data-placement="bottom" title="" data-original-title=""><?php echo (string) $info->origin[0]->icao_code;?></a></h5>
                            <p style="font-size:larger;margin:0;">RWY <?php echo $info->origin[0]->plan_rwy;?></p>
                            <strong><?php echo (string) $info->origin[0]->name;?><br>
                                <?php
                                    $epoch = (string) $info->times[0]->sched_out; 
                                    $dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
                                    echo $dt->format('H:i'); // output = 2012-08-15 00:00:00  
                                ?>
                            </strong>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-unstyled" style="text-align: center;">
                            <h6 style="margin:0;"><?php echo (string) $info->general[0]->route_distance; ?></h6>
                            <p style="margin:0;">海里</p>
                            <hr style="width:100%;margin:0 0 5px 0;">
                            <h6 style="margin:0;"><?php
                                $epoch = (string) $info->times[0]->est_block; 
                                $dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
                                echo $dt->format('H:i'); // output = 2012-08-15 00:00:00  
                            ?></h6>
                            <p style="margin:0;">飞行时间</p>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-unstyled" style="text-align: right;">
                            <h5><a href="javascript::" data-toggle="tooltip" data-placement="bottom" title="" data-original-title=""><?php echo (string) $info->destination[0]->icao_code;?></a></h5>
                            <p style="font-size:larger;margin:0;">RWY <?php echo $info->destination[0]->plan_rwy;?></p>
                            <strong><?php echo (string) $info->destination[0]->name;?><br>
                                <?php
                                    $epoch = (string) $info->times[0]->est_on; 
                                    $dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
                                    echo $dt->format('H:i'); // output = 2012-08-15 00:00:00  
                                ?>
                            </strong>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <li><strong>机型: </strong><?php echo (string) $info->aircraft[0]->name.'('.(string) $info->aircraft[0]->reg.')'; ?></li>
                        <li><strong>航高: </strong><?php echo (string) $info->general[0]->initial_altitude; ?>ft</li>
                        <li><strong>乘客: </strong><?php echo (string) $info->general[0]->passengers; ?></li>
                        <li><strong>成本指数: </strong><?php echo (string) $info->general[0]->costindex; ?></li>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-unstyled" style="text-align: right;">
                            <h5><a href="javascript::" data-toggle="tooltip" data-placement="bottom" title="" data-original-title=""><?php echo '*'.(string) $info->alternate[0]->icao_code;?></a></h5>
                            <p style="font-size:larger;margin:0;">RWY <?php echo $info->alternate[0]->plan_rwy;?></p>
                            <strong><?php echo (string) $info->alternate[0]->name;?></strong>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>计划航路</h4>
                <script type="text/javascript">
                    function download(d) {
                            if (d == '下载航路文件') return;
                            window.open('https://www.simbrief.com/ofp/flightplans/' + d);
                    }
                </script>
    
                <select name="download" class="form-control" style="width:min-content;margin-left: auto;" onchange="download(this.value)">
                    <option>下载航路文件</option>
                    <option value="<?php echo $info->files->pdf->link; ?>"><?php echo $info->files->pdf->name; ?></option>
                    <?php foreach($info->files->file as $file) { ?>
                        <option value="<?php echo $file->link; ?>"><?php echo $file->name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="card-body">
                <blockquote><?php echo (string) $info->general[0]->route; ?></blockquote>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>METAR报文</h4>
                <div class="card-header-action">
                    <a href="<?php echo SITE_URL;?>/index.php/Weather" target="_blank" class="btn btn-primary">天气查询</a>
                </div>
            </div>
            <div class="card-body">
                <p style="margin: 0;"><?php echo (string) $info->origin[0]->icao_code;?></p>
                <textarea rows="8" cols="80" readonly="" name="origmetar" style="overflow: auto;" id="origmetar" class="form-control"><?php echo (string) $info->weather[0]->orig_metar; ?></textarea>
                <hr style="width:100%;margin:10px 0 0 0;">
                <p style="margin: 0;"><?php echo (string) $info->destination[0]->icao_code;?></p>
                <textarea rows="8" cols="80" readonly="" name="destmetar" style="overflow: auto;" id="destmetar" class="form-control"><?php echo (string) $info->weather[0]->dest_metar; ?></textarea>
                <hr style="width:100%;margin:10px 0 0 0;">
                <p style="margin: 0;"><?php echo (string) $info->alternate[0]->icao_code;?></p>
                <textarea rows="8" cols="80" readonly="" name="altnmetar" style="overflow: auto;" id="altnmetar" class="form-control"><?php echo (string) $info->weather[0]->altn_metar; ?></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>飞行简报</h4>
            </div>
            <div class="card-body">
                <iframe src="https://www.simbrief.com/ofp/flightplans/<?php echo $info->files->pdf->link; ?>" width="100%" height="700px"></iframe>
            </div>
        </div>
    </div>
</div>