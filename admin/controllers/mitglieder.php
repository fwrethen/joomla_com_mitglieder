<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederControllerMitglieder extends JControllerLegacy
{


	function __construct()
	{
		parent::__construct();

		$this->redirectPath = "index.php?option=com_mitglieder&view=mitglieder";
	}

	function save()
	{
		$model = $this->getModel('mitglied');
		$post = JRequest::get( 'post', 2);

		if ($model->save($post)) {
			$msg = JText::_( 'Mitglied gespeichert!' );
		} else {
			$msg = JText::_( 'Mitglied konnte nicht gespeichert werden' );
		}

		$model = $this->getModel('mitgliederabteilungen');
		if ($model->store($post)) {
			$msg += JText::_( 'Abteilungen gespeichert!' );
		} else {
			$msg += JText::_( 'Abteilungen konnte nicht gespeichert werden' );
		}



		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		return $this->setRedirect($this->redirectPath, $msg);
	}

	function delete()
	{
		$model = $this->getModel('mitglied');
		if(!$model->delete()) {
			$msg = JText::_( 'Fehler: Mitglied(er) konnten nicht gelöscht werden' );
		} else {
			$msg = JText::_( 'Mitglied(er) Gelöscht' );
		}

		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		return $this->setRedirect($this->redirectPath, $msg);
	}

	function display($cachable = false, $urlparams = false)
	{
		parent::display();
	}



}
?>
