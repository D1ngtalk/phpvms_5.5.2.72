<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<?php 
    $pilotcode = PilotData::getPilotCode(Auth::$userinfo->code, Auth::$userinfo->pilotid);
    $pilot = PilotData::getPilotData(Auth::$userinfo->pilotid);

    if(Config::Get('TRANSFER_HOURS_IN_RANKS') == true) {
        $totalhours = $pilot->totalhours + $pilot->transferhours;
    } else {
        $totalhours = $pilot->totalhours;
    }

    $pilot_hours = $totalhours;
    $nextrank = RanksData::getNextRank($totalhours);

    $item = MailData::checkformail();
    $items = $item->total;

    $mailTop = MailData::getallmail(Auth::$userinfo->pilotid);

    $config = json_decode(file_get_contents(SITE_URL.'/lib/skins/StislaSkin/config.json'));
?>

<style>
    .main-sidebar-user {
        display: inline-block;
        width: 100%;
        padding: 10px;
        margin-left: 9px;
    }

    .nav-profile-image, .nav-profile-image img {
        width: 55px;
        height: 55px;
        float: left;
    }

    .nav-profile-info {
        margin-left: 5rem;
        margin-top: 8px;
    }

    .nav-profile-text {
        font-size: 15px;
        font-weight: 600;
        line-height: 23px;
        color: black;
    }

    .nav-profile-link {
        font-size: 14px;
    }

    .no-margin {
        color: #c3bdbd !important;
        margin-left: 0px !important;
        margin-right: 14px !important;
    }
    
    .nav-profile-info a:hover {
        color: #242424 !important;
    }

    .no-margin i {
        margin-left: 0px !important;
    }

    body.sidebar-mini .main-sidebar .mini {
        display: none;
    }
</style>

<div id="app">
    <!-- Main Wrapper -->
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                <li>
                    <a href="javascript::" class="nav-link nav-link-lg nav-link-user">
                        <script type="text/javascript">
                            var timeInterval = setInterval(display_ct, 1000);

                            function display_ct() {
                                var x = new Date();
                                var x1 = x.getUTCHours().toString().padStart(2, '0') + ":" +  x.getUTCMinutes().toString().padStart(2, '0') + ":" +  x.getUTCSeconds().toString().padStart(2, '0');
                                document.getElementById('utcTimer').innerHTML = x1;
                            }
                        </script>
                        <div style="margin-top: 4px; font-size: 15px;">
                            <span style="margin-top: 5px;" id="utcTimer"></span>
                            <span style="margin-top: 5px; font-size: 11px;"> UTC</span>
                        </div>
                    </a>
                </li>

                <li class="dropdown dropdown-list-toggle">
                    <?php if($items == "0") { ?>
                    <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i class="far fa-envelope"></i></a>
                    <?php } else { ?>
                    <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                    <?php } ?>

                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">信息
                            <div class="float-right">
                            <a href="<?php echo SITE_URL ?>/index.php/Mail/newmail">新信息</a>
                            </div>
                        </div>
                        <div class="dropdown-list-content dropdown-list-message">
                            <?php
                                if(!$mailTop) {
                                    echo '<center>当前没有信息</center>';
                                } else {
                                    foreach($mailTop as $dataTop) { 
                                        $userMail = PilotData::GetPilotData($dataTop->who_from); 
                                        $pilotMail = PilotData::GetPilotCode($userMail->code, $dataTop->who_from); 
                            ?>
                            <a href="<?php echo SITE_URL ?>/index.php/Mail/item/<?php echo $dataTop->thread_id;?>" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-avatar">
                                    <img alt="image" src="<?php echo PilotData::getPilotAvatar($pilotMail); ?>" class="rounded-circle">
                                </div>
                                <div class="dropdown-item-desc">
                                    <b><?php echo "$userMail->firstname $userMail->lastname"; ?></b>
                                    <p><?php echo $dataTop->subject; ?></p>
                                    <div class="time" style="margin-top: 0px;"><?php echo MailData::timeago($dataTop->date); ?></div>
                                </div>
                            </a>
                            <?php } } ?>
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="<?php echo SITE_URL; ?>/index.php/mail">查看全部 <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>

                <?php
                    if(PilotGroups::group_has_perm(Auth::$usergroups, ACCESS_ADMIN)) {
                        
                    $pendingpireps = (is_array(PIREPData::findPIREPS(array('p.accepted' => PIREP_PENDING))) ? count(PIREPData::findPIREPS(array('p.accepted' => PIREP_PENDING))) : 0);
                    $pendingpilots = (is_array(PilotData::findPilots(array('p.confirmed' => PILOT_PENDING))) ? count(PilotData::findPilots(array('p.confirmed' => PILOT_PENDING))) : 0);
                    
                    $count = ($pendingpireps + $pendingpilots);
                ?>
                <li class="dropdown dropdown-list-toggle">
                    <?php if(!$count) { ?>
                    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
                    <?php } else { ?>
                    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a> 
                    <?php } ?>

                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">管理员消息</div>
                        <div class="dropdown-list-content dropdown-list-icons">
                            <a href="<?php echo SITE_URL;?>/admin/index.php/pilotadmin/pendingpilots" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-icon bg-primary text-white">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    <?php echo (is_array(PilotData::GetPendingPilots()) ? count(PilotData::GetPendingPilots()) : 0); ?>个待审核的注册
                                    <div class="time text-primary" style="margin-top: 0px;">点击查看</div>
                                </div>
                            </a>

                            <a href="<?php echo SITE_URL;?>/admin/index.php/pirepadmin/viewpending" class="dropdown-item">
                                <div class="dropdown-item-icon bg-info text-white">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    <?php echo (is_array(PIREPData::GetAllReportsByAccept(PIREP_PENDING)) ? count(PIREPData::GetAllReportsByAccept(PIREP_PENDING)) : 0); ?>个待审核的报告
                                    <div class="time text-primary" style="margin-top: 0px;">点击查看</div>
                                </div>
                            </a>

                            <a href="<?php echo SITE_URL;?>/admin/index.php/sitecms/viewnews" class="dropdown-item">
                                <div class="dropdown-item-icon bg-success text-white">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    新闻列表
                                    <div class="time text-primary" style="margin-top: 0px;">点击查看</div>
                                </div>
                            </a>

                            <a href="<?php echo SITE_URL;?>/admin/index.php/downloads/overview" class="dropdown-item">
                                <div class="dropdown-item-icon bg-danger text-white">
                                    <i class="fas fa-download"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    下载列表
                                    <div class="time text-primary" style="margin-top: 0px;">点击查看</div>
                                </div>
                            </a>

                            <a href="<?php echo SITE_URL;?>/admin/index.php/operations/schedules" class="dropdown-item">
                                <div class="dropdown-item-icon bg-warning text-white">
                                    <i class="fas fa-route"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    航线列表
                                    <div class="time text-primary" style="margin-top: 0px;">点击查看</div>
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="<?php echo SITE_URL; ?>/admin">管理员面板 <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li>
                <?php } ?>

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="<?php echo PilotData::getPilotAvatar($pilotcode); ?>" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block"><?php echo Auth::$userinfo->firstname; ?> <?php echo Auth::$userinfo->lastname; ?> | <?php echo $pilotcode; ?></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if(!$nextrank) { } else { ?>
                        <div class="dropdown-title">还需<?php echo $nextrank->minhours - $pilot_hours; ?>小时到下一职级</div>
                        <?php } ?>

                        <a href="<?php echo url('/profile'); ?>" class="dropdown-item has-icon">
                            <i class="fas fa-user"></i> 个人资料
                        </a>
                        <a href="<?php echo url('/mail'); ?>" class="dropdown-item has-icon">
                            <i class="fas fa-envelope"></i> 公司信息
                        </a>

                        <?php
                            if(PilotGroups::group_has_perm(Auth::$usergroups, ACCESS_ADMIN)) { 
                                echo '<div class="dropdown-divider"></div>';
                                echo '<a href="'.SITE_URL.'/admin" class="dropdown-item has-icon"><i class="fas fa-cog"></i> 管理员面板</a>'; 
                            } 
                        ?>
                        
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo url('/logout'); ?>" class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> 登出
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/img/logo.svg" alt="logo" width="200"></a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL?>/lib/skins/StislaSkin/assets/img/logo_sm.svg" alt="logo" width="30"></a>
                </div>
                
                

                <ul class="sidebar-menu">
                    <li class="menu-header">主页</li>
                    <li>
                        <a class="nav-link" href="<?php echo SITE_URL; ?>">
                            <i class="fas fa-fire "></i> <span>控制台</span>
                        </a>
                    </li>

                    <li class="menu-header">飞行员中心</li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>航前准备</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="<?php echo SITE_URL;?>/index.php/mail">公司信息</a></li>
                            <li><a class="nav-link" href="<?php echo SITE_URL;?>/index.php/acars/viewmapwxr">天气地图</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-bezier-curve"></i> <span>信息</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="<?php echo SITE_URL;?>/index.php/career">生涯</a></li>
                            <li><a class="nav-link" href="<?php echo SITE_URL;?>/index.php/pilots">飞行员</a></li>
                            <li><a class="nav-link" href="<?php echo SITE_URL;?>/index.php/airports">机场</a></li>
                            <li><a class="nav-link" href="<?php echo SITE_URL;?>/index.php/Fleet">机队</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="nav-link" href="<?php echo url('/TopPilot'); ?>">
                            <i class="fas fa-trophy"></i> <span>排行榜</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link" href="<?php echo url('/ACARS/livemap'); ?>">
                            <i class="fas fa-map-marked-alt"></i> <span>在线地图</span>
                        </a>
                    </li>

                    <li class="menu-header">飞行中心</li>

                    <?php
                        $allbids = SchedulesData::getBids(Auth::$userinfo->pilotid);
                        $counter = (is_array($allbids) ? count($allbids) : 0);
                        if($counter > 0) {
                    ?>
                    <li>
                        <a class="nav-link" href="<?php echo url('/schedules/bids'); ?>">
                            <i class="fas fa-map-marked-alt"></i> <span>我的航班</span>
                        </a>
                    </li>
                    <?php } else { ?>
                    <li>
                        <a class="nav-link" href="<?php echo url('/fltbook'); ?>">
                            <i class="fas fa-search-location"></i> <span>预定航班</span>
                        </a>
                    </li>
                    <?php } ?>

                    <li>
                        <a class="nav-link" href="<?php echo url('/pireps'); ?>">
                            <i class="fas fa-book-open"></i> <span>我的报告</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link" href="<?php echo url('/weather'); ?>">
                            <i class="fas fa-wind"></i> <span>天气</span>
                        </a>
                    </li>

                    <li>
                        <a class="nav-link" href="<?php echo url('/events'); ?>">
                            <i class="fas fa-calendar-alt"></i> <span>活动</span>
                        </a>
                    </li>

                    <li class="menu-header">资源与支持</li>
                    <li>
                        <a class="nav-link" href="<?php echo url('/downloads'); ?>">
                            <i class="fas fa-download"></i> <span>ACARS下载</span>
                        </a>
                        <a class="nav-link" href="https://www.virtualcqh.com/resources">
                            <i class="fas fa-download"></i> <span>资源中心</span>
                        </a>
                    </li>
                </ul>
                
                <?php if(PilotGroups::group_has_perm(Auth::$usergroups, ACCESS_ADMIN)) { echo '
                <div class="mt-2 mb-4 p-3 hide-sidebar-mini">
                    <a href="'.SITE_URL.'/admin" class="btn btn-primary btn-lg btn-block btn-icon-split">
                        <i class="fas fa-users-cog"></i> 管理员面板
                    </a>
                </div>
                '; } ?> 
            </aside>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
