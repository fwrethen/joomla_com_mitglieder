<?php defined('_JEXEC') or die('Restricted access'); ?>

<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>

<div id="j-main-container" class="span10">
<form action="<?php echo JRoute::_('index.php?option=com_mitglieder&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">

<div class="form-horizontal">
  <div class="row-fluid">
    <div class="span9">
      <div class="control-group">
        <?php echo $this->form->renderField('values'); ?>
      </div>
    </div>
    <div class="span3">
      <?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
    </div>
  </div>
</div>

<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
</div>
