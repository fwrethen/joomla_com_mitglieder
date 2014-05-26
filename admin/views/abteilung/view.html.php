<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

/**
 * @author Florian Paetz
 */
class AbteilungenViewAbteilung extends JViewLegacy
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

		$AbteilungenFelder = $this->get('Data','AbteilungenFelder');
		$felder = $this->get('Felder','AbteilungenFelder');


		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Abteilung' ).': <small>[ ' . $text.' ]</small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->team = $team;
		$this->AbteilungenFelder = $AbteilungenFelder;
		$this->felder = $felder;

		parent::display($tpl);
	}
}
?>
