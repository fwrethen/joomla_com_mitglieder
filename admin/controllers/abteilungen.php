<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class AbteilungenControllerAbteilungen extends JControllerLegacy
{

	var $redirect = "index.php?option=com_mitglieder&controller=abteilungen";

	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'remove'  , 'delete' );

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

		$model= $this->getModel('abteilungenfelder');
		$model->_name='Felder';
		$view->setModel($model);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('abteilung');
		$post = JRequest::get( 'post', 2 );


		if ($model->store($post)) {
			$msg = JText::_( 'Abteilung gespeichert!' );
		} else {
			$msg = JText::_( 'Absteilung konnte nicht gespeichert werden' );
		}


		$model = $this->getModel('abteilungenfelder');
		if ($model->store($post)) {
			$msg += JText::_( 'Felder gespeichert!' );
		} else {
			$msg += JText::_( 'Felder konnte nicht gespeichert werden' );
		}


		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		$this->setRedirect($this->redirect, $msg);
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

		$this->setRedirect($this->redirect, $msg);
	}

	function display($cachable = false, $urlparams = false)
	{
		parent::display();
	}



}
?>
