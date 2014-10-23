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

jimport('joomla.form.formfield');

/**
 * Template custom parameters (no parameter if it's not set by the template)
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldTemplateCustom extends JFormField
{
	protected $type = 'TemplateCustom';

	/**
	 * Creates a field (fallback)
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
		$html = '';
		$html .= '<input type="hidden" name="' . $this->name . '" id="' . $this->name . '" value="' . $value . '" /> ';

		return $html;
	}
}
