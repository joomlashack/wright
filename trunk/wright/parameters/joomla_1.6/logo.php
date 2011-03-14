<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of file
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldLogo extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'Logo';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		$options[] = JHTML::_('select.option', 'template', '- '.JText::_('Use template logo').' -');
		$options[] = JHTML::_('select.option', 'module', '- '.JText::_('Use module with position of logo').' -');
		$options[] = JHTML::_('select.option', 'title', '- '.JText::_('Use site title').' -');

		foreach ($files as $file)
		{
			$options[] = JHTML::_('select.option', $file, $file);
		}

		return $options;
	}
}