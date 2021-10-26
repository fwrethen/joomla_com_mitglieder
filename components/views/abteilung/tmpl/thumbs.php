<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('bootstrap.loadCss');
?>

<h1><?php echo $this->abteilung->name; ?></h1>
<p><?php echo $this->abteilung->description; ?></p>

<?php
	if(is_array($this->abteilung->mitglieder)) {
	$i = 1;
?>

<div class="row-fluid">
	<ul class="thumbnails">

<?php
		foreach($this->abteilung->mitglieder as $mitglied) {
			$name = $mitglied->vorname . " " . $mitglied->name;
?>

		<li class="span<?php echo 12 / $this->thumb_cols ?>">
			<div class="thumbnail">
				<a href="index.php?option=com_mitglieder&layout=default&view=mitglied&id=<?php echo $mitglied->id;?>"
					style="text-decoration: none;">

				<?php
						$image = ($mitglied->thumb) ? $mitglied->thumb : $this->thumb_placeholder;
						if($image) {
							if(substr($image, 0, 1) == "/")
								$image = substr($image, 1);

							echo '<img src="' . JURI::root() . $image . '" alt="' . $name
								. '" style="width:330px;" />';
							//TODO: set variable width depending on thumb size setting
						}
						?>
					<div class="caption">
						<h6><?php echo $name; ?></h6>
						<?php echo strip_tags($mitglied->text); ?>
					</div>
				</a>
			</div>
		</li>

	<?php
			if($i % $this->thumb_cols == 0) {
	?>
	</ul>
	<ul class="thumbnails">
	<?php
			}
			$i++;
		}
	?>
	</ul>
</div>
<?php
	}
?>
