<?php
defined('_JEXEC') or die();

/**
 * @author Florian Paetz
 */
class MitgliederModelAbteilung extends JModelAdmin
{
	function __construct()
	{
		parent::__construct();

		$input = JFactory::getApplication()->input;
		$this->setId($input->get('id'));
	}

	function setId($id)
	{
		$this->_id		= $id;
	}

	function getData()
	{
		$row = $this->getTable();
		$row->load($this->_id);

		return $row;
	}


	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids ))
		{
			foreach($cids as $cid) {
				/*
				 * Mitgliederzuordnungen löschen
				 */
				$query = "DELETE FROM #__mitglieder_mitglieder_abteilungen " .
						" WHERE abteilungen_id=" . $cid;
				$this->_db->setQuery($query);
				if ( !$this->_db->query() ) {
					JError::raiseError(105, $this->_db->getErrorMsg());
               		return false;
				}

				/*
				 * Abteilung löschen
				 */
				if (!$row->delete( $cid )) {
					JError::raiseError(106, $this->_db->getErrorMsg());
					return false;
				}

			}
		}
		return true;
	}

	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_mitglieder.abteilung', 'abteilung', array('control' => '', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

}
?>
