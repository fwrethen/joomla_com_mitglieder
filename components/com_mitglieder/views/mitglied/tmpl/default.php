<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('stylesheet', 'com_mitglieder/com_mitglieder.css', ['version' => 'auto', 'relative' => true]);

$name = $this->mitglied->vorname . " " . $this->mitglied->name;

$document = JFactory::getDocument();
$document->setTitle($name);
?>
<div class="com_mitglieder">
    <h1><?= $name; ?></h1>

    <dl class="row">
        <?php
        $data = $this->mitglied->fields;
        $params = JComponentHelper::getParams('com_mitglieder');
        $image_size = $params->get('mitglied_image_size', '300');
        foreach ($data as $item) {
            if ($item->display == 'image')
                $item->value = '<img src="' . JURI::root() . $item->value
                    . '" style="max-height:' . $image_size . 'px; max-width:'
                    . $image_size . 'px;" />'; ?>
            <dt class="col-2"><?php echo $item->name; ?></dt>
            <dd class="col-10"><?php echo $item->value; ?></dd>
        <?php } ?>
    </dl>
</div>
