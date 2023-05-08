<h3><?php echo $title;?></h3>
<form id="form" action="<?php echo adminaction('/PirepAutoAccept/');?>" method="post">
<dl>
<dt>Criteria Code Altering Disabled</dt>
<dd><input name="code" type="text" disabled="disabled" value="<?php echo $criteria->id; ?>" /></dd>

<dt>Criteria Description *</dt>
<dd><input name="name" type="text" value="<?php echo $criteria->criteria_description; ?>" /></dd>

<dt>Criteria Value *</dt>
<dd><input name="value" type="text" value="<?php echo $criteria->criteria_variable; ?>" /></dd>

<dt>Custom Message *</dt>
<dd><input name="msg" type="text" value="<?php echo $criteria->criteria_custom_message; ?>" /></dd>

<dt>Enabled *</dt>
<dd><?php $checked = ($criteria->enabled==1)?'CHECKED':''; ?>
    <input name="enabled" type="checkbox" <?php echo $checked ?> /></dd>

<dt></dt>
<dd><input type="hidden" name="id" value="<?php echo $criteria->id;?>" />
    <input type="hidden" name="action" value="<?php echo $action;?>" />
    <input type="submit" name="submit" value="<?php echo $title;?>" />
</dd>
</dl>
</form>