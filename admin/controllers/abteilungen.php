<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederControllerAbteilungen extends JControllerLegacy
{


	function __construct()
	{
		parent::__construct();

		$this->redirectPath = "index.php?option=com_mitglieder&view=abteilungen";
	}

	function save()
	{
		$model = $this->getModel('abteilung');
		$post = JRequest::get( 'post', 2 );


		if ($model->save($post)) {
			$msg = JText::_( 'Abteilung gespeichert!' );
		} else {
			$msg = JText::_( 'Absteilung konnte nicht gespeichert werden' );
		}


		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		return $this->setRedirect($this->redirectPath, $msg);
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

	function display($cachable = false, $urlparams = false)
	{
		parent::display();
	}



}
?>
