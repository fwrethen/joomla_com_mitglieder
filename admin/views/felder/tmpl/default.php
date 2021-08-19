<?php defined('_JEXEC') or die('Restricted access'); ?>


<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>

<div id="j-main-container" class="span10">
<form action="index.php" method="post" name="adminForm" id="adminForm">

    <div class="subform-repeatable">
        <?php echo $this->form->renderField('values'); ?>
    </div>

<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="view" value="felder" />
</form>
</div>

<script>
    // handle deleted rows
    jQuery(document).ready(function() {
        jQuery(document).on('subform-row-remove', function(event, row) {
            const id = jQuery(row).find('input').val();
            jQuery('<input>').attr({
                type: 'hidden',
                name: 'jform[deleted]['+id+']'
            }).appendTo('#adminForm');
        })
    });
</script>
