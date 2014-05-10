<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );

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

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Liste' ).': <small>[ ' . $text.' ]</small>' );
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
