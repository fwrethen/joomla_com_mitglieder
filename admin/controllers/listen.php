<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class ListenControllerListen extends JController
{

	var $redirect = "index.php?option=com_mitglieder&controller=listen";

	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'remove'  , 'delete' );

	}

	function edit()
	{
		JRequest::setVar( 'view', 'liste' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	function save()
	{
		$model = $this->getModel('liste');
		$post = JRequest::get( 'post' );


		if ($model->store($post)) {
			$msg = JText::_( 'Liste gespeichert!' );
		} else {
			$msg = JText::_( 'Liste konnte nicht gespeichert werden' );
		}

		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		$this->setRedirect($this->redirect, $msg);
	}

	function delete()
	{
		$model = $this->getModel('liste');
		if(!$model->delete()) {
			$msg = JText::_( 'Fehler: Liste(n) konnten nicht gelöscht werden' );
		} else {
			$msg = JText::_( 'Liste(n) Gelöscht' );
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
