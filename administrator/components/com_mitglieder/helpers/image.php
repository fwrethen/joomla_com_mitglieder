<?php
defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');
jimport('joomla.image.image');

/**
 * Image helper.
 *
 * @since  1.2
 */
class ImageHelper
{
	/**
	 * Create Thumbnail from Image
	 *
	 * @param  string   $uri        Path and filename of Image.
	 * @param  integer  $width      Width of thumbnail in pixels.
	 * @param  integer  $height     Height of thumbnail in pixels.
	 * @param  string   $path       Path to save thumbnail to.
	 * @param  boolean  $overwrite  Overwrite existing thumbnail.
	 *
	 * @since  1.2
	 */
	public static function createThumb($uri, $width, $height, $path = null, $overwrite = true)
	{
		if (!JFile::exists($uri) || !$path)
		{
			return false;
		}
		JFolder::makeSafe($path);
		$thumbsFolder = $path . '/thumbs';
		if (!JFolder::exists($thumbsFolder) && (!is_dir(dirname($thumbsFolder)) || !JFolder::create($thumbsFolder)))
		{
			throw new InvalidArgumentException('Folder does not exist and cannot be created: ' . $thumbsFolder);
		}
		$filename = pathinfo($uri, PATHINFO_FILENAME);
		$fileExtension = pathinfo($uri, PATHINFO_EXTENSION);
		$thumbUri = $filename . '.' . $fileExtension;
		$thumbUri = $thumbsFolder . '/' . $thumbUri;
		//check if thumb is already present
		if (file_exists($thumbUri) && !$overwrite)
		{
			return $thumbUri;
		}
		$thumb = new JImage($uri);
		$thumb = $thumb->cropresize($width, $height);
		$imgProperties = JImage::getImageFileProperties($uri);
		//write file to disk
		$thumb->toFile($thumbUri, $imgProperties->type);

		return $thumbUri;
	}
}
