<?php
defined('_JEXEC') or die;

class MitgliederHelper extends JHelperContent
{
	public static function addSubmenu($vName = 'mitglieder')
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_MITGLIEDER_MENU_MITGLIEDER'),
			'index.php?option=com_mitglieder&amp;controller=mitglieder',
			$vName == 'mitglieder'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_MITGLIEDER_MENU_ABTEILUNGEN'),
			'index.php?option=com_mitglieder&amp;controller=abteilungen',
			$vName == 'abteilungen'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_MITGLIEDER_MENU_FELDER'),
			'index.php?option=com_mitglieder&amp;controller=felder',
			$vName == 'felder'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_MITGLIEDER_MENU_LISTEN'),
			'index.php?option=com_mitglieder&amp;controller=listen',
			$vName == 'listen'
		);
	}
}
