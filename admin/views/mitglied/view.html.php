<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

/**
 * View to edit a mitglied.
 *
 * @since  0.9
 */
class MitgliederViewMitglied extends HtmlView
{
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @since   0.9
	 */
	function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->inAbteilungen = $this->get('Abteilungen');
		$this->abteilungen = $this->get('AllAbteilungen');

		$this->player = &$this->item;

		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	protected function addToolbar()
	{
		$isNew = ($this->item->id == 0);
		$text = $isNew ? JText::_( 'Neu' ) : JText::_( 'Bearbeiten' );

		JToolBarHelper::title(JText::_('Mitglied: ' . $text), 'user');
		JToolBarHelper::save('mitglied.save');

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('mitglied.cancel');
		}
		else
		{
			JToolbarHelper::cancel('mitglied.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
