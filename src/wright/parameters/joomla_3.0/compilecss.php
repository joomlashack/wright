<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

/**
 * Wright button to trigger less compiler
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       3.9.1
 */
class JFormFieldCompilecss extends JFormField
{
	protected $type = 'Compilecss';

	/**
	 * Creates the Compilecss button field
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
        $doc        = JFactory::getDocument();
        $template   = $this->form->getValue('template');
        $doc->addScript(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $template . '/wright/parameters/assets/compilecss.js');

        $html  = '<a class="btn btn-primary" id="wCompileCssBtn" href="' . str_replace('/administrator/', '/', JURI::base()) . '?tmpl=render">' . JText::_('Compile') . '</a>';
        $html .= '<div id="wCompileCssStatus"></div>';

        return $html;
	}

	/**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 */
	protected function getLabel()
	{
		return '';
	}
}
