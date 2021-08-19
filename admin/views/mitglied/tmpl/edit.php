<?php defined('_JEXEC') or die('Restricted access'); ?>

<script type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			Joomla.submitform( pressbutton );
			return;
		}

		if (form.vorname.value == "") {
			alert( "<?php echo JText::_( 'Geben Sie den Vornamen des Mitglieds an', true ); ?>" );
		} else if(form.name.value == "") {
			alert( "<?php echo JText::_( 'Geben Sie den Nachnamen des Mitglieds an', true ); ?>" );
		}else {
			Joomla.submitform( pressbutton );
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_mitglieder&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
<div class="form-horizontal">
	<div class="row-fluid">
		<div class="span9">
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'Vorname' ); ?>
				</div>
				<div class="controls">
					<input class="inputbox" type="text" name="vorname" id="vorname" size="20" value="<?php echo $this->player->vorname; ?>" />
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'Nachname' ); ?>
				</div>
				<div class="controls">
					<input class="inputbox" type="text" name="name" id="name" size="20" value="<?php echo $this->player->name; ?>" />
				</div>
			</div>
			<?php
				foreach($this->player->felder as $id=>$feld):
					switch($feld->typ) {
						case "text":
							echo $this->form->renderField($feld->id, null, strip_tags($feld->wert));
							break;
						case "text_html":
						case "email":
						case "telefon":
						case "jahre seit":
						case "bild":
							echo $this->form->renderField($feld->id, null, $feld->wert);
							break;
						case "liste":
							// TODO: beautify using renderField or similar Joomla given function
							echo '<div class="control-group"><div class="control-label">';
							echo JText::_( $feld->name );
							echo '</div><div class="controls">';
							echo JHtml::_('select.genericlist',  $this->player->listen[$id], "felder[$id]", ' ', 'id', 'wert', $feld->wert).' <br />';
							echo '</div></div>';
							break;
					}
			?>
			<input class="inputbox" type="hidden" name="typen[<?php echo $id;?>]" value="<?php echo $feld->typ; ?>" />
		<?php endforeach; ?>

			<div class="control-group">
				<div class="control-label">
					<?php echo JText::_( 'Abteilungen' ); ?>
				</div>
				<div class="controls">

		<div id="abteilung_list_content">
		<?php if (count($this->inAbteilungen) < 1):
			echo JHtml::_('select.genericlist',  $this->abteilungen, 'abteilung[]', ' ', 'id', 'name');
		?>
			<input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="40" value="99" /><br />
		<?php endif; ?>
		<?php for ($i = 0; $i < count($this->inAbteilungen); ++$i):
			echo JHtml::_('select.genericlist',  $this->abteilungen, 'abteilung[]', ' ', 'id', 'name',$this->inAbteilungen[$i]->abteilungen_id);
		?>
			<input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="40" value="<?php echo $this->inAbteilungen[$i]->ordering?>" /><br />
		<?php endfor; ?>
		</div>

		<script type="text/javascript">
		<?php	$abteilungenSelect=JHtml::_('select.genericlist',  $this->abteilungen, 'abteilung[]', ' ', 'id', 'name');
				$abteilungenSelect=str_replace(array("\r\n", "\n", "\r"), '', $abteilungenSelect);
		?>
		var abteilungList = '<?php echo $abteilungenSelect?> <input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="40" value="99" /><br />';
		var maxAbteilung = <?php echo count($this->abteilungen); ?> - 1;
		var curAbteilung = <?php echo (count($this->inAbteilungen) > 0 ? (count($this->inAbteilungen)) : 0); ?> - 0;
		</script>
		<input type="button" value="mehr Abteilungen" onclick="if (curAbteilung < maxAbteilung) { document.getElementById('abteilung_list_content').innerHTML += abteilungList; ++curAbteilung; }" />

				</div>
			</div>
		</div>
	</div>
</div>

<input type="hidden" name="id" value="<?php echo $this->player->id; ?>" />
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
