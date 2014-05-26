<?php defined('_JEXEC') or die('Restricted access');
    				$editor = JFactory::getEditor();
?>

<script type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
        <?php
                echo $editor->save( 'description' );
        ?>
		submitform( pressbutton );
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>

	<table class="admintable">
		<tr>
			<td width="110" class="key">
				<label for="title">
					<?php echo JText::_( 'Name' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="name" id="nummer" size="100" value="<?php echo $this->team->name; ?>" />
				<?php echo JHTML::tooltip("Bitte hier den Namen der Abteilung eintragen."); ?>
			</td>
		</tr>
		<tr>
			<td class="key" colspan=2>
				<?php echo JText::_( 'Beschreibung' ); ?>:
			</td>
		</tr>
		<tr>
			<td colspan=2>

				<?php

					echo $editor->display('description', $this->team->description, '100%', '200', '30', '5', true);
				 ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<?php echo JText::_( 'Felder für die Thumbnailseite' ); ?>:
			</td>
	      <td class="input">

		<div id="abteilung_list_content">
		<?php
		if (count($this->AbteilungenFelder) < 1)
		{
			echo JHTML::_('select.genericlist',  $this->felder, 'felder[]', ' ', 'id', 'name_frontend', '0'); ?>
			<input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="100%" value="99" /><br /><?php
		}
		for ($i = 0; $i < count($this->AbteilungenFelder); ++$i)
		{
			echo JHTML::_('select.genericlist',  $this->felder, 'felder[]', ' ', 'id', 'name_frontend',$this->AbteilungenFelder[$i]->felder_id); ?>
			<input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="100%" value="<?php echo $this->AbteilungenFelder[$i]->ordering?>" /><br /><?php
		}
		?>
		</div>

		<script type="text/javascript">
		<?php	$felderSelect=JHTML::_('select.genericlist',  $this->felder, 'felder[]', ' ', 'id', 'name_frontend', '0');
				$felderSelect=str_replace(array("\r\n", "\n", "\r"), '', $felderSelect);
		?>
		var felderList = '<?php echo $felderSelect; ?> <input class="inputbox" type="text" name="ordering[]" id="ordering[]" size="100%" value="99" /><br />';
		var maxFelder = <?php echo count($this->felder); ?> - 1;
		var curFelder = <?php echo (count($this->AbteilungenFelder) > 0 ? (count($this->AbteilungenFelder)) : 0); ?> - 0;
		</script>
		<input type="button" value="mehr Felder" onclick="if (curFelder < maxFelder) { document.getElementById('abteilung_list_content').innerHTML += felderList; ++curFelder; }" />
      </td>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<div class="clr"></div>


<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="id" value="<?php echo $this->team->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="abteilungen" />
</form>
