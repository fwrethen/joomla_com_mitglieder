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
	    	'format' => "{DATE}\t{TIME}\t{COMMENT}"
		);

		$log = JLog::getInstance('com_mitglieder.log.php', $options);
		$log->addEntry(array('comment'=>$comment));
	}

	static function logArray($array)
	{
		Logger::log(print_r($array,true));

	}

}
