<?php // $Id$
defined('_JEXEC') or die('Restricted access');

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
}