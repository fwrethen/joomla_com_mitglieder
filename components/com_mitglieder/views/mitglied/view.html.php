<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

class MitgliederViewMitglied extends HtmlView
{
	protected $mitglied;

	/**
	 * @param string $tpl
	 * @return mixed
	 * @throws Exception
	 * @since 0.9
	 */
	public function display($tpl = null)
	{
		$id = JFactory::getApplication()->input->get('id', '-1', 'INT');

		$model = $this->getModel();
		if ($id === -1) {
			//TODO: show standard view or display error message
		}

  		$this->mitglied = $model->getMitglied($id);

		return parent::display($tpl);
	}
}
