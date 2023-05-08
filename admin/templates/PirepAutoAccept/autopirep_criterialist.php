<h3>Criteria List</h3>
<?php
if(!$allcriteria)
{
    echo '<p id="error">No Criteria have been added</p>';
    return;
}
?>
<table id="tabledlist" class="tablesorter">
<thead>
<tr>
    <th>Name</th>
    <th>Variable</th> 
    <th>Enabled</th>
    <th align="center">Options</th>
</tr>
</thead>
<tbody>
<?php
foreach($allcriteria as $criteria)
{
?>
<tr>
    <td align="left"><?php echo $criteria->criteria_description; ?></td>
    <td align="left"><?php echo $criteria->criteria_variable; ?></td>  
    <td align="left"><?php echo ($criteria->enabled == 1) ? 'Yes' : 'No'; ?></td>
    <td align="left" width="1%" nowrap>
   <button id="dialog" class="jqModal {button:{icons:{primary:'ui-icon-wrench'}}}" 
        href="<?php echo adminaction('/PirepAutoAccept/editcriteria?id='.$criteria->id);?>">
        Edit</button>
        
            <button class="deleteitem {button:{icons:{primary:'ui-icon-trash'}}}" action="deletecriteria" id="<?php echo $criteria->id?>"
            href="<?php echo adminaction('/PirepAutoAccept');?>">Delete</button>    
    </td>
   </tr>
<?php
}
?>
</tbody>
</table>