<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederControllerAbteilungen extends JControllerAdmin
{
	function __construct()
	{
		parent::__construct();

		$this->redirectPath = "index.php?option=com_mitglieder&view=abteilungen";
	}

	function delete()
	{
		$cid = $this->input->get('cid', array(), 'array');
		$model = $this->getModel('abteilung');
		if(!$model->delete($cid)) {
			$msg = JText::_( 'Fehler: Abteilung(en) konnten nicht gelöscht werden' );
		} else {
			$msg = JText::_( 'Abteilung(en) Gelöscht' );
		}

		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		return $this->setRedirect($this->redirectPath, $msg);
	}
}
