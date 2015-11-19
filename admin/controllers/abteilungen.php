<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class AbteilungenControllerAbteilungen extends JControllerLegacy
{


	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'remove'  , 'delete' );

		$this->redirectPath = "index.php?option=com_mitglieder&controller=abteilungen";
	}

	function edit()
	{
		JRequest::setVar( 'view', 'abteilung' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		$document = JFactory::getDocument();

		$viewType	= $document->getType();
		$view = $this->getView('abteilung',$viewType);
		$defModel= $this->getModel('abteilung');
		$view->setModel($defModel,true);

		parent::display();
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
		$model = $this->getModel('abteilung');
		if(!$model->delete()) {
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
