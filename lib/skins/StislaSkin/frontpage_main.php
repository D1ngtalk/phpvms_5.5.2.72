<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<?php if(Auth::LoggedIn()) { ?>
<?php
	$userinfo = Auth::$userinfo;
	
	$pilotid = Auth::$userinfo->pilotid;
    $last_location = FltbookData::getLocation($pilotid);
    if(!$last_location) {
        FltbookData::updatePilotLocation($pilotid, Auth::$userinfo->hub, TRUE);
    }

	$hrs = intval($userinfo->totalhours);
	$min = ($userinfo->totalhours - $hrs) * 100;

	$touchstats = TouchdownStatsData::pilot_average($userinfo->pilotid);

	$events = EventsData::get_upcoming_events();

	$config = json_decode(file_get_contents(SITE_URL.'/lib/skins/StislaSkin/config.json'));

	if($config->dashboard == "1" || $config->dashboard == null) {
?>

<!-- <div class="section-header">
	<h1>控制台</h1>
</div> -->
	</p>
<div class="row">
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<div class="card-icon bg-primary">
				<i class="fas fa-book"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>提交的报告</h4>
				</div>
				<div class="card-body"><?php echo $userinfo->totalflights; ?></div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<div class="card-icon bg-danger">
				<i class="fas fa-route"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>总计里程</h4>
				</div>
				<div class="card-body"><?php echo StatsData::TotalPilotMiles($userinfo->pilotid); ?>nm</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<div class="card-icon bg-info">
				<i class="fas fa-clock"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>飞行时长</h4>
				</div>
				<div class="card-body"><?php echo $hrs.'h '.$min.'m';?></div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-12">
		<div class="card card-statistic-1">
			<div class="card-icon bg-success">
				<i class="fas fa-plane-arrival"></i>
			</div>
			<div class="card-wrap">
				<div class="card-header">
					<h4>平均接地率</h4>
				</div>
				<div class="card-body"><?php echo substr($touchstats, 0, 4); ?> FPM</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-8 col-md-12 col-12 col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4>在线地图</h4>
			</div>
			<div class="card-body p-0">
				<?php require 'acarsmap.php'; ?>
			</div>
		</div>

		<?php
			$lastbids = SchedulesData::GetAllBids();
			$countBids = (is_array($lastbids) ? count($lastbids) : 0);
		?>
		<div class="card">
			<div class="card-header">
				<h4>当前航班</h4>
				<div class="card-header-action">
					<a class="btn btn-icon btn-primary" href="<?php echo SITE_URL;?>/index.php/fltbook">预定航班</a>
				</div>
			</div>
			<div class="card-body">
				<?php if(!$countBids) { ?>
				<div class="alert alert-danger">
					<div class="alert-title">糟糕</div>
					看起来现在没有已预定的航班，点击上方的预定航班来预定吧！
				</div>
				<?php } else { ?>
			<div class="table-responsive">
				<table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>
                                <div align="center">航班号</div>
                            </th>
                            <th>
                                <div align="center">飞行员</div>
                            </th>
                            <th>
                                <div align="center">预定时间</div>
                            </th>
                            <th>
                                <div align="center">出发机场</div>
                            </th>
                            <th>
                                <div align="center">到达机场</div>
                            </th>
                            <th>
                                <div align="center">注册号</div>
                            </th>
							<th>
                                <div align="center">网络</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							foreach($lastbids as $lastbid) {
								$flightid = $lastbid->id
						?>
						<tr>
							<td height="25" width="10%" align="center"><font face="Bauhaus"><span><?php echo $lastbid->code; ?><?php echo $lastbid->flightnum; ?></span></font></td>
							<?php
								$params = $lastbid->pilotid;
								$liveflight = ACARSData::get_flight_by_pilot($params);
								$pilot = PilotData::GetPilotData($params);
								$bid = FltbookData::getBid($lastbid->bidid);
								// var_dump($bid);
								$pname = $pilot->firstname;
								$psurname = $pilot->lastname;
								$now = strtotime(date('d-m-Y',strtotime($lastbid->dateadded)));
								$date = date("d-m-Y", strtotime('+48 hours', $now));
							?>
							<td height="25" width="15%" align="center"><span><?php echo '<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="点击查看飞行员信息" href="  '.SITE_URL.'/index.php/profile/view/'.$pilot->pilotid.'">'.$pname.'</a>';?></span></td>
							<td height="25" width="15%" align="center"><span><?php echo date('Y-m-d',strtotime($lastbid->dateadded)); ?></span></td>
							<td height="25" width="10%" align="center"><span><font face=""><?php echo '<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="点击查看机场信息" href="  '.SITE_URL.'/index.php/airports/get_airport?icao='.$lastbid->depicao.'">'.$lastbid->depicao.'</a>';?></font></span></td>
							<td height="25" width="10%" align="center"><span><font face=""><?php echo '<a class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="点击查看机场信息" href="'.SITE_URL.'/index.php/airports/get_airport?icao='.$lastbid->arricao.'">'.$lastbid->arricao.'</a>';?></font></span></td>
							<td height="25" width="10%" align="center"><span><a class="btn btn- btn-sm" data-toggle="tooltip" data-placement="top" title="点击查看飞机信息" href="<?php echo SITE_URL?>/index.php/Fleet/view/<?php echo '' . $bid->aircraftid . ''; ?>"><?php echo $bid->registration; ?></a></td>
							<td height="25" width="10%" align="center"><span>
							<?php 
								if(!$liveflight->online or $liveflight->online == 'Offline'){
									echo '离线';
								}else{
									echo $liveflight->online; 
								}
							?>
							</span></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="col-lg-4 col-md-12 col-12 col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4>航司通告</h4>
				<div class="card-header-action">
					<a data-collapse="#collapse" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a>
				</div>
			</div>
			<div class="collapse show" id="collapse">
				<div class="card-body">
					<?php MainController::Run('News', 'ShowNewsFront', 1); ?>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h4>飞行员排行</h4>
				<div class="card-header-action">
					<a class="btn btn-icon btn-primary" href="javascript::">按小时</a>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="row">飞行员</th>
								<th scope="row">班次</th>
								<th scope="row">里程</th>
								<th scope="row">小时</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$all_hours = TopPilotData::alltime_hours(5);
								foreach($all_hours as $all) {
									$pilot = PilotData::GetPilotData($all->pilotid);
							?>
							<tr>
								<td><a href="<?php echo SITE_URL.'/index.php/profile/view/'.$pilot->pilotid?>"><?php echo $pilot->firstname.' ('.PilotData::GetPilotCode($pilot->code, $pilot->pilotid); ?>)</a></td>
								<td><?php echo $pilot->totalflights; ?></td>
								<td><?php echo StatsData::TotalPilotMiles($pilot->pilotid); ?></td>
								<td><b><?php echo $all->totalhours; ?></b></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<?php
			if($config->discordID) {
		?>
		<div class="card">
		<iframe src="https://discordapp.com/widget?id=<?php echo $config->discordID; ?>&theme=dark" height="400" allowtransparency="true" frameborder="0"></iframe>
			</div>
		<?php } ?>

		<?php
			if($event) {
				foreach($events as $event) {
		?>
		<div class="card">
			<div class="card-header">
				<h4>最近的活动</h4>
				<div class="card-header-action">
					<a href="<?php echo SITE_URL.'/index.php/events/get_event?id='.$event->id; ?>" class="btn btn-info"><?php echo $event->title; ?></a>
				</div>
			</div>
			<div class="card-body p-0">
				<a href="<?php echo SITE_URL.'/index.php/events/get_event?id='.$event->id; ?>">
					<img class="img-fluid" src="<?php echo $event->image; ?>" alt="<?php echo $event->title; ?>">
				</a>
			</div>
		</div>
		<?php break; } } ?>
	</div>
</div>
<?php
		} else {
			require 'frontpage_main_two.php';
		}
	} else {
		header('Location:'.SITE_URL.'/index.php/login');
	}
?>
