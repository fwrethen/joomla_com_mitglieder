<?php
defined('_JEXEC') or die('Restricted access');

JHTML::_('bootstrap.loadCss');
?>


<h1><?php echo $this->abteilung->name; ?></h1>
<p><?php echo $this->abteilung->description; ?></p>

<?php
	if(is_array($this->abteilung->mitglieder)) {
		$n = 1;
?>

<table class="table table-condensed table-striped">
	<tr>
		<?php
		foreach($this->abteilung->mitglieder as $mitglied) {
			$name = $mitglied->name . ", " . $mitglied->vorname;
		?>
		<td>
			<a href="index.php?option=com_mitglieder&layout=default&view=mitglied&id=<?php echo $mitglied->id;?>">
				<?php echo $name; ?>
			</a>
		</td>
		<?php
			if($n % 3 == 0) {
		?>
	</tr><tr>
		<?php
			}
			$n++;
		}
		?>
	</tr>
</table>

<?php
	}
?>
