<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('stylesheet', 'com_mitglieder/com_mitglieder.css', ['version' => 'auto', 'relative' => true]);
?>

<div class="com_mitglieder">
    <h1><?php echo $this->abteilung->name; ?></h1>
    <p><?php echo $this->abteilung->description; ?></p>

	<?php if (is_array($this->abteilung->mitglieder)): ?>
        <?php $n = ceil(count($this->abteilung->mitglieder) / 3); ?>

        <div class="row">
            <ul class="col-sm-4 list-group list-group-flush">
                <?php foreach($this->abteilung->mitglieder as $index => $mitglied): ?>

                    <li class="list-group-item">
                        <a href="index.php?option=com_mitglieder&layout=default&view=mitglied&id=<?= $mitglied->id; ?>">
                            <?= $mitglied->name . ", " . $mitglied->vorname; ?>
                        </a>
                    </li>
                    <?php if(($index + 1) % $n == 0): ?></ul><ul class="col-sm-4 list-group list-group-flush"><?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

	<?php endif; ?>
</div>
