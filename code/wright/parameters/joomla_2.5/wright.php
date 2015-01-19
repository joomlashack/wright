<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2015 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

/**
 * Wright basic field to include language files and other global properties for all the rest of the parameters in the template config
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       3.0
 */
class JFormFieldWright extends JFormField
{
	protected $type = 'Wright';

	/**
	 * Creates the Wright input (empty)
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
		return '';
	}

	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 */
	protected function getLabel()
	{
		return JText::_('TPL_JS_WRIGHT_POWERED');
	}
}
