<?php
defined('_JEXEC') or die();

class MitgliederModelFelder extends JModelList
{

	/**
	 * Method to get a \JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return  \JDatabaseQuery  A \JDatabaseQuery object to retrieve the data set.
	 *
	 * @since   2.0
	 */
	function getListQuery()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName(array('id', 'name_backend', 'name_frontend', 'typ', 'show', 'tooltip', 'ordering')));
		$query->from($db->quoteName('#__mitglieder_felder'));
		$query->order('ordering, id ASC');

		return $query;
	}


function getTypen() {
		$typen = array();

		$typ = new stdClass();
		$typ->typ = "text";
		$typen[] = $typ;

		$typ = new stdClass();
		$typ->typ = "text_html";
		$typen[] = $typ;

		$typ = new stdClass();
		$typ->typ = "email";
		$typen[] = $typ;

		$typ = new stdClass();
		$typ->typ = "telefon";
		$typen[] = $typ;

		$typ = new stdClass();
		$typ->typ = "datum";
		$typen[] = $typ;

		$typ = new stdClass();
		$typ->typ = "jahre seit";
		$typen[] = $typ;

		$typ = new stdClass();
		$typ->typ = "liste";
		$typen[] = $typ;

		$typ = new stdClass();
		$typ->typ = "bild";
		$typen[] = $typ;

		return $typen;
	}

	function store($post=null)
	{
		foreach($post['alte_namen_backend'] as $id=>$name_backend) {
			$typ = $post['alte_typen'][$id];
			$name_frondend = $post['alte_namen_frondend'][$id];
			$zeige_in_uebersicht = $post['alte_zeige_in_uebersicht'][$id];
			if ($zeige_in_uebersicht=='')
			{
				$zeige_in_uebersicht='0';
			}
			$tooltip = $post['alte_tooltip'][$id];
			$ordering = $post['alte_ordering'][$id];
			$query = "UPDATE #__mitglieder_felder " .
					" SET name_backend='$name_backend', " .
						" name_frontend='$name_frondend', " .
						" `show`=$zeige_in_uebersicht, " .
						" tooltip='$tooltip', " .
						" typ='$typ', " .
						" ordering=$ordering " .
			" WHERE id=$id ";
			$this->_db->setQuery($query);
			$this->_db->execute();
		}
		for($i=0; $i < count($post['neue_namen_backend']); $i++){
			$name_backend = $post['neue_namen_backend'][$i];
			$name_frondend = $post['neue_namen_frontend'][$i];
			$zeige_in_uebersicht = $post['neue_zeige_in_uebersicht'][$i];
			if (!isset($zeige_in_uebersicht) || ($zeige_in_uebersicht==''))
			{
				$zeige_in_uebersicht=0;
			}
			$tooltip = $post['neue_tooltip'][$i];
			$typ = $post['neue_typen'][$i];
			$ordering = $post['neue_ordering'][$i];
			if (!isset($ordering) || ($ordering==''))
			{
				$ordering=0;
			}
			if(!$typ || !$name_backend)
				continue;
			$query = "INSERT INTO #__mitglieder_felder(" .
							" name_backend, name_frontend, " .
							" `show`, typ, tooltip, ordering" .
						" ) " .
						" VALUES(" .
							" '$name_backend', '$name_frondend', $zeige_in_uebersicht, " .
							" '$typ', '$tooltip',$ordering) ";
			$this->_db->setQuery($query);
			$this->_db->execute();
		}
		return true;
	}

}
