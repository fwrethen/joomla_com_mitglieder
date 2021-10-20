<?php
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT . '/lib/mitglieder/printfelder.php');

$name = $this->mitglied->vorname . " " . $this->mitglied->name;
echo "<h1>$name</h1>";

//<title> Tag setzen
$document = JFactory::getDocument();
$document->setTitle($name);
?>

<div class="row">
	<?php
	$data = json_decode(printFelder($this->mitglied->felder));
	$params = JComponentHelper::getParams('com_mitglieder');
	$image_size = $params->get('mitglied_image_size', '300');
	foreach ($data as $item) {
		if ($item->type == 'image')
			$item->value = '<img src="'. JURI::root() . $item->value
				.'" style="max-height:'. $image_size .'px; max-width:'
				. $image_size .'px;" />'; ?>
		<dl class="dl-horizontal">
			<dt><?php echo $item->key; ?></dt>
			<dd><?php echo $item->value; ?></dd>
		</dl>
	<?php } ?>
</div>
