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

<form action="<?php echo JRoute::_('index.php?option=com_mitglieder&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
<div class="form-horizontal">
  <div class="row-fluid">
    <div class="span9">
      <?php
        echo $this->form->renderField('name');
        echo $this->form->renderField('description');
        echo $this->form->renderField('thumb');
        echo $this->form->renderField('field');
      ?>
    </div>
    <div class="span3">
      <?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
    </div>
  </div>
</div>

<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
