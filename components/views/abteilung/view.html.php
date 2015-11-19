<?php
defined('_JEXEC') or die();

class MitgliederViewAbteilung extends JViewLegacy
{

	function display($tpl = null)
	{
 		$model	  = $this->getModel();

 		$id = JFactory::getApplication()->input->get('abteilungsid', '-1', 'INT');
		if ($id === -1){
			//TODO: show standard view or display error message
		}
  		$this->abteilung = $model->getData($id);

		$params = JComponentHelper::getParams('com_mitglieder');

		$this->thumb_placeholder = JComponentHelper::getParams('com_mitglieder')
			->get('mitglied_thumb_placeholder');
		$this->thumb_cols = JComponentHelper::getParams('com_mitglieder')
			->get('thumbview_col_size', '4');

		// Change image for thumbnail if available
		foreach($this->abteilung->mitglieder as $mitglied)
		{
			$folder = JComponentHelper::getParams('com_media')->get('image_path',
				'images') . '/' . $params->get('image_path', 'stories/mitglieder');
			$path = JPATH_ROOT . '/' . $folder;
			$basename = pathinfo($mitglied->thumb, PATHINFO_BASENAME);
			$thumb = $path . '/thumbs/' . $basename;
			if (file_exists($thumb))
			{
				// path for view needs to be images/... not /var/www/joomla/images/...
				// so no JPATH_ROOT in here
				$mitglied->thumb = $folder . '/thumbs/' . $basename;
			}
		}

		parent::display($tpl);
	}
}
