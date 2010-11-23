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

		$author = simplexml_load_file(JPATH_ROOT.DS.'templates'.DS.$_GET['cid'][0].DS.'templateDetails.xml')->author;
		if (stripos($author, 'shack'))
			$html .= '&nbsp;<a href="http://www.joomlashack.com/licensing-center" target="_blank">What is rebranding?</a>';

		return $html;
	}
}