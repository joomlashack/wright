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

		if ($doc->document->params->get('rebrand', 'no') !== 'yes')
		{
			return '<a target="_blank" class="joomlashack" href="http://www.joomlashack.com"><img src="./templates/' . JFactory::getApplication()->getTemplate() . '/wright/images/jscright.png" alt ="Joomlashack" /> </a>';
		}
	}
}
