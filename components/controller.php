<?php
defined('_JEXEC') or die();

class MitgliederController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = false)
	{
		// Set the default view name and format from the Request.
		$vName = $this->input->get('view', 'abteilung');
		$this->input->set('view', $vName);

		parent::display($cachable, $urlparams);
	}
}
