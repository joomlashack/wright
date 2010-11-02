<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

class JElementLogo extends JElement
{

	var	$_name = 'Logo';

	function fetchElement($name, $value, &$node, $control_name)
	{
		jimport( 'joomla.filesystem.folder' );
		jimport( 'joomla.filesystem.file' );

		$files		= JFolder::files(JPATH_ROOT.DS.'images', '\.png$|\.gif$|\.jpg$|\.bmp$|\.ico$');

		$options = array ();

		$options[] = JHTML::_('select.option', 'template', '- '.JText::_('Use template logo').' -');

		foreach ($files as $file)
		{
			$options[] = JHTML::_('select.option', $file, $file);
		}

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', 'text', $value, $control_name.$name);
	}
}
