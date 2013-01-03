<?php
defined('_JEXEC') or die('Restricted access');
require_once (JPATH_COMPONENT.DS.'lib'.DS.'mitglieder'.DS.'printfelder.php');
?>

<link rel="stylesheet" href="<?php echo $this->baseurl .'/components/com_mitglieder/lib/css/mitglieder.css'?>" type="text/css"/>
<h1><?php echo $this->abteilung->name; ?></h1>



			<?php
				echo $this->abteilung->description;
			?>
			<br />
			<?php if(is_array($this->abteilung->mitglieder)) {?>
				<?php
				foreach($this->abteilung->mitglieder as $mitglied) {
				?>

					<div class="Thumb">
						<a href="index.php?option=com_mitglieder&layout=default&view=mitglied&id=<?php echo $mitglied->id;?>">
							
						<p/>
				<?php
						$image = $mitglied->image_thumb;
						if($image) {
							if(substr($image, 0, 1) == "/")
								$image = substr($image, 1);
							if(substr($imageOrginal, 0, 1) == "/")
								$imageOrginal = substr($imageOrginal, 1);

							echo "<img src=\"" . JURI::root() . $image . "\" alt=\"$name\" />";
						}
						?>
						<p/>
<?php echo $mitglied->vorname?> <?php echo $mitglied->name;?>
<p/>
<table>

							<?php
							printFelder($mitglied->felder);
							?>
</table>
						</a></div>



			<?php
			}
			}
			?>
