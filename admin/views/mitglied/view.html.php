<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MitgliederViewMitglied extends JView
{
	function display($tpl = null)
	{
	$document = JFactory::getDocument();
	//$document->addScript('includes/js/joomla.javascript.js');
			$player		= $this->get('Data');
			$inAbteilungen = $this->get('Data','MitgliederAbteilungen');
			$abteilungen = $this->get('Abteilungen','MitgliederAbteilungen');
		$isNew		= ($player->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Mitglied' ).': <small>[ ' . $text.' ]</small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('player',		$player);
		$this->assignRef('inAbteilungen',		$inAbteilungen);
		$this->assignRef('abteilungen',		$abteilungen);

		parent::display($tpl);
	}
}
