<?php defined('_JEXEC') or die('Restricted access'); ?>



<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="editcell">
<?php 
	$radio = JHTML::_('select.radiolist',$this->items,'cid','onClick="javascript:isChecked(this.checked);"','id','name_backend');
	echo $radio;
	

?>
</div>

<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="listen" />
</form>
