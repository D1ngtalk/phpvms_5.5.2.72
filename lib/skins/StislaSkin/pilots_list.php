<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<div class="section-header">
    <h1><?php echo $title; ?></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item">飞行员列表</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php
            if(!$pilot_list) {
                echo '<div class="alert alert-danger"><div class="alert-title">没有飞行员</div>当前基地没有任何飞行员</div>';
                return;
            }
        ?>
        <div class="card">
            <div class="card-header">
                <h4>飞行员列表</h4>
            </div>
            <div class="card-body">
                <table id="tabledlist" class="table">
                    <thead>
                        <tr>
                            <th>飞行员ID</th>
                            <th>姓名</th>
                            <th>职级</th>
                            <th>航班数</th>
                            <th>小时数</th>
                            <th>基地</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pilot_list as $pilot) { ?>
                        <tr>
                            <td width="1%" nowrap><a href="<?php echo url('/profile/view/'.$pilot->pilotid);?>">
                                    <?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid)?></a>
                            </td>
                            <td>
                                <img src="<?php echo Countries::getCountryImage($pilot->location);?>" 
                                    alt="<?php echo Countries::getCountryName($pilot->location);?>" />
                                    
                                <?php echo $pilot->firstname.' '.$pilot->lastname?>
                            </td>
                            <td><img src="<?php echo $pilot->rankimage?>" alt="<?php echo $pilot->rank;?>" height = "25"/></td>
                            <td><?php echo $pilot->totalflights?></td>
                            <td><?php echo Util::AddTime($pilot->totalhours, $pilot->transferhours); ?></td>
                            <td><?php echo $pilot->hub; ?></td>
                            <td>
                                <?php
                                if($pilot->retired == 0) {
                                    echo '<span class="label label-success">活跃</span>';
                                } elseif($pilot->retired == 1) {
                                    echo '<span class="label label-danger">不活跃</span>';
                                } else {
                                    echo '<span class="label label-primary">离职</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>