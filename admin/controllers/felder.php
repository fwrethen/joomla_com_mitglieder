<?php
defined('_JEXEC') or die();

class MitgliederControllerFelder extends JControllerLegacy
{


	function __construct()
	{
		parent::__construct();

		$this->registerTask( 'apply', 'save');

		$this->redirectPath = "index.php?option=com_mitglieder&view=felder";
	}

	function display($cachable = false, $urlparams = false)
	{
		parent::display();
	}

	function cancel( )
	{
		$msg = JText::_( 'Abgebrochen' );
		$this->setRedirect( $this->redirectPath, $msg );
	}



	function save()
	{
		$model = $this->getModel('felder');
		if ($model->store(JRequest::get( 'post' ))) {
			$msg = JText::_( 'Felder gespeichert!' );
		} else {
			$msg = JText::_( 'Fehler beim speichern der Felder' );
		}

		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		return $this->setRedirect($this->redirectPath, $msg);
	}

}
?>
