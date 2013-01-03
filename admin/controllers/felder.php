<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.controller');

class FelderControllerFelder extends JController
{
	var $redirect = "index.php?option=com_mitglieder&controller=felder";

	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'apply', 'save');
	}

	function display( )
	{
		parent::display();
	}

	function cancel( )
	{
		$msg = JText::_( 'Abgebrochen' );
		$this->setRedirect( $this->redirect, $msg );
	}



	function save()
	{
		$model = $this->getModel('felder');
		if ($model->store(JRequest::get( 'post' ))) {
			$msg = JText::_( 'Felder gespeichert!' );
		} else {
			$msg = JText::_( 'Fehler beim speichern der Felder' );
		}

		$cache = & JFactory::getCache('com_ttverein');
		$cache->clean();

		$this->setRedirect($this->redirect, $msg);
	}

}
?>
