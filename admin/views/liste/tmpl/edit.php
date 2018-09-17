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
foreach($this->liste as $id => $item) {
	?>
	<tr>
		<td>
			<input class="inputbox" type="text" name="values[<?= $id ?>]" size="20" value="<?= $item ?>" />
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
$new_id = max(array_keys($this->liste)) + 1;
for($i = $new_id; $i < $new_id + 5; $i++) {
	?>
	<tr>
		<td>
			<input class="inputbox" type="text" name="values[<?= $i ?>]" size="20" value="" />
		</td>
		<td>&nbsp;</td>
	</tr>
<?php
}
?>


	</table>
</div>

<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="id" value="<?php echo $this->listenid?>">
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="listen" />
</form>
