<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederControllerMitglieder extends JControllerAdmin
{
	function __construct()
	{
		parent::__construct();

		$this->redirectPath = "index.php?option=com_mitglieder&view=mitglieder";
	}

	function delete()
	{
		$cid = $this->input->get('cid', array(), 'array');
		$model = $this->getModel('mitglied');
		if(!$model->delete($cid)) {
			$msg = JText::_( 'Fehler: Mitglied(er) konnten nicht gelöscht werden' );
		} else {
			$msg = JText::_( 'Mitglied(er) Gelöscht' );
		}

		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		return $this->setRedirect($this->redirectPath, $msg);
	}
}
