<?php defined('_JEXEC') or die('Restricted access');

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="editcell">
	<table class="adminlist">
	<tr>
		<th width="180px">Wert</th>
		<th>&nbsp;</th>

	</tr>
<?php
foreach($this->liste as $feld) {
	?>
	<tr>
		<td>
			<input class="inputbox" type="text" name="alte_wert[<?php echo $feld->id;?>]" size="20" value="<?php echo $feld->wert; ?>" />
		</td>
		<td>&nbsp;</td>
	</tr>
<?php
}
?>
<tr>
	<th colspan="2">Neue Werte erstellen</th>

</tr>

<?php
for($i=0; $i < 5; $i++) {
	?>
	<tr>
		<td>
			<input class="inputbox" type="text" name="neue_wert[]" size="20" value="" />
			<input class="inputbox" type="hidden" name="neue_liste[]" size="20" value="<?php echo $this->listenid?>" />
		</td>
		<td>&nbsp;</td>
	</tr>
<?php
}
?>


	</table>
</div>

<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="listen" />
</form>
