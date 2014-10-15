<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2014 Joomlashack. Meritage Assets.  All rights reserved.
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
 * Wright field to create the grid width input
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldGrid extends JFormFieldList
{
	public $type = 'Grid';

	/**
	 * Creates the options of the grid width
	 *
	 * @return  array  Options
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		$size = ($this->element['size']) ? $this->element['size'] : 12;

		$options = array ();

		for ($i = 1; $i <= $size; $i++)
		{
			$val	= $i;
			$text	= $i;
			$options[] = JHTML::_('select.option', $val, JText::_($text));
		}

		return $options;
	}
}
