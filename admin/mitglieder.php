<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// TODO: drop custom stuff and use:
//$controller = JControllerLegacy::getInstance('Mitglieder');

$controller = JFactory::getApplication()->input->get('controller');

/*
 * Standart ist das controlpanel falls kein Controler angegeben wird.
 * Hier werden auch alle Gültigen Controler für das Menü angegeben.
 */
switch($controller)  {
	default:
		$controller = 'abteilungen';
	case 'abteilungen':
	case 'felder':
	case 'listen':
	case 'mitglieder':
	case 'altersklassen':
	case 'controlpanel':
	case 'help':

}

require_once (JPATH_COMPONENT . '/controllers/' . $controller . '.php');
// Create the controller
$classname	= $controller . 'Controller'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
