<?php
defined('_JEXEC') or die();
jimport('joomla.error.log');

require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_mitglieder' .DS. 'lib'.DS. 'config'.DS. 'config.php' );

class Logger
{
	function log($comment)
	{

		$config=Config::getConfig(array('logging'));
		if ($config['logging']==0)
		{
			return;
		}
		
		$options = array(
	    	'format' => "{DATE}\t{TIME}\t{COMMENT}"
		);
	
		$log = &JLog::getInstance('com_mitglieder.log.php', $options);
		$log->addEntry(array('comment'=>$comment));		
	}
	
	function logArray($array)
	{
		Logger::log(print_r($array,true));
	
	}
	
}