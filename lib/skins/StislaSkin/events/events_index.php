<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
	<h1>活动</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item"><a href="javascript::">飞行中心</a></div>
        <div class="breadcrumb-item">活动</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
			<div class="card-header">
				<h4>即将到来的活动</h4>
			</div>
			<div class="card-body">
                <?php
                    if(!$events) {
                        echo '<div class="alert alert-danger"><div class="alert-title">糟糕</div>没有即将到来的活动</div>';
                    } else {
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">日期</th>
                            <th scope="col">活动</th>
                            <th scope="col">详情</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($events as $event) {
                                if($event->active == '2') {
                                    continue;
                                }

                                echo '<tr><td>'.date('n/j/Y', strtotime($event->date)).'</td>';
                                echo '<td>'.$event->title.'</td>';
                                echo '<td><a href="'.SITE_URL.'/index.php/events/get_event?id='.$event->id.'">详情</a></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
                <?php } ?>
			</div>
		</div>

        <div class="card">
			<div class="card-header">
				<h4>过去的活动</h4>
			</div>
			<div class="card-body">
                <?php
                    if(!$history) {
                        echo '<div class="alert alert-danger"><div class="alert-title">糟糕</div>没有过去的活动</div>';
                    } else {
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">日期</th>
                            <th scope="col">活动</th>
                            <th scope="col">详情</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($history as $event) {
                                echo '<tr><td>'.date('n/j/Y', strtotime($event->date)).'</td>';
                                echo '<td>'.$event->title.'</td>';
                                echo '<td><a href="'.SITE_URL.'/index.php/events/get_past_event?id='.$event->id.'">详情</a></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
                <?php } ?>
			</div>
		</div>
    </div>
</div>