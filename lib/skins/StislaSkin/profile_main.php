<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<?php 
    $pilotCode = PilotData::getPilotCode(Auth::$userinfo->code, Auth::$userinfo->pilotid);
    $userinfo = Auth::$userinfo;

    $hrs = intval($userinfo->totalhours);
    $min = ($userinfo->totalhours - $hrs) * 100;

    $last_location = FltbookData::getLocation($userinfo->pilotid);
    $last_name = OperationsData::getAirportInfo($last_location->arricao);
    if(!$last_location) {
        FltbookData::updatePilotLocation($pilotid, Auth::$userinfo->hub, TRUE);
        $last_location = FltbookData::getLocation($userinfo->pilotid);
    }

    $pireps = PIREPData::getAllReportsForPilot($userinfo->pilotid);
    $pirep_list = PIREPData::getAllReportsForPilot(Auth::$pilot->pilotid);

    $customfields = PilotData::getFieldData($userinfo->pilotid);
    $pilotdata = PilotData::getPilotData($userinfo->pilotid)
?>
<style>
    .contact-item:first-child {
		border: none;
		padding-top: 0;
		margin-top: 0;
	}

	.contact-item {
		color: #5b636a;
		align-items: flex-start;
		flex-wrap: wrap;
		padding: 10px 0 2px 0;
		display: flex;
		justify-content: space-between;
		margin-bottom: 0;
		font-size: 13px;
		border-top: 1px solid #dee2e6;
	}

	.contact-item:last-child{
		padding-bottom: 0;
	}

	.align-right {
		text-align: right;
	}
</style>

<div class="section-header">
    <h1>个人资料</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?php echo SITE_URL; ?>">控制台</a></div>
        <div class="breadcrumb-item">个人资料</div>
    </div>
</div>

<div class="section-body">

    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
                <div class="profile-widget-header">                     
                    <img alt="image" src="<?php echo PilotData::getPilotAvatar($pilotCode); ?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">航班数</div>
                            <div class="profile-widget-item-value"><?php echo $userinfo->totalflights; ?></div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">里程</div>
                            <div class="profile-widget-item-value"><?php echo StatsData::TotalPilotMiles($userinfo->pilotid); ?></div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">小时数</div>
                            <div class="profile-widget-item-value"><?php echo $hrs.'h '.$min.'m';?></div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name"><?php echo $userinfo->firstname.' '.$userinfo->lastname; ?>
                        <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> <?php echo $userinfo->email; ?></div>
                    </div>
                    <div class="contact-item">
                        <h6>国家或地区</h6>
                        <span class="float-right align-right">
                            <?php echo Countries::getCountryName(Auth::$userinfo->location); ?>
                            <img style="margin-left: 7px;" src="<?php echo Countries::getCountryImage(Auth::$userinfo->location); ?>" alt="<?php echo Countries::getCountryName($userinfo->location); ?>">
                        </span>
                    </div>
                    <?php
                        if($customfields) {
                            foreach($customfields as $field) {
                                echo '<div class="contact-item">';
                                echo '<h6>'.$field->title.'</h6>';
                                echo '<span class="float-right align-right">';
                                echo $field->value;
                                echo '</span>';
                                echo '</div>';
                            }
                        }
                    ?>
                    <div class="contact-item">
                        <h6>状态</h6>
                        <?php
                            if($pilot->retired == 0) {
                                echo '<span class="float-right align-right text-success">活跃</span>';
                            } elseif($pilot->retired == 1) {
                                echo '<span class="float-right align-right text-danger">不活跃</span>';
                            } else {
                                echo '<span class="float-right align-right text-primary">离职</span>';
                            }
                        ?>
                    </div>
                    
                    <div class="text-center">
                        <a href="<?php echo SITE_URL; ?>/index.php/profile/editprofile" class="btn btn-icon icon-left btn-primary btn-round">
                            <i class="far fa-edit"></i>
                            编辑资料
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <ul style="margin-bottom: 0;" class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                        <li class="media">
                            <?php if(!$nextrank) { $rankInfo = RanksData::getRankInfo(Auth::$userinfo->rankid); ?>
                            <img alt="image" class="mr-3" style="align-self: center;" width="50" src="<?php echo $rankInfo->rankimage; ?>">
                            <div class="media-body">
                                <div class="media-title"><?php echo $rankInfo->rank; ?></div>
                                <div class="text-job text-muted"><?php echo $rankInfo->minhours; ?> 小时</div>
                            </div>
                            <div class="media-progressbar">
                                <div class="progress-text">最高职级</div>
                                    <div class="progress" data-height="6" style="height: 6px;">
                                    <div class="progress-bar bg-primary" data-width="100%" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="media-cta">
                                <a href="#" class="btn btn-outline-primary">更多</a>
                            </div>
                            <?php } else { $percentage = ($pilot_hours/$nextrank->minhours) * 100; $round = round($percentage);?>
                            <img alt="image" class="mr-3" style="align-self: center;" width="50" src="<?php echo $nextrank->rankimage; ?>">
                            <div class="media-body">
                                <div class="media-title"><?php echo $nextrank->rank; ?></div>
                                <div class="text-job text-muted">还需 <?php echo $nextrank->minhours - $pilot_hours; ?> 小时</div>
                            </div>
                            <div class="media-progressbar">
                                <div class="progress-text"><?php echo $round ?>%</div>
                                    <div class="progress" data-height="6" style="height: 6px;">
                                    <div class="progress-bar bg-primary" data-width="<?php echo $round; ?>%" style="width: <?php echo $round; ?>%;"></div>
                                </div>
                            </div>
                            <div class="media-cta">
                                <a href="<?php echo SITE_URL;?>/index.php/career" class="btn btn-outline-primary">更多</a>
                            </div>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="contact-item">
                        <h6>钱包余额</h6>
                        <span class="float-right align-right">
                            <?php echo $pilotdata->totalpay;?>￥
                        <span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>航班地图</h4>
                    <div class="card-header-action">
                        <a data-toggle="modal" href="logbook_modal.php" data-target="#logbook" class="btn btn-primary">我的报告</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php
                        if(!$pireps) {
                            echo "
                            <div class='card-body'>
                                <div class='alert alert-primary mb-2' role='alert'>
                                    <strong>糟糕！</strong> 你看起来还没有任何航班！
                                </div>
                            </div>
                            ";
                        } else {
                            require 'flown_routes_map.php';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="statistic-details">
                        <div class="statistic-details-item">
                            <div class="detail-value text-primary">
                                <?php if($settings['search_from_current_location'] == 1) { ?>
                                <?php echo $last_name->icao; ?>
                                <?php } else { ?>
                                <?php echo $last_name->icao; ?>
                                <?php } ?>
                            </div>
                            <div class="detail-name">当前位置</div>
                        </div>
                        <div class="statistic-details-item">
                            <div class="detail-value text-primary"><?php echo $userinfo->hub; ?></div>
                            <div class="detail-name">基地</div>
                        </div>
                        <div class="statistic-details-item">
                            <div class="detail-value text-primary">
                                <?php
                                    $pireps = PIREPData::findPIREPS(array('p.pilotid' => Auth::$userinfo->pilotid));
                                    if(!$pireps) {
                                        echo '没有报告';
                                    } else {
                                        echo date("Y/m/d", strtotime($userinfo->lastpirep));
                                    }
                                ?>
                            </div>
                            <div class="detail-name">上一次报告</div>
                        </div>
                        <div class="statistic-details-item">
                            <div class="detail-value text-primary"><?php echo date("Y/m/d", strtotime($userinfo->joindate)); ?></div>
                            <div class="detail-name">入职时间</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
