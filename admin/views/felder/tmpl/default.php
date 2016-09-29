<?php defined('_JEXEC') or die('Restricted access'); ?>


<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="editcell">
	<table class="adminlist">
	<tr>
		<th width="180px">Feldname (im Backend)</th>
		<th width="180px">Feldname (im Frontend)</th>
		<th width="80px">Typ</th>
		<th width="180px">Hilfetext</th>
		<th width="100px">Anzeigen</th>
		<th width="100px">Reihenfolge</th>
		<th>&nbsp;</th>

	</tr>
	<?php foreach($this->felder as $feld): ?>
	<tr>
		<td>
			<input class="inputbox" type="text" name="alte_namen_backend[<?php echo $feld->id;?>]" size="20" value="<?php echo $feld->name_backend; ?>" />
		</td>
		<td>
			<input class="inputbox" type="text" name="alte_namen_frondend[<?php echo $feld->id;?>]" size="20" value="<?php echo $feld->name_frontend; ?>" />
		</td>
		<td>

			<?php

			echo JHtml::_( 'select.genericlist',$this->typen,  'alte_typen[' . $feld->id . ']','class="inputbox"', 'typ', 'typ', $feld->typ );
			?>
		</td>
		<td>
			<input class="inputbox" type="text" name="alte_tooltip[<?php echo $feld->id;?>]" size="20" value="<?php echo $feld->tooltip; ?>" />
		</td>

		<td>
			<?php
			$checked = "";
			if($feld->show == 1)
				$checked = 'checked="checked" ';
			?>
			<input type="checkbox" name="alte_zeige_in_uebersicht[<?php echo $feld->id;?>]" value="1" <?php echo $checked;?>/>
		</td>
		<td>
			<input class="inputbox" type="text" name="alte_ordering[<?php echo $feld->id;?>]" size="3" value="<?php echo $feld->ordering; ?>" />
		</td>
		<td>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
<tr>
	<th colspan="6">Neue Felder erstellen</th>
	<th>&nbsp;</th>
</tr>

<?php
for($i=0; $i < 5; $i++) {
	?>
	<tr>
		<td>
			<input class="inputbox" type="text" name="neue_namen_backend[]" size="20" value="" />
		</td>
		<td>
			<input class="inputbox" type="text" name="neue_namen_frontend[]" size="20" value="" />
		</td>
		<td>
		<?php

			echo JHtml::_( 'select.genericlist',$this->typen,  'neue_typen[]','class="inputbox"', 'typ', 'typ', null );
			?>
		</td>
		<td>
			<input class="inputbox" type="text" name="neue_tooltip[]" size="20" value="" />
		</td>
		<td>
			<input type="checkbox" name="neue_zeige_in_uebersicht[]" value="1" />
		</td>
		<td>
			<input class="inputbox" type="text" name="neue_ordering[]" size="3" value="" />
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
<input type="hidden" name="view" value="felder" />
</form>
</div>
