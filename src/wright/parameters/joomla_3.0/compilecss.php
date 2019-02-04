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

        $doc->addScriptDeclaration('
            jQuery(function ($) {
                $(\'#wCompileCssBtn\').on(\'click\', function (event) {
                    event.preventDefault();

                    // Save template style
                    //Joomla.submitbutton(\'style.apply\');

                    // Call LESS compilation page
                    $.ajax(this.href, {
                        success: function(data) {
                            console.log(\'success\');
                            $(\'#wCompileCssStatus\').html(\'<div class="alert alert-success">\' + data + \' - Success!</div>\');
                        },
                        error: function(data) {
                            console.log(\'error\');
                            $(\'#wCompileCssStatus\').html(\'<div class="alert alert-warning">\' + data + \' - Error!</div>\');
                        }
                    });
                });
            });
        ');

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
