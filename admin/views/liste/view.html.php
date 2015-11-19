<?php
defined('_JEXEC') or die();

/**
 * @author Florian Paetz
 */
class ListenViewListe extends JViewLegacy
{
	function display($tpl = null)
	{
	$document = JFactory::getDocument();
	$document->addScript('includes/js/joomla.javascript.js');
		$liste		= $this->get('Data');
		if($liste->id < 1)
			$isNew = true;
		else
			$isNew = false;

		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title(JText::_('Liste: ' . $text), 'list');
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->liste = $liste;
		$this->listenid = $this->get('Liste');

		parent::display($tpl);
	}
}
?>
