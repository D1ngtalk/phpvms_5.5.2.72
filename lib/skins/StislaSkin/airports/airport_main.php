<!-- This airport info table and it's functionality was created by Adamm, and modified by Stuart Boardman-->
<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1>机场</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行员中心</a></div>
        <div class="breadcrumb-item">机场</div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
				<table class="table">
					<thead>
						<tr>
                            <th>ICAO</th>
                            <th>名称</th>
                            <th>国家或地区</th>
						</tr>
					</thead>
					<tbody>
                    <?php 
                        $allairports = OperationsData::GetAllAirports();
                        foreach ($allairports as $airport) {
                    ?>
						<tr>
							<td><?php echo '<a href=" '.SITE_URL.'/index.php/airports/get_airport?icao='.$airport->icao.'">'.$airport->icao.'</a>';?></td>
                            <td><?php echo $airport->name; ?> </td>
                            <td><?php echo $airport->country; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>