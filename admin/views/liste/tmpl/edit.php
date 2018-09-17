<?php defined('_JEXEC') or die('Restricted access');

$new_id = ($this->liste ? max(array_keys($this->liste)) + 1 : 0);
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<div class="form-horizontal">
  <div class="row-fluid">
    <div class="span9">
      <div class="control-group">

        <?php if ($this->liste): ?>
          <?php foreach($this->liste as $id => $item): ?>
            <div class="control-group">
              <div class="control-label">
              </div>
              <div class="controls">
                <input class="inputbox" type="text" name="values[<?= $id ?>]" size="20" value="<?= $item ?>" />
              </div>
            </div>
          <?php endforeach; ?>
          <hr />
        <?php endif; ?>

        <?php for($i = $new_id; $i < $new_id + 5; $i++): ?>
          <div class="control-group">
            <div class="control-label">
              <?php if ($i == $new_id) echo JText::_('Neue Werte hinzufügen:'); ?>
            </div>
            <div class="controls">
              <input class="inputbox" type="text" name="values[<?= $i ?>]" size="20" value="" />
            </div>
          </div>
        <?php endfor; ?>

      </div>
    </div>
  </div>
</div>

<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="id" value="<?php echo $this->listenid?>">
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="listen" />
</form>
