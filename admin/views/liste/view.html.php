<?php
defined('_JEXEC') or die();

/**
 * View to edit a liste.
 *
 * @since  0.9
 */
class MitgliederViewListe extends JViewLegacy
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
		$this->item = $this->get('Item');

		$this->liste = $this->item->values;
		$this->listenid = $this->item->id;

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

		JToolBarHelper::title(JText::_('Liste: ' . $text), 'list');
		JToolBarHelper::save('listen.save');

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('cancel');
		}
		else
		{
			JToolbarHelper::cancel('cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
