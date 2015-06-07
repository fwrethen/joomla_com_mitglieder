<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// Require the base controller
//require_once (JPATH_COMPONENT.DS.'controller.php');

$controller = JRequest::getVar('controller');

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

require_once (JPATH_COMPONENT.DS.'controllers'.DS. $controller . '.php');
// Create the controller
$classname	= $controller . 'Controller'.$controller;
$controller = new $classname( );




// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();

?>
