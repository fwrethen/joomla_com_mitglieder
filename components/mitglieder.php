<?php
defined('_JEXEC') or die('Restricted access');

$controller = JControllerLegacy::getInstance('Mitglieder');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
