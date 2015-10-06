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
<div class="form-horizontal">
  <div class="row-fluid">
    <div class="span9">
      <?php
        echo $this->form->renderField('name', null, $this->team->name);
        echo $this->form->renderField('description', null,
          $this->team->description);
        echo $this->form->renderField('thumb', null, $this->team->thumb);
      ?>
      <div class="control-group">
        <div class="control-label">
          <?php echo JText::_( 'Felder für die Thumbnailseite' ); ?>
        </div>
        <div class="controls">

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

        </div>
      </div>
    </div>
  </div>
</div>
<div class="clr"></div>
<div class="clr"></div>


<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="id" value="<?php echo $this->team->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="abteilungen" />
</form>
