<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

/**
 * @author Florian Paetz
 */
class AbteilungenViewAbteilung extends JView
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

		$AbteilungenFelder = $this->get('Data','Felder');
		$felder = $this->get('Felder','Felder');


		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Abteilung' ).': <small>[ ' . $text.' ]</small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('team',		$team);
		$this->assignRef('AbteilungenFelder',		$AbteilungenFelder);
		$this->assignRef('felder',		$felder);


		parent::display($tpl);
	}
}
?>
