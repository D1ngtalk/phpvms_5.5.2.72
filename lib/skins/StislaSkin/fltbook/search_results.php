<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>

<!-- Latest compiled and minified JavaScript - Modified to clear modal on data-dismiss -->
<script type="text/javascript" src="<?php echo SITE_URL; ?>/lib/js/bootstrap.js"></script>
<?php
	$pilotid = Auth::$userinfo->pilotid;
	$last_location 	= FltbookData::getLocation($pilotid);
	$last_name = OperationsData::getAirportInfo($last_location->arricao);
?>

<div class="section-header">
	<h1>预定航班</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item"><a href="<?php echo url('/fltbook') ;?>">航班查询</a></div>
        <div class="breadcrumb-item">查询结果</div>
    </div>
</div>

<div class="row">
	<div class="col-12 col-md-12">
		<div class="card">
            <div class="card-body">
				<div class="table-responsive">
					<table id="schedules_table" class="table table-striped table-bordered">
						<?php
							if(!$allroutes) {
								echo '<tr><td align="center">未找到航班！</td></tr>';
							} else {
						?>
						<thead>
							<tr>
								<th>航司</th>
								<th>航班号</th>
								<th>出发机场</th>
								<th>到达机场</th>
								<th>飞机型号</th>
								<th>时间/距离</th>
								<th style="text-align: center !important;">选项</th>
								<?php if($settings['show_details_button'] == 1) { ?> 
								<th style="display: none;">详情</th>
								<?php } ?>
							</tr>
						</thead>

						<tbody>
							<?php
								foreach($allroutes as $route) {
									if($settings['disabled_ac_sched_show'] == 0) {
										# Disable 'fake' aircraft to get hide a lot of schedules at once
										$aircraft = FltbookData::getAircraftByID($route->aircraftid);
										if($aircraft->enabled != 1) {
											continue;
										}
									}

									if(Config::Get('RESTRICT_AIRCRAFT_RANKS') == 1 && Auth::LoggedIn()) {
										if($route->aircraftlevel > Auth::$userinfo->ranklevel) {
											continue;
										}
									}
							?>
							<tr>
								<td scope="row"><?php echo $route->code; ?></td>
								<td><?php echo $route->code . $route->flightnum ?></td>
								<td><?php echo $route->depicao; ?></td>
								<td><?php echo $route->arricao; ?></td>
								<td><?php echo $route->aircraft; ?></td>
								<td><b>时间:</b> <?php echo $route->flighttime; ?>小时 <br> <b>距离:</b> <?php echo round($route->distance, 0, PHP_ROUND_HALF_UP); ?>海里</td>

								<td width="16.5%" align="center" valign="middle">
									<?php if($settings['show_details_button'] == 1) { ?>
										<input type="button" value="Details" class="btn btn-warning" onclick="$('#details_<?php echo $route->flightnum;?>').toggle()">
									<?php } ?>
									<?php
										$aircraft = OperationsData::getAircraftInfo($route->aircraftid);
										$acbidded = FltbookData::getBidByAircraft($aircraft->id);
										$check    = SchedulesData::getBidWithRoute(Auth::$userinfo->pilotid, $route->code, $route->flightnum);

										if(Config::Get('DISABLE_SCHED_ON_BID') == true && $route->bidid != 0) {
											echo '<div class="btn btn-danger btn-sm disabled">Booked</div>';
										} elseif($check) {
											echo '<div class="btn btn-danger btn-sm disabled">Booked</div>';
										} else {
											echo '<a data-toggle="modal" href="'.SITE_URL.'/action.php/fltbook/confirm?id='.$route->id.'&airline='.$route->code.'&aicao='.$route->aircrafticao.'" data-target="#confirm" class="btn btn-primary btn-md">预订</a>';
										}
									?>
								</td>

								<?php if($settings['show_details_button'] == 1) { ?>
								<td colspan="6" id="details_<?php echo $route->flightnum; ?>" style="display: none;" width="100%">
									<table class="table table-striped">
										<tr>
											<th align="center" bgcolor="black" colspan="6"><font color="white">Flight Briefing</font></th>
										</tr>
										<tr>
											<td>出发机场:</td>
											<td colspan="2"><strong>
												<?php
												$name = OperationsData::getAirportInfo($route->depicao);
												echo "{$name->name}";
												?></strong>
											</td>
											<td>到达机场:</td>
											<td colspan="2"><strong>
												<?php
												$name = OperationsData::getAirportInfo($route->arricao);
												echo "{$name->name}";
												?></strong>
											</td>
										</tr>
										<tr>
											<td>飞机</td>
											<td colspan="2"><strong>
												<?php
												$plane = OperationsData::getAircraftByName($route->aircraft);
												echo $plane->fullname;
												?></strong>
											</td>
											<td>距离:</td>
											<td colspan="2"><strong><?php echo $route->distance.Config::Get('UNITS'); ?></strong></td>
										</tr>
										<tr>
											<td>出发时间:</td>
											<td colspan="2"><strong><font color="red"><?php echo $route->deptime?> UTC</font></strong></td>
											<td>到达时间:</td>
											<td colspan="2"><strong><font color="red"><?php echo $route->arrtime?> UTC</font></strong></td>
										</tr>
										<tr>
											<td>高度:</td>
											<td colspan="2"><strong><?php echo $route->flightlevel; ?> ft</strong></td>
											<td>时长:</td>
											<td colspan="2">
												<font color="red">
													<strong>
													<?php
													$dist = $route->distance;
													$speed = 440;
													$app = $speed / 60;
													$flttime = round($dist / $app,0) + 20;
													$hours = intval($flttime / 60);
													$minutes = (($flttime / 60) - $hours) * 60;

													if($hours > "9" AND $minutes > "9") {
														echo $hours.':'.$minutes ;
													} else {
														echo '0'.$hours.':0'.$minutes ;
													}
													?> Hrs
													</strong>
												</font>
											</td>
										</tr>
										<tr>
											<td>日期:</td>
											<td colspan="2"><strong><?php echo Util::GetDaysLong($route->daysofweek); ?></strong></td>
											<td>票价:</td>
											<td colspan="2"><strong><?php echo $route->price ;?>.00￥</strong></td>
										</tr>
										<tr>
											<td>航班类型:</td>
											<td colspan="2"><strong>
											<?php
											if($route->flighttype == "P") {
												echo '客运';
											} elseif($route->flighttype == "C") {
												echo '货运';
											} elseif($route->flighttype == "H") {
												echo '调机';
											} else {
												echo '客运';
											}
											?>
											</strong></td>
											<td>Times Flown</td>
											<td colspan="2"><strong><?php echo $route->timesflown ;?></strong></td>
										</tr>
										<tr>
											<th align="center" bgcolor="black" colspan="6"><font color="white">Flight Map</font></th>
										</tr>
										<tr>
											<td width="100%" colspan="6">
											<?php
											$string = "";
											$string = $string.$route->depicao.'+-+'.$route->arricao.',+';
											?>
											<img width="100%" src="http://www.gcmap.com/map?P=<?php echo $string ?>&amp;MS=bm&amp;MR=240&amp;MX=680x200&amp;PM=pemr:diamond7:red%2b%22%25I%22:red&amp;PC=%230000ff" />
										</tr>
									</table>
								</td>
								<?php } ?>
							</tr>

							<?php } ?>
						</tbody>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>

		<center>
			<a href="<?php echo url('/fltbook') ;?>" class="btn btn-primary" name="submit">回到预定航班</a>
		</center>
	</div>
</div>

<!-- Pagination => Enable it via the module settings -->
<?php if($settings['pagination_enabled'] == 1) { ?>
	<!-- CSS DataTables -->
	<link rel="stylesheet" href="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/modules/datatables/datatables.min.css">
	<link rel="stylesheet" href="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

	<!-- JS DataTables -->
	<script src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/modules/datatables/datatables.min.js"></script>
	<script src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
	<script src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/modules/jquery-ui/jquery-ui.min.js"></script>

	<script type="text/javascript" charset="utf-8">
		$("#schedules_table").dataTable({
			"columnDefs": [{ "sortable": false, "targets": [2,3] 
			}]
		});
	</script>
<?php } ?>
