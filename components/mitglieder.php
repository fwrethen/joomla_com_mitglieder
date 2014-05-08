<?php
/* Hagen Graf - cocoate.com - Nov. 2007 */

// kein direkter Zugriff
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

// laden des Joomla! Basis Controllers
require_once (JPATH_COMPONENT.DS.'controller.php');
// laden von weiterer Controllern

if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}

// Erzeugen eines Objekts der Klasse controller
$classname	= 'MitgliederController'.ucfirst($controller);
$controller = new $classname( );

// den request task ausleben
$controller->execute(JRequest::getCmd('task'));

// Redirect aus dem controller
$controller->redirect();

?>