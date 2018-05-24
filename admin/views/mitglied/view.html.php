<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederViewMitglied extends JViewLegacy
{
	function display($tpl = null)
	{
		$player = $this->get('Data');
		$inAbteilungen = $this->get('Abteilungen');
		$abteilungen = $this->get('AllAbteilungen');
		$isNew		= ($player->id < 1);

		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title(JText::_('Mitglied: ' . $text), 'user');
		JToolBarHelper::save('mitglieder.save');
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
