<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class MitgliederViewMitglied extends JViewLegacy
{
	function display($tpl = null)
	{
	$document = JFactory::getDocument();
	//$document->addScript('includes/js/joomla.javascript.js');
			$player		= $this->get('Data');
			$inAbteilungen = $this->get('Data','MitgliederAbteilungen');
			$abteilungen = $this->get('Abteilungen','MitgliederAbteilungen');
		$isNew		= ($player->id < 1);

		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title(JText::_('Mitglied: ' . $text), 'user');
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->form = $this->get('Form');

		$this->player = $player;
		$this->inAbteilungen = $inAbteilungen;
		$this->abteilungen = $abteilungen;

		parent::display($tpl);
	}
}
