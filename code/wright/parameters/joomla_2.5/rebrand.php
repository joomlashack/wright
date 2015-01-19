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

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Rebrand (licence info) field
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldRebrand extends JFormField
{
	protected $type = 'Rebrand';

	/**
	 * Creates the rebranding input
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
		JHTML::_('behavior.modal');
		$doc = JFactory::getDocument();
		$template = $this->form->getValue('template');

		$html = array();

		$class = $this->element['class'] ? ' class="radio ' . (string) $this->element['class'] . '"' : ' class="radio"';

		$html[] = '<fieldset id="' . $this->id . '"' . $class . '>';

		// Get the field options.
		$options = array();
		$options[] = JHTML::_('select.option', 'no', JText::_('JNO'));
		$options[] = JHTML::_('select.option', 'yes', JText::_('JYES'));

		// Build the radio field output.
		foreach ($options as $i => $option)
		{
			// Initialize some option attributes.
			$checked	= ((string) $option->value == (string) $this->value) ? ' checked="checked"' : '';
			$class		= !empty($option->class) ? ' class="' . $option->class . '"' : '';
			$disabled	= !empty($option->disable) ? ' disabled="disabled"' : '';

			// Initialize some JavaScript option attributes.
			$onclick	= !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';

			$html[] = '<input type="radio" id="' . $this->id . $i . '" name="' . $this->name . '"' .
					' value="' . htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"'
					. $checked . $class . $onclick . $disabled . '/>';

			$html[] = '<label for="' . $this->id . $i . '"' . $class . '>' . JText::_($option->text) . '</label>';
		}

		$author = simplexml_load_file(JPATH_ROOT . '/templates' . '/' . $template . '/templateDetails.xml')->author;

		if (stripos($author, 'shack'))
			$html[] = '&nbsp;<a class="modal" rel="{\'handler\': \'iframe\', \'size\': {x: 800, y:600}}"" href="https://www.joomlashack.com/joomla-template/licensing-center">' . JText::_('TPL_JS_WRIGHT_FIELD_REBRAND_LICENSE') . '</a>';

		// End the radio field output.
		$html[] = '</fieldset>';

		return implode($html);
	}
}
