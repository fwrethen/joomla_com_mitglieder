<?php
defined('_JEXEC') or die();

jimport('joomla.error.log');

class Logger
{
	static function log($comment)
	{

		$params = JComponentHelper::getParams('com_mitglieder');
		if ($params->get('logging', '0')==0)
		{
			return;
		}

		$options = array(
				'text_file' => 'com_mitglieder.log.php',
				'format' => '{DATE}\t{TIME}\t{COMMENT}'
		);

		JLog::addLogger($options, JLog::ALL, 'com_mitglieder');
		JLog::add($comment, JLog::WARNING, 'com_mitglieder');
	}

	static function logArray($array)
	{
		Logger::log(print_r($array,true));

	}

}
