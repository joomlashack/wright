<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2014 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('JPATH_BASE') or die();

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Template presets
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldPresets extends JFormFieldList
{
	var	$_name = 'Presets';

	/**
	 * Returns the presets options
	 *
	 * @return  array  Options
	 */
	protected function getOptions()
	{
		$doc = JFactory::getDocument();
		$template = $this->form->getValue('template');
		$doc->addScript(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $template . '/wright/parameters/assets/presets/presets.js');

		$file = simplexml_load_file(JPATH_ROOT . '/templates' . '/' . $template . '/presets.xml');

		$json = str_replace('@attributes', 'attributes', json_encode($file));

		$doc->addScriptDeclaration('var presets = ' . $json);

		$options = array ();

		foreach ($file->xpath('//preset') as $preset)
		{
			$options[] = JHTML::_('select.option', $preset['name'], $preset['title']);
		}

		return $options;
	}
}
