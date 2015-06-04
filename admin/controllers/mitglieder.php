<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.application.component.controller');


class MitgliederControllerMitglieder extends JControllerLegacy
{

	//var $redirect = "index.php?option=com_mitglieder&controller=mitglieder";

	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'remove'  , 'delete' );

		$this->redirectPath = "index.php?option=com_mitglieder&controller=mitglieder";

	}

	function edit()
	{
		JRequest::setVar( 'view', 'mitglied' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);
		$document = JFactory::getDocument();

		$viewType	= $document->getType();
		$view = $this->getView('mitglied',$viewType);
		$defModel= $this->getModel('mitglied');
		$view->setModel($defModel,true);

		$model= $this->getModel('mitgliederabteilungen');
		$model->_name='Abteilungen';
		$view->setModel($model);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('mitglied');
		$post = JRequest::get( 'post', 2);

		if ($model->store($post)) {
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

		$this->setRedirect($this->redirectPath, $msg);
	}

	function display($cachable = false, $urlparams = false)
	{
		parent::display();
	}



}
?>
