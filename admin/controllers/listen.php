<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class MitgliederControllerListen extends JControllerLegacy
{


	function __construct()
	{
		parent::__construct();

		$this->redirectPath = "index.php?option=com_mitglieder&view=listen";
	}

	function save()
	{
		$model = $this->getModel('liste');
		$post = JRequest::get( 'post' );


		if ($model->save($post)) {
			$msg = JText::_( 'Liste gespeichert!' );
		} else {
			$msg = JText::_( 'Liste konnte nicht gespeichert werden' );
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
