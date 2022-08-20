<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\Controller\BaseController;

class MitgliederController extends BaseController
{
	/**
	 * @param boolean $cachable
	 * @param array $urlparams
	 *
	 * @return  \JControllerLegacy
	 *
	 * @since   0.9
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Set the default view name and format from the Request.
		$vName = $this->input->get('view', 'abteilung');
		$this->input->set('view', $vName);

		return parent::display($cachable, $urlparams);
	}
}
