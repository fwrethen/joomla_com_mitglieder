<?php
defined('_JEXEC') or die();

/**
 * @author Florian Paetz
 */
class MitgliederViewAbteilung extends JViewLegacy
{
	function display($tpl = null)
	{
	$document = JFactory::getDocument();
	$document->addScript('includes/js/joomla.javascript.js');
		$team		= $this->get('Data');
		if($team->id < 1)
			$isNew = true;
		else
			$isNew = false;

		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title(JText::_('Abteilung: ' . $text), 'archive');
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->form = $this->get('Form');

		$this->team = $team;

		parent::display($tpl);
	}
}
?>
