<?php if(!defined('IN_PHPVMS') && IN_PHPVMS !== true) { die(); } ?>
<?php

if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_NEWS)
|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PAGES)
|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_DOWNLOADS)
|| PilotGroups::group_has_perm(Auth::$usergroups, EMAIL_PILOTS)
|| PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_REGISTRATIONS)
)
{
?>
<li style="padding: 0; margin: 0;"><a class="menu" href="#">
	<img src="<?php echo fileurl('/admin/lib/layout/images/site_icon.png');?>" />内容管理
	</a>
	<ul style="padding: 0; margin: 0;">
		<?php
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_NEWS))
		{
		?>
		<li><a href="<?php echo adminurl('/sitecms/viewnews'); ?>">航司通告</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PAGES))
		{
		?>
		<li><a href="<?php echo adminurl('/sitecms/viewpages');?>">自定义页面</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_DOWNLOADS))
		{
		?>
		<li><a href="<?php echo adminurl('/downloads/overview'); ?>">下载内容</a></li>
		<?php
		}
		?>
		<li></li>
	</ul>
</li>
<?php
}

if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_AIRLINES)
|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_FLEET)
|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_SCHEDULES)
|| PilotGroups::group_has_perm(Auth::$usergroups, IMPORT_SCHEDULES)
)
{
	?>
<li style="padding: 0; margin: 0;"><a class="menu" href="?admin=airlines">
	<img src="<?php echo  SITE_URL?>/admin/lib/layout/images/operations_icon.png" />运控管理
	</a>
	<ul style="padding: 0; margin: 0;">
		<?php
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_AIRLINES))
		{
		?>
		<li><a href="<?php echo adminurl('/operations/airlines');?>">航司</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_FLEET))
		{
		?>
			<li><a href="<?php echo adminurl('/operations/aircraft');?>">机队</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_SCHEDULES))
		{
		?>
		<li><a href="<?php echo adminurl('/operations/airports');?>">机场</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_SCHEDULES))
		{
		?>
		<li><a href="<?php echo adminurl('/operations/schedules');?>">航班</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, IMPORT_SCHEDULES))
		{
		?>
			<li><a href="<?php echo adminurl('/import');?>">导入航班</a></li>
			<li><a href="<?php echo adminurl('/import/export');?>">导出航班</a></li>
		<?php
		}
		?>
	</ul>
</li>
<?php
}

if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_PIREPS)
	|| PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_REGISTRATIONS)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PILOTS)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_GROUPS)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_RANKS)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EMAIL_PILOTS)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_AWARDS)
)
{
	?>
<li style="padding: 0; margin: 0;"><a class="menu" href="#">
	<img src="<?php echo  SITE_URL?>/admin/lib/layout/images/pilots_icon.png" />成员管理</a>
	<ul style="padding: 0; margin: 0;">
		<?php
		if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_REGISTRATIONS))
		{
		?>
		<li><a href="<?php echo adminurl('/pilotadmin/pendingpilots');?>">待审核的注册申请</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PILOTS))
		{
		?>
		<li><a href="<?php echo adminurl('/pilotadmin/viewpilots');?>">飞行员列表</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_GROUPS))
		{
		?>
		<li><a href="<?php echo adminurl('/pilotadmin/pilotgroups');?>">飞行员分组</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_RANKS))
		{
		?>
		<li><a href="<?php echo adminurl('/pilotranking/pilotranks');?>">飞行员职级</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EMAIL_PILOTS))
		{
		?>
		<li><a href="<?php echo adminurl('/massmailer'); ?>">发送全体邮件</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_AWARDS))
		{
		?>
		<li><a href="<?php echo adminurl('/pilotranking/awards'); ?>">奖项</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, FULL_ADMIN))
		{
		?>
			<li><a href="<?php echo adminurl('/maintenance/changepilotid'); ?>">更改飞行员ID</a></li>
			<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_PIREPS))
		{
		?>
		<li><a href="<?php echo adminurl('/pilotadmin/viewbids'); ?>">查看预定的航班</a></li>
		<?php
		}
		?>
		<li></li>
	</ul>
</li>
<?php
}

if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_PIREPS)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PIREPS_FIELDS)
)
{
?>
<li style="padding: 0; margin: 0;"><a class="menu" href="#">
	<img src="<?php echo  SITE_URL?>/admin/lib/layout/images/pireps_icon.png" />飞行员报告管理</a>
	<ul style="padding: 0; margin: 0;">
		<?php
		if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_PIREPS))
		{
		?>
		<li><a href="<?php echo adminurl('/pirepadmin/viewpending'); ?>">待审核的报告</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_PIREPS))
		{
		?>
		<li><a href="<?php echo adminurl('/pirepadmin/viewrecent'); ?>">最近的报告</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, MODERATE_PIREPS))
		{
		?>
		<li><a href="<?php echo adminurl('/pirepadmin/viewall'); ?>">所有的报告</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PIREPS_FIELDS))
		{
		?>
		<li><a href="<?php echo adminurl('/settings/pirepfields'); ?>">自定义内容</a></li>
		<?php
		}
		?>
		<li></li>
	</ul>
</li>
<?php
}

if(PilotGroups::group_has_perm(Auth::$usergroups, VIEW_FINANCES)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_EXPENSES)
)
{
?>
<li style="padding: 0; margin: 0;"><a class="menu" href="<?php echo SITE_URL?>/admin/index.php/reports">
	<img src="<?php echo  SITE_URL?>/admin/lib/layout/images/reports_icon.png" />财务管理</a>
	<ul style="padding: 0; margin: 0;">
		<?php
		if(PilotGroups::group_has_perm(Auth::$usergroups, VIEW_FINANCES))
		{
		?>
		<li><a href="<?php echo adminurl('/reports/overview'); ?>">财务总览</a></li>
		<li><a href="<?php echo adminurl('/finance/viewcurrent'); ?>">财务报告</a></li>
		<li><a href="<?php echo adminurl('/reports/aircraft'); ?>">飞机报告</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_EXPENSES))
		{
		?>
		<li><a href="<?php echo adminurl('/finance/viewexpenses'); ?>">开销总览</a></li>
		<?php
		}
		?>
		<li></li>
	</ul>
</li>
<?php
}

if(PilotGroups::group_has_perm(Auth::$usergroups, FULL_ADMIN)
	|| PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PROFILE_FIELDS)
)
{
	?>
<li style="padding: 0; margin: 0;"><a class="menu" href="#">
	<img src="<?php echo  SITE_URL?>/admin/lib/layout/images/settings_icon.gif" />系统设置</a>
	<ul style="padding: 0; margin: 0;">
		<?php
		if(PilotGroups::group_has_perm(Auth::$usergroups, FULL_ADMIN))
		{
?>
		<li><a href="<?php echo adminurl('/settings'); ?>">通用设置</a></li>
		<li><a href="<?php echo adminurl('/maintenance/options'); ?>">维护设置</a></li>
		<li><a href="<?php echo adminurl('/logs'); ?>">操作日志</a></li>
		<li><a href="<?php echo adminurl('/templatediffs');?>">模板设置</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, EDIT_PROFILE_FIELDS))
		{
		?>
		<li><a href="<?php echo adminurl('/settings/customfields'); ?>">自定义注册字段</a></li>
		<?php
		}
		if(PilotGroups::group_has_perm(Auth::$usergroups, FULL_ADMIN))
		{
		?>
		<?php
		if(Config::Get('PHPVMS_CENTRAL_ENABLED') == true || Config::Get('VACENTRAL_ENABLED') == true )
			echo '<li><a href="'.adminurl('/vacentral').'">vaCentral Settings</a></li>';
		?>
		<?php
		}
		?>
		<li><a href="<?php echo adminurl('/dashboard/about');?>">关于phpVMS</a></li>
		<li></li>
	</ul>
</li>
<?php
}
?>
<?php
if(strlen($MODULE_NAV_INC) > 0)
{
?>
<li style="padding: 0; margin: 0;"><a class="menu" href="#">
<img src="<?php echo  SITE_URL?>/admin/lib/layout/images/settings_icon.gif" />插件管理</a>
	<ul style="padding: 0; margin: 0;">
	<?php echo $MODULE_NAV_INC; ?>
	</ul>
</li>
<?php
}
?>