<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<style>
    .routeimg {
        height: 35px;
        margin-right: 3px;
    }
</style>
<div class="section-header">
	<h1>Simbrief简报</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item"><a href="javascript::">我的航班</a></div>
        <div class="breadcrumb-item">Simbrief简报</div>
    </div>
</div>

<form id="sbapiform">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>飞行计划简报</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="row">航司</th>
                                    <th scope="row">航班号</th>
                                    <th scope="row">出发机场</th>
                                    <th scope="row">到达机场</th>
                                    <th scope="row">距离</th>
                                    <th scope="row">日期</th>
                                    <th scope="row">离场时间(UTC)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $schedule->code.$schedule->airline; ?></td>
                                    <td><?php echo $schedule->code.$schedule->flightnum; ?></td>
                                    <td><?php echo "{$schedule->depname} ($schedule->depicao)"; ?></td>
                                    <td><?php echo "{$schedule->arrname} ($schedule->arricao)"; ?></td>
                                    <td><?php echo "{$schedule->distance}"; ?></td>
                                    <td>
                                        <input class="form-control datepicker" name="date" type="text" id="datepicker">
                                    </td>

                                    <td>
                                        <?php
                                            date_default_timezone_set("UTC");
                                            $r = range(0, 23);
                    
                                            $selected = date('H', strtotime('+20 minute', time()));
                                            $select = "<select class='form-control' style='width: 45%; display: inline;' name=deph id=dephour>\n";
                                            foreach ($r as $hour)
                                            {
                                                    $select .= "<option value=\"$hour\"";
                                                    $select .= ($hour==$selected) ? ' selected="selected"' : '';
                                                    $select .= ">$hour</option>\n";
                                            }
                                            $select .= '</select>';
                                            echo $select;
                                            echo":";
                                            $rminutes = range(0, 59);

                                            $selected = date('i', strtotime('+20 minute', time()));
                                            $selectminutes = "<select class='form-control' style='width: 45%; display: inline;' name=depm id=depminute>\n";
                                            foreach ($rminutes as $minutes) {
                                                    $selectminutes .= "<option value=\"$minutes\"";
                                                    $selectminutes .= ($minutes==$selected) ? ' selected="selected"' : '';
                                                    $selectminutes .= ">$minutes</option>\n";
                                            }
                                            $selectminutes .= '</select>';
                                            echo $selectminutes;
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>飞行计划选项</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>机型:</td>
                            <td>
                                <select class="form-control" name="type">
                                    <?php
                                        $bids = FltbookData::getBidsForPilot(Auth::$userinfo->pilotid);
                                        $aircraft = NULL;
                                        $registration = NULL;
                                        if($bids) {
                                            foreach($bids as $bid) {
                                                $aircraft = $bid->aircraft;
                                                $registration = $bid->registration;
                                            }
                                        } 
                                        $equipment = OperationsData::getAllAircraftSingle(true);
                                        if(!$equipment) $equipment = array();
                                        foreach($equipment as $equip) {
                                            $sel = ($equip->name == $aircraft) ? ' selected' : '';
                                            echo '<option value="'.$equip->icao.'"'.$sel.'>'.$equip->icao.' - '.$equip->name.'</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>巡航高度:</td>
                            <td><input class="form-control" name="fl" size="5" type="text" placeholder="留空自动生成" maxlength="5" value="<?php echo "$schedule->flightlevel"; ?>"></td>
                        </tr>
                        <tr>
                            <td>成本指数:</td>
                            <td><input class="form-control" name="civalue" size="5" type="text" placeholder="留空自动生成" maxlength="2" value="35"></td>
                        </tr>
                        <tr>
                            <td>单位:</td>
                            <td><select class="form-control" name="units"><option value="KGS" selected>KGS</option><option value="LBS">LBS</option></select></td>
                        </tr>
                        <tr>
                            <td>耗油量: </td>
                            <td><select class="form-control" name="contpct"><option value="auto" selected>AUTO</option><option value="0">0 PCT</option><option value="0.02">2 PCT</option><option value="0.03">3 PCT</option><option value="0.05">5 PCT</option><option value="0.1">10 PCT</option><option value="0.15">15 PCT</option><option value="0.2">20 PCT</option></select></td>
                        </tr>
                        <tr>
                            <td>额外燃油: </td>
                            <td><select class="form-control" name="resvrule"><option value="auto">AUTO</option><option value="0">0 MIN</option><option value="15">15 MIN</option><option value="30">30 MIN</option><option value="45" selected>45 MIN</option><option value="60">60 MIN</option><option value="75">75 MIN</option><option value="90">90 MIN</option></select></td>
                        </tr>	
                        <tr>
                            <td>导航详情: </td>
                            <td><input type="hidden" name="navlog" value="0"><input type="checkbox" name="navlog" value="1" checked></td>
                        </tr>
                        <tr>
                            <td>计划ETOPS: </td>
                            <td><input type="hidden" name="etops" value="0"><input type="checkbox" name="etops" value="1"></td>
                        </tr>
                        <tr>
                            <td>计划Stepclimbs: </td>
                            <td><input type="hidden" name="stepclimbs" value="0"><input type="checkbox" name="stepclimbs" value="1"></td>
                        </tr>
                        <tr>
                            <td>跑道分析: </td>
                            <td><input type="hidden" name="tlr" value="0"><input type="checkbox" name="tlr" value="1" checked></td>
                        </tr>
                        <tr>
                            <td>包含NOTAMS: </td>
                            <td><input type="hidden" name="notams" value="0"><input type="checkbox" name="notams" value="1" checked></td>
                        </tr>
                        <tr>
                            <td>情报区NOTAMS: </td>
                            <td><input type="hidden" name="firnot" value="0"><input type="checkbox" name="firnot" value="1"></td>
                        </tr>
                        <tr>
                            <td>飞行地图: </td>
                            <td><select class="form-control" name="maps"><option value="detail">Detailed</option><option value="simple">Simple</option><option value="none">None</option></select></td>
                        </tr>
                        <tr>
                            <td>计划格式:</td>
                            <td><select class="form-control" onchange="" name="planformat" id="planformat"><option value="lido" selected="">LIDO</option><option value="aal">AAL</option><option value="aca">ACA</option><option value="afr">AFR</option><option value="awe">AWE</option><option value="baw">BAW</option><option value="ber">BER</option><option value="dal">DAL</option><option value="dlh">DLH</option><option value="ezy">EZY</option><option value="gwi">GWI</option><option value="jbu">JBU</option><option value="jza">JZA</option><option value="klm">KLM</option><option value="ryr">RYR</option><option value="swa">SWA</option><option value="uae">UAE</option><option value="ual">UAL</option><option value="ual f:wz">UAL F:WZ</option></select></td> 
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>航路计划</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>
                                <span class="disphead">航路</span> (<a href="https://www.simbrief.com/system/guide.php#routeguide" target="_blank">?</a>)
                                <span style="font-size:14px;font-weight:bold;padding:0px 5px">&rarr;</span>
                                <a href="https://flightaware.com/analysis/route.rvt?origin=<?php echo $schedule->depicao ; ?>&destination=<?php echo $schedule->arricao ; ?>" id="falink" target="_blank">
                                <img class="routeimg" src="<?php echo fileurl('/lib/skins/StislaSkin/assets/img/logos/flightaware.png');?>" alt="Flightaware" title="FlightAware"></a> 
                                <a href="https://skyvector.com/?chart=304&zoom=6&fpl=<?php echo $schedule->depicao ; ?>%20%20<?php echo $schedule->arricao ; ?>" id="sklink" target="_blank">
                                <img class="routeimg" src="<?php echo fileurl('/lib/skins/StislaSkin/assets/img/logos/routes_skv.png');?>" alt="SkyVector" title="SkyVector"></a>
                                <a href="https://rfinder.asalink.net/free/" id="rflink" target="_blank">
                                <img class="routeimg" src="<?php echo fileurl('/lib/skins/StislaSkin/assets/img/logos/routefinder.png');?>" alt="RouteFinder" title="RouteFinder"></a>
                                <a target="_blank" style="cursor:pointer" onclick="validate_cfmu();">
                                <img class="routeimg" src="<?php echo fileurl('/lib/skins/StislaSkin/assets/img/logos/euro-ctl.png');?>" alt="CFMU Validation" title="CFMU Validation"></a>
                            </td>
                        </tr>
                        <tr>
                            <td><textarea class="form-control" name="route" placeholder="请输入航路，留空自动生成"><?php echo $schedule->route; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><em><strong>注意: 在生成简报前请删除您航路内所有的 &quot;SID&quot; 和 &quot;STAR&quot;。</strong></em></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- <p><em><strong>Note: Remember to sign up for your free <a href="https://www.simbrief.com" title="Sign up for SimBrief">SimBrief</a> account before using this feature. It won't work without it!</strong></em></p>    -->
            <button type="button" style="width:100%" class="btn btn-primary btn-lg" onclick="simbriefsubmit('<?php echo SITE_URL; ?>/index.php/SimBrief');" style="font-size:30px" value="Generate SimBrief">生成Simbrief简报</button>
            <input type="hidden" name="orig" value="<?php echo "$schedule->depicao"; ?>">
            <input type="hidden" name="dest" value="<?php echo "$schedule->arricao"; ?>">
            <input type="hidden" name="airline" value="<?php echo $schedule->code?>"> 
            <input type="hidden" name="fltnum" value="<?php echo $schedule->flightnum?>"> 
            <input type="hidden" name="reg" value="<?php echo $registration?>">
            <input type="hidden" name="cruise" value="CI">
    	</div>
    </div>
</form>
