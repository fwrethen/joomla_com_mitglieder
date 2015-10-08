<?php defined('_JEXEC') or die('Restricted access');
$editor=JFactory::getEditor();
?>

<script type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		if (form.vorname.value == "") {
			alert( "<?php echo JText::_( 'Geben Sie den Vornamen des Mitglieds an', true ); ?>" );
		} else if(form.name.value == "") {
			alert( "<?php echo JText::_( 'Geben Sie den Nachnamen des Mitglieds an', true ); ?>" );
		}else {
			<?php
		foreach($this->player->felder as $id=>$feld) {
			if ($feld->typ == 'text')
			{
                echo $editor->save( "felder[$id]" );

			}
		}
			?>
			submitform( pressbutton );
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable">
		<tr>
			<td class="key">
				<label for="title">
					<?php echo JText::_( 'Vorname' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="vorname" id="vorname" size="20" value="<?php echo $this->player->vorname; ?>" />
				<?php echo JHTML::tooltip("Vorname und Nachname zusammen müssen eindeutig im Verein sein"); ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="alias">
					<?php echo JText::_( 'Nachname' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="name" id="name" size="20" value="<?php echo $this->player->name; ?>" />
				<?php echo JHTML::tooltip("Vorname und Nachname zusammen müssen eindeutig im Verein sein"); ?>
			</td>
		</tr>

		<?php

		foreach($this->player->felder as $id=>$feld) {
			?>
		<tr>
			<td class="key">
				<label for="alias">
					<?php echo JText::_( $feld->name ); ?>:
				</label>
			</td>
			<td>
			<?php

			switch($feld->typ) {
				case "jahre seit":
					$datum = "";
					if($feld->wert && $feld->wert != '0000-00-00')
						$datum = strftime("%d.%m.%Y",strtotime($feld->wert));
					?>
					<input class="inputbox" type="text" name="felder[<?php echo $id;?>]" id="felder[<?php echo $id;?>]" size="10" value="<?php echo $datum;?>" />
					<?php
					JHTML::calendar(date("Y-m-d"),"felder[$id]","felder[$id]","%d.%m.%Y");
					break;

				case "text":

					echo $editor->display("felder[$id]", $feld->wert, '100%', '200', '30', '5', true);

					break;
				case "email":
					?>
					<input class="inputbox" type="text" name="felder[<?php echo $id;?>]" id="felder[<?php echo $id;?>]" size="40" value="<?php echo $feld->wert; ?>" />
					<?php
					break;
				case "telefon":
					?>
					<input class="inputbox" type="text" name="felder[<?php echo $id;?>]" id="felder[<?php echo $id;?>]" size="15" value="<?php echo $feld->wert; ?>" />
					<?php
					break;
				case "liste":
         			echo JHTML::_('select.genericlist',  $this->player->listen[$id], "felder[$id]", ' ', 'id', 'wert', $feld->wert).' <br />';
          			break;
				case "bild":
					echo $this->form->getInput($feld->id, null, $feld->wert);

			}
			if($feld->tooltip)
					echo JHTML::tooltip($feld->tooltip);
			?>
			<input class="inputbox" type="hidden" name="typen[<?php echo $id;?>]" value="<?php echo $feld->typ; ?>" />
			</td>
		</tr>

			<?php
		}

		?>

		<tr>
			<td class="key">
				<?php echo JText::_( 'Abteilungen' ); ?>:
			</td>
	      <td class="input">

		<div id="abteilung_list_content">
		<?php
		if (count($this->inAbteilungen) < 1)
		{
			echo JHTML::_('select.genericlist',  $this->abteilungen, 'abteilung[]', ' ', 'id', 'name'); ?>
			<input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="40" value="99" /><br /><?php
		}
		for ($i = 0; $i < count($this->inAbteilungen); ++$i)
		{
			echo JHTML::_('select.genericlist',  $this->abteilungen, 'abteilung[]', ' ', 'id', 'name',$this->inAbteilungen[$i]->abteilungen_id); ?>
			<input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="40" value="<?php echo $this->inAbteilungen[$i]->ordering?>" /><br /><?php
		}
		?>
		</div>

		<script type="text/javascript">
		<?php	$abteilungenSelect=JHTML::_('select.genericlist',  $this->abteilungen, 'abteilung[]', ' ', 'id', 'name');
				$abteilungenSelect=str_replace(array("\r\n", "\n", "\r"), '', $abteilungenSelect);
		?>
		var abteilungList = '<?php echo $abteilungenSelect?> <input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="40" value="99" /><br />';
		var maxAbteilung = <?php echo count($this->abteilungen); ?> - 1;
		var curAbteilung = <?php echo (count($this->inAbteilungen) > 0 ? (count($this->inAbteilungen)) : 0); ?> - 0;
		</script>
		<input type="button" value="mehr Abteilungen" onclick="if (curAbteilung < maxAbteilung) { document.getElementById('abteilung_list_content').innerHTML += abteilungList; ++curAbteilung; }" />
      </td>

	</tr>

	</table>
	</fieldset>
</div>
<div class="clr"></div>
<div class="clr"></div>

<input type="hidden" name="image_orginal" value="<?php echo $this->player->image_orginal; ?>" />
<input type="hidden" name="image_resize" value="<?php echo $this->player->image_resize; ?>" />
<input type="hidden" name="image_thumb" value="<?php echo $this->player->image_thumb; ?>" />
<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="id" value="<?php echo $this->player->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="mitglieder" />
</form>
