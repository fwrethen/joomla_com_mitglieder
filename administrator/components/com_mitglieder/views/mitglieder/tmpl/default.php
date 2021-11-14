<?php
/**
* @package     Joomla.Administrator
* @subpackage  com_mitglieder
*
* @copyright   Copyright (C) 2010 - 2015
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/
defined('_JEXEC') or die; ?>

<form action="<?php echo JRoute::_('index.php?option=com_mitglieder&view=mitglieder'); ?>"
	method="post" name="adminForm" id="adminForm">
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
	<table class="adminlist table table-striped table-hover span8">
	<thead>
		<tr>
			<th width="1%" class="nowrap center">
				<?php echo JText::_('#'); ?>
			</th>
			<th width="2%" class="nowrap center">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(<?php echo count($this->items); ?>);" />
			</th>
			<th width="50%" class="nowrap">
				<?php echo JText::_('Name'); ?>
			</th>
			<th width="45%" class="nowrap">
				<?php echo JText::_('Vorname'); ?>
			</th>
			<th width="2%" class="nowrap center">
				<?php echo JText::_('ID'); ?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php if (!empty($this->items)): ?>
		<?php foreach ($this->items as $i => $row):
			$link = JRoute::_('index.php?option=com_mitglieder&task=mitglied.edit&id=' . $row->id);
		?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo $i + 1; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $row->id); ?>
				</td>
				<td>
					<?php echo $row->name;?>
				</td>
				<td>
					<?php echo $row->vorname;?>
				</td>
				<td class="center">
					<?php echo $row->id; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
	</table>
</div>

<input type="hidden" name="option" value="com_mitglieder" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="view" value="mitglieder" />
<?php echo JHtml::_('form.token'); ?>
</form>
