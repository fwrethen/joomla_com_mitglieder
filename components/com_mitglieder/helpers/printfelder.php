<?php

use Joomla\CMS\Date\Date;

defined('_JEXEC') or die('Restricted access');

function printField(StdClass $fieldData): StdClass
{
	return (object) [
		'name' => $fieldData->name,
		'display' => determineFieldDisplay($fieldData),
		'value' => determineFieldValue($fieldData),
	];
}

function determineFieldDisplay(StdClass $data): string
{
	if ($data->typ === 'bild') {
		return 'image';
	}

	return 'text';
}

function determineFieldValue(StdClass $data): ?string
{
	switch($data->typ) {
		case "jahre seit":
			// Future dates will also give positive diff but who cares...
			$age = date_diff(new Date($data->datum), new Date());

			if ($age->y < 1) {
				if ($age->m < 1)
					$text = 'unbekannt';
				elseif ($age->m == 1)
					$text = $age->m . ' Monat';
				else
					$text = $age->m . ' Monate';
			}
			elseif ($age->y == 1)
				$text = $age->y . ' Jahr';
			else
				$text = $age->y . ' Jahre';

			return $text;

		case "text":
			// strip tags and replace newline with <br />
			return nl2br(strip_tags($data->text));

		case "liste":
			return $data->wert;

		case "text_html":
		case "email":
		case "telefon":
		case "bild":
		default:
			return $data->text;
	}
}
