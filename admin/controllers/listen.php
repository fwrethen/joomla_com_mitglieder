<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederControllerListen extends JControllerLegacy
{


	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'remove'  , 'delete' );

		$this->redirectPath = "index.php?option=com_mitglieder&view=listen";
	}

	function edit()
	{
		$input = JFactory::getApplication()->input;
		$input->set('view', 'liste');
		$input->set('layout', 'form');
		$input->set('hidemainmenu', 1);

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

		return $this->setRedirect($this->redirectPath, $msg);
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

		return $this->setRedirect($this->redirectPath, $msg);
	}

	function display($cachable = false, $urlparams = false)
	{
		parent::display();
	}



}
?>
