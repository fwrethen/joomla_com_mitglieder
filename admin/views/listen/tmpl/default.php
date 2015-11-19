<?php defined('_JEXEC') or die('Restricted access'); ?>


<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="editcell">
<?php
	$radio = JHtml::_('select.radiolist',$this->items,'cid','onClick="javascript:Joomla.isChecked(this.checked);"','id','name_backend');
	echo $radio;


?>
</div>

<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="listen" />
</form>
</div>
