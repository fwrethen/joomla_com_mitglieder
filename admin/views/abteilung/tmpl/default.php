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
        echo $this->form->renderField('field', null, $this->team->field);
      ?>
    </div>
  </div>
</div>


<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="id" value="<?php echo $this->team->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="abteilungen" />
</form>
