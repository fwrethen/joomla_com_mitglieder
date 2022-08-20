<?php
defined('_JEXEC') or die();

use Joomla\CMS\MVC\View\HtmlView;

class MitgliederViewAbteilung extends HtmlView
{
	protected $abteilung;
	protected $thumb_placeholder;
	protected $thumb_cols;

	/**
	 * @param string $tpl
	 * @return mixed
	 * @throws Exception
	 * @since 0.9
	 */
	public function display($tpl = null)
	{
 		$model	  = $this->getModel();
		$layout		= $this->getLayout();

 		$id = JFactory::getApplication()->input->get('abteilungsid', '-1', 'INT');
		if ($id === -1){
			//TODO: show standard view or display error message
		}
		$this->abteilung = $model->getData($id);

		// Do thumbnail stuff only if thumb template is requested
		if ($layout == 'thumbs'){
			$this->abteilung->mitglieder = $model->getThumbData($id, $this->abteilung->mitglieder);

			$params = JComponentHelper::getParams('com_mitglieder');

			$this->thumb_placeholder = JComponentHelper::getParams('com_mitglieder')
				->get('mitglied_thumb_placeholder');
			$this->thumb_cols = JComponentHelper::getParams('com_mitglieder')
				->get('thumbview_col_size', '4');

			// Change image for thumbnail if available
			foreach($this->abteilung->mitglieder as $mitglied)
			{
				$folder = JComponentHelper::getParams('com_media')->get(
				    'image_path',
				    'images'
				) . '/' . $params->get('image_path', 'stories/mitglieder');
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
		}

		return parent::display($tpl);
	}
}
