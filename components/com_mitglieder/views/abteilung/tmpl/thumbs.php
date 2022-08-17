<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('stylesheet', 'com_mitglieder/com_mitglieder.css', ['version' => 'auto', 'relative' => true]);
?>

<div class="com_mitglieder">
    <div class="container-fluid">
        <h1><?php echo $this->abteilung->name; ?></h1>
        <p><?php echo $this->abteilung->description; ?></p>

        <?php if (is_array($this->abteilung->mitglieder)): ?>
            <?php $i = 1; ?>

            <div class="row">

                <?php foreach($this->abteilung->mitglieder as $mitglied): ?>
	                <?php
	                $name = $mitglied->vorname . " " . $mitglied->name;
	                $image = $mitglied->thumb ?: $this->thumb_placeholder;
                    $imageSrc = JURI::root() . ltrim($image, '/');
	                ?>

                    <div class="col-6 col-sm-<?= 12 / $this->thumb_cols; ?> mb-4">
                        <a class="card" href="index.php?option=com_mitglieder&layout=default&view=mitglied&id=<?= $mitglied->id; ?>">
                            <img src="<?= $imageSrc; ?>" class="img-fluid" alt="<?= $name; ?>">
                            <div class="card-body">
                                <h6 class="card-title"><?= $name; ?></h6>
                                <p><?= strip_tags($mitglied->text); ?></p>
                            </div>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php endif ?>
    </div>
</div>
