<?php
defined('_JEXEC') or die;

class MitgliederHelper extends JHelperContent
{
	public static function addSubmenu($vName = 'mitglieder')
	{
		JHtmlSidebar::addEntry(
		    JText::_('COM_MITGLIEDER_MENU_MITGLIEDER'),
		    'index.php?option=com_mitglieder&amp;view=mitglieder',
		    $vName == 'mitglieder'
		);

		JHtmlSidebar::addEntry(
		    JText::_('COM_MITGLIEDER_MENU_ABTEILUNGEN'),
		    'index.php?option=com_mitglieder&amp;view=abteilungen',
		    $vName == 'abteilungen'
		);

		JHtmlSidebar::addEntry(
		    JText::_('COM_MITGLIEDER_MENU_FELDER'),
		    'index.php?option=com_mitglieder&amp;view=felder',
		    $vName == 'felder'
		);

		JHtmlSidebar::addEntry(
		    JText::_('COM_MITGLIEDER_MENU_LISTE'),
		    'index.php?option=com_mitglieder&amp;view=liste&amp;layout=edit',
		    $vName == 'liste'
		);
	}
}
