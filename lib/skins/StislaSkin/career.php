<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1>生涯</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行员中心</a></div>
        <div class="breadcrumb-item"><a href="javascript::">信息</a></div>
        <div class="breadcrumb-item">生涯</div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="card-header">
                <h4>飞行员职级</h4>
            </div>
            <div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="row">职级</th>
							<th scope="row">最低小时数</th>
							<th scope="row">时薪</th>
							<th scope="row">可用机型</th>
							<th scope="row">肩章</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($ranks as $rank) { ?>
						<tr>
							<td><?php echo $rank->rank; ?></td>
							<td><?php echo $rank->minhours; ?></td>
							<td><?php echo $rank->payrate; ?>￥/小时</td>
							<td> 
								<?php $rankai = CareerData::getaircrafts($rank->rankid); 
								if(!$rankai) {echo '所有机型';}
								else {
									$i = 0;
									foreach($rankai as $ran) {
										$i++;
										if($i > 1) echo ', ';
										echo $ran->icao;
									} 
								} ?></td>
							<td><img src="<?php echo $rank->rankimage; ?>" title="<?php echo $rank->rank; ?>" height = "25"/></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="card">
            <div class="card-header">
                <h4>奖项</h4>
            </div>
            <div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th scope="row">奖项</th>
							<th scope="row">描述</th>
							<th scope="row">图片</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!$generaward) {
							echo '<tr><td align="center" colspan="3">现在没有奖项！</td></tr>';
						} else {
							foreach($generaward as $gen) { ?>
						<tr>
							<td><?php echo $gen->name; ?></td>
							<td><?php echo $gen->descrip; ?></td>
							<td><img src="<?php echo $gen->image; ?>" title="<?php echo $gen->name; ?>" /></td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>