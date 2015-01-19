<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2015 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('JPATH_BASE') or die();

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Logo options for the template
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldLogo extends JFormFieldList
{
	public $type = 'Logo';

	/**
	 * Returns the options for the logo setting
	 *
	 * @return  array  Options
	 */
	protected function getOptions()
	{
		$options = array();

		$options[] = JHTML::_('select.option', 'template', '- ' . JText::_('TPL_JS_WRIGHT_FIELD_LOGO_TEMPLATE') . ' -');
		$options[] = JHTML::_('select.option', 'module', '- ' . JText::_('TPL_JS_WRIGHT_FIELD_LOGO_MODULE') . ' -');
		$options[] = JHTML::_('select.option', 'title', '- ' . JText::_('TPL_JS_WRIGHT_FIELD_LOGO_TITLE') . ' -');

		$files = JFolder::files(JPATH_ROOT . '/images', '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$');

		foreach ($files as $file)
		{
			$options[] = JHTML::_('select.option', $file, $file);
		}

		return $options;
	}
}
