<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$controller = JControllerLegacy::getInstance('Mitglieder');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
