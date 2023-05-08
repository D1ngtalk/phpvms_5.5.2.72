<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1>机队</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行员中心</a></div>
        <div class="breadcrumb-item">机队</div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
				<table class="table">
					<thead>
						<tr>
							<th>注册号</th>
							<th>型号</th>
							<th>航程</th>
							<th>最大载客数</th>
							<th>最大装载量</th>
							<th>详情</th>
						</tr>
					</thead>
					<tbody>
					<?php if($aircrafts != null){ foreach($aircrafts as $aircrafts){ ?>
						<tr>
							<td><?php echo $aircrafts->registration; ?></td>
							<td><?php echo $aircrafts->fullname; ?></td>
							<td><?php echo $aircrafts->range; ?> 海里</td>
							<td><?php echo $aircrafts->maxpax; ?> 人</td>
							<td><?php echo $aircrafts->maxcargo; ?> kg</td>
							<td><a href="<?php echo url('fleet/view/' . $aircrafts->id); ?>">查看</a></td>
						</tr>
					<?php } }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>