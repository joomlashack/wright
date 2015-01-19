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

jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');

/**
 * Help field
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldHelp extends JFormField
{
	protected $type = 'Help';

	/**
	 * Creates the help input
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
		JHTML::_('behavior.modal');
		$doc = JFactory::getDocument();
		$template = $this->form->getValue('template');

		if (file_exists(JPATH_ROOT . '/templates/' . $template . '/wrighttemplate.php'))
		{
			require_once JPATH_ROOT . '/templates/' . $template . '/wrighttemplate.php';

			$wrightTemplate = WrightTemplate::getInstance();

			$html = '<a class="modal" href="' . $wrightTemplate->documentationLink . '" rel="{\'handler\': \'iframe\', \'size\': {x: 800, y:600}}">' . JText::_('TPL_JS_WRIGHT_FIELD_DOCUMENTATION') . '</a>';

			// Refresh CSS cache since we are editing params
			if (is_file(JPATH_ROOT . '/templates' . '/' . $template . '/css' . '/' . $template . '.css'))
			{
				JFile::delete(JPATH_ROOT . '/templates' . '/' . $template . '/css' . '/' . $template . '.css');
			}

			return $html;
		}

		return '';
	}
}
