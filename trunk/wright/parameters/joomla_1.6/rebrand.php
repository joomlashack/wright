<?php // $Id: datetime.php 19 2010-08-03 01:24:09Z jeremy $
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldRebrand extends JFormField
{

	protected $type = 'Rebrand';

	protected function getInput()
	{
		// Initialize variables.
		$html = array();

		// Initialize some field attributes.
		$class = $this->element['class'] ? ' class="radio '.(string) $this->element['class'].'"' : ' class="radio"';

		// Start the radio field output.
		$html[] = '<fieldset id="'.$this->id.'"'.$class.'>';

		// Get the field options.
		$options = array();
		$options[] = JHTML::_('select.option', 'no', JText::_('No'));
		$options[] = JHTML::_('select.option', 'yes', JText::_('Yes'));

		// Build the radio field output.
		foreach ($options as $i => $option) {

			// Initialize some option attributes.
			$checked	= ((string) $option->value == (string) $this->value) ? ' checked="checked"' : '';
			$class		= !empty($option->class) ? ' class="'.$option->class.'"' : '';
			$disabled	= !empty($option->disable) ? ' disabled="disabled"' : '';

			// Initialize some JavaScript option attributes.
			$onclick	= !empty($option->onclick) ? ' onclick="'.$option->onclick.'"' : '';

			$html[] = '<input type="radio" id="'.$this->id.$i.'" name="'.$this->name.'"' .
					' value="'.htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8').'"'
					.$checked.$class.$onclick.$disabled.'/>';

			$html[] = '<label for="'.$this->id.$i.'"'.$class.'>'.JText::_($option->text).'</label>';
		}

		// End the radio field output.
		$html[] = '</fieldset>';

		return implode($html);
	}

}
/*
class JElementRebrand extends JElement
{
	var	$_name = 'Rebrand';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$options = array();
		$options[] = JHTML::_('select.option', 'no', JText::_('No'));
		$options[] = JHTML::_('select.option', 'yes', JText::_('Yes'));

		$html = JHTML::_('select.radiolist', $options, ''.$control_name.'['.$name.']', '', 'value', 'text', $value, $control_name.$name );

		$html .= '<a href="http://www.joomlashack.com/licensing-center" target="_blank">Click here to learn more about rebranding.</a>';

		return $html;
	}
}*/