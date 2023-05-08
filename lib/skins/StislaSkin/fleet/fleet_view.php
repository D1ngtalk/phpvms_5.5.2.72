<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1><?php echo $basicinfo->registration; ?></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行员中心</a></div>
        <div class="breadcrumb-item"><a href="javascript::">机队</a></div>
        <div class="breadcrumb-item"><?php echo $basicinfo->registration; ?></div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
			<div class="card-header">
				<h4>基本信息</h4>
			</div>
            <div class="card-body">
				<table class="table">
					<tbody>
						<tr>
							<td rowspan="4"><img src="<?php echo $basicinfo->imagelink; ?>" alt="No Images Available" width="160px"/></td>
							<td><strong>型号: </strong> <?php echo $basicinfo->fullname . "(" . $basicinfo->icao . ")"; ?></td>
							<td><strong>航程: </strong> <?php echo $basicinfo->range; ?> 海里</td>
						</tr>
						<tr>
							<td><strong>最大装载量: </strong> <?php echo $basicinfo->maxcargo; ?> kg</td>
							<td><strong>最大载客数: </strong> <?php echo $basicinfo->maxpax; ?> 人</td>
						</tr>
						<tr>
							<td><strong>零油重: </strong> <?php echo $basicinfo->weight; ?> kg</td>
							<td><strong>最大高度: </strong> <?php echo $basicinfo->cruise; ?> ft</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h4>详细信息</h4>
			</div>
            <div class="card-body">
				<table class="table">
					<tbody>
						<tr>
							<td><strong>平均每次飞行耗油量: </strong><?php echo round($detailedinfo['AvgFuel'], 2); ?> kg</td>
							<td><strong>总耗油量: </strong> <?php echo round($detailedinfo['totalFuel'], 2); ?> kg</td>
							<td><strong>耗油率: </strong> <?php echo round($detailedinfo['fuelConsumption'], 2); ?> kg/海里</td>
						</tr>
						<tr>
							<td><strong>平均每次飞行里程: </strong> <?php echo round($detailedinfo['fuelConsumption'], 2); ?> 海里</td>
							<td><strong>总里程: </strong> <?php echo round($detailedinfo['TotalFlightDistance'], 2); ?> 海里</td>
							<td><strong>平均收益: </strong> <?php echo round($detailedinfo['AvgRevenue'], 2); ?>￥</td>
						</tr>
						<tr>
							<td><strong>总收益: </strong> <?php echo round($detailedinfo['totalRevenue'], 2); ?>￥</td>
							<td><strong>总花费: </strong> <?php echo round($detailedinfo['totalExpenses'], 2); ?>￥</td>
							<td><strong>购买日期: </strong><?php echo date('Y/m/d', strtotime($purchasedate->datestamp)); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h4>最近的航班</h4>
			</div>
            <div class="card-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="row">航班号</th>
							<th scope="row">出发机场</th>
							<th scope="row">到达机场</th>
							<th scope="row">飞行员</th>
							<th scope="row">距离</th>
							<th scope="row">收益</th>
							
							<th>接地率</th>
						</tr>
					</thead>
					<tbody><?php if($recentflights != null){foreach($recentflights as $recentflight){ ?>
						<tr>
							<td><a href="<?php echo url('pireps/view/' . $recentflight->pirepid); ?>/" ><?php echo $recentflight->code . " " . $recentflight->flightnum; ?></a></td>
							<td><?php echo $recentflight->depicao; ?></td>
							<td><?php echo $recentflight->arricao; ?></td>
							<td><?php echo PilotData::getPilotData($recentflight->pilotid)->firstname. " " .PilotData::getPilotData($recentflight->pilotid)->lastname; ?></td>
							<td><?php echo $recentflight->distance; ?> 海里</td>
							<td style="color:<?php if($recentflight->revenue >0){ echo 'green'; }else{ echo 'red'; } ?> ;"><?php echo $recentflight->revenue; ?>￥</td>
						
							<td><?php echo $recentflight->landingrate; ?>ft/min</td>
							
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h4>排班表</h4>
			</div>
            <div class="card-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>航班号</th>
							<th>出发机场</th>
							<th>到达机场</th>
							<th>出发时间</th>
							<th>到达时间</th>
							<th>距离</th>
							<th>时长</th>
						</tr>
					</thead>
					<tbody>
						<?php if($scheduledflights != null){foreach($scheduledflights as $scheduledflights){ ?>
						<tr>
							<td><?php echo $scheduledflights->code . " " . $scheduledflights->flightnum; ?></td>
							<td><?php echo $scheduledflights->depicao; ?></td>
							<td><?php echo $scheduledflights->arricao; ?></td>
							<td><?php echo $scheduledflights->deptime; ?></td>
							<td><?php echo $scheduledflights->arrtime; ?></td>
							<td><?php echo $scheduledflights->distance; ?> 海里</td>
							<td><?php echo $scheduledflights->flighttime; ?> 小时</td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>