<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Template styles options
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class WrightFormFieldStyles extends JFormFieldList
{
	public $type = 'Styles';

	/**
	 * Styles options
	 *
	 * @return  array  Options
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		$filesFound = false;

		// Look for existing styles by checking files with filename in format: joomla-something.css
		$styles = JFolder::files(JPATH_ROOT . '/templates' . '/' . $this->form->getValue('template') . '/css', 'joomla-([^\.]*)\.css');

		if (!count($styles))
		{
		return array(JHTML::_('select.option', '', JText::_('TPL_JS_WRIGHT_NO_STYLES'), true));
		}

		foreach ($styles as $style)
		{
            $item = substr($style, 7, strpos($style, '.css') - 7);
            $val	= $item;
            $text	= ucfirst($item);

            // Output all the styles, except 'custom' style
            if($val != 'custom') {
                $options[] = JHTML::_('select.option', $val, JText::_($text));
            }
		}

		// Custom style with support for custom colors
		$options[] = JHTML::_('select.option', 'custom', JText::_('Custom'));


		return $options;
	}
}
