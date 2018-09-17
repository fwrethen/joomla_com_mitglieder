<?php
defined('_JEXEC') or die();

/**
 * @author Florian Paetz
 */
class MitgliederViewListe extends JViewLegacy
{
	function display($tpl = null)
	{
		$liste		= $this->get('Data');
		if($liste->id < 1)
			$isNew = true;
		else
			$isNew = false;

		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );
		JToolBarHelper::title(JText::_('Liste: ' . $text), 'list');
		JToolBarHelper::save('listen.save');
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->liste = $liste->values;
		$this->listenid = $liste->id;

		parent::display($tpl);
	}
}
?>
