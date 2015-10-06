<?php
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require_once (JPATH_COMPONENT.DS.'lib'.DS.'mitglieder'.DS.'printfelder.php');

$path=JURI::base();
$option = JRequest::getCMD('option');
JHTML::_('stylesheet',$path.'components/'.$option.'/lib/css/mitglieder.css');
?>

<h1><?php echo $this->abteilung->name; ?></h1>



			<?php
				echo $this->abteilung->description;
			?>
			<br />
			<?php if(is_array($this->abteilung->mitglieder)) {?>
			<div class="thumbswrap">
				<?php
				foreach($this->abteilung->mitglieder as $mitglied) {
				$name = $mitglied->vorname . " " . $mitglied->name;
				?>

					<div class="Thumb">
						<a href="index.php?option=com_mitglieder&layout=default&view=mitglied&id=<?php echo $mitglied->id;?>">

				<?php
						$image = $mitglied->thumb;
						if($image) {
							if(substr($image, 0, 1) == "/")
								$image = substr($image, 1);

							echo '<p><img src="' . JURI::root() . $image . '" alt="' . $name
								. '" height="' . $this->thumb_size . '" max-width="'
								. $this->thumb_size . '" /></p>';
						}
						?>
						<p><?php echo $name?></p></a>
						<table>
							<?php
							printFelder($mitglied->felder);
							?>
						</table>
						</div>



			<?php
			}
			?>
			</div>
			<?php
			}
			?>
