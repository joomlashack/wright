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
 * Color picker parameter class
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldColorPicker extends JFormField
{
	protected $type = 'ColorPicker';

	/**
	 * Creates color picker
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
		$doc = JFactory::getDocument();
		$template = $this->form->getValue('template');
		$doc->addScript(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $template . '/wright/parameters/assets/jscolor/jscolor.js');

		$size = ( $this->element['size'] ? 'size="' . $this->element['size'] . '"' : '' );
		$value = htmlspecialchars_decode($this->value, ENT_QUOTES);

		$html = '<input type="text" name="' . $this->name . '" id="' . $this->name . '" value="' . $value . '" class="color" ' . $size . ' /> ';

		return $html;
	}
}
