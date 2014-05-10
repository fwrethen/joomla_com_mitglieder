<?php

defined('_JEXEC') or die();
jimport('joomla.application.component.controller');


class MitgliederController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = false)
	{
		// Setzt einen Standard view
		if ( ! JRequest::getCmd( 'view' ) ) {
			JRequest::setVar('view', 'abteilung' );
		}
		
		parent::display(true);
	}
}
