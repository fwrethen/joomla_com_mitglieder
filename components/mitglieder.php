<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;

$controller = BaseController::getInstance('Mitglieder');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
