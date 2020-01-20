<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

/**
 * Class to create footer adapter
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class WrightAdapterJoomlaFooter
{
	/**
	 * Renders the footer
	 *
	 * @param   Array  $args  Args sent
	 *
	 * @return  JFormField  Formatted input
	 */
	public function render($args)
	{
		$doc = Wright::getInstance();

		if ($doc->document->params->get('rebrand', '0') !== '1')
		{
			return '<div class="joomlashack">&copy; <a target="_blank" href="https://www.joomlashack.com/joomla-templates/">Joomla templates</a> by <img src="./templates/' . JFactory::getApplication()->getTemplate() . '/wright/images/jscright.png" alt ="Joomlashack" /></div>';
		}
	}
}
