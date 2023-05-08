<h3>Extra Settings</h3>
  <form id="form" action="<?php echo adminaction('/PirepAutoAccept/');?>" method="post">     
<table id="tabledlist" class="tablesorter">
<thead>
	<tr>
		<th>Setting Name</th>
		<th>Setting Value</th>
	</tr>
</thead>
<tbody>
                                                     <tr> 
<td>Module Enabled</td>
    <?php
$moduleenabled = $settings->enabled;
if($moduleenabled == '1')
{
    echo ' <td><input type="radio" name="moduleenabled" value="1" checked="checked" />Yes  '; 
    echo ' <input type="radio" name="moduleenabled" value="0" />No  </td>  ';   
}
else
{
    echo ' <td><input type="radio" name="moduleenabled" value="1"  />Yes  '; 
     echo ' <input type="radio" name="moduleenabled" value="0" checked="checked" />No  </td>  '; 
}
?>
</tr>
                                                  <tr>
    <td>Admin Code that will Reject the Pirep</td>
    <td><input type="text" name="admin_code" value="<?php echo $settings->admin_rejecting;?>" /></td>    
</tr>
                                                     <tr>
    <td>Landing Rate</td>
    <td><input type="text" name="landing_rate" value="<?php echo $settings->landing_rate;?>" /></td>    
</tr>
<tr>
    <td>Force source</td>
    <td><input type="text" name="source" value="<?php echo $settings->source;?>" /></td>    
</tr>
     <tr>                            
    <td>Send mail to pilot if PIREP is rejected</td>
    <?php
$sendpilotmail = $settings->sendmail_to_pilot;
if($sendpilotmail == '1')
{
    echo ' <td><input type="radio" name="send_mail_to_pilot" value="1" checked="checked" />Yes  '; 
    echo ' <input type="radio" name="send_mail_to_pilot" value="0" />No  </td>  ';   
}
else
{
    echo ' <td><input type="radio" name="send_mail_to_pilot" value="1"  />Yes  '; 
     echo ' <input type="radio" name="send_mail_to_pilot" value="0" checked="checked" />No  </td>  '; 
}
?>
       
</tr>
 <tr> 
<td>Send mail to ADMIN if PIREP is rejected</td>
    <?php
$sendpilotmail = $settings->sendmail_to_admin;
if($sendpilotmail == '1')
{
    echo ' <td><input type="radio" name="send_mail_to_admin" value="1" checked="checked" />Yes  '; 
    echo ' <input type="radio" name="send_mail_to_admin" value="0" />No  </td>  ';   
}
else
{
    echo ' <td><input type="radio" name="send_mail_to_admin" value="1"  />Yes  '; 
     echo ' <input type="radio" name="send_mail_to_admin" value="0" checked="checked" />No  </td>  '; 
}
?>
</tr>
<tr>
	<td></td>
	<td>
    <input type="hidden" name="setting_id" value="1"> 
    <input type="hidden" name="action" value="savesettings">
		<input type="submit" name="submit" value="Save Settings" />
	</td>
</tr>
</tbody>
</table>
</form>