<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// TODO: drop custom stuff and use:
//$controller = JControllerLegacy::getInstance('Mitglieder');

$controller = JFactory::getApplication()->input->get('view');
/*
 * Standart ist das controlpanel falls kein Controler angegeben wird.
 * Hier werden auch alle Gültigen Controler für das Menü angegeben.
 */
switch($controller)  {
	default:
		$controller = 'mitglieder';
	case 'abteilungen':
	case 'felder':
	case 'listen':
	case 'mitglieder':
}

require_once (JPATH_COMPONENT . '/controllers/' . $controller . '.php');
// Create the controller
$classname	= 'MitgliederController'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
