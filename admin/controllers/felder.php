<?php
defined('_JEXEC') or die();

class MitgliederControllerFelder extends JControllerAdmin
{
	public function __construct()
	{
		parent::__construct();

		$this->redirectPath = "index.php?option=com_mitglieder&view=felder";
	}

	public function display($cachable = false, $urlparams = false)
	{
		parent::display();
	}

	public function cancel()
	{
		$msg = JText::_('Änderungen verworfen');
		$this->setRedirect($this->redirectPath, $msg);
	}

	public function save()
	{
		$model = $this->getModel('felder');
		$formData = $this->input->get('jform', null, 'string');

		if ($model->store($formData)) {
			$msg = JText::_('Felder gespeichert!');
		} else {
			$msg = JText::_('Fehler beim speichern der Felder');
		}

		$cache = JFactory::getCache('com_mitglieder');
		$cache->clean();

		return $this->setRedirect($this->redirectPath, $msg);
	}

}
?>
