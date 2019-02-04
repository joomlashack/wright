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
        $doc->addScriptDeclaration('
            jQuery(function ($) {
                $(\'#wCompileCssBtn\').on(\'click\', function (event) {
                    event.preventDefault();

                    // Save template style
                    //Joomla.submitbutton(\'style.apply\');

                    // Call LESS compilation page
                    $.ajax(this.href, {
                        success: function(data) {
                            $(\'#wCompileCssStatus\').html(
                                \'<div class="wStatusSuccess">' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS_SUCCESS') . '</div>\'
                            );
                        },
                        error: function(data) {
                            $(\'#wCompileCssStatus\').html(
                                \'<div class="wStatusError">' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS_ERROR') . '</div>\'
                            );
                        }
                    });
                });
            });
        ');
        $doc->addStyleDeclaration('
            #wCompileCssStatus {
                display: inline-block;
                margin-left: 10px;
            }
            #wCompileCssStatus > div {
                display: inline-block;
            }
            #wCompileCssStatus .wStatusSuccess {
                color: #3c763d;
            }
            #wCompileCssStatus .wStatusError {
                color: #8a6d3b;
            }
        ');

        $link = str_replace('/administrator/', '/', JURI::base()) . '?tmpl=render&c=1';

        $html  = JHtml::_(
                    'link',
                    $link,
                    '<span class="icon-loop" aria-hidden="true"></span> ' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS'),
                    'class="btn btn-primary" id="wCompileCssBtn"'
                );
        $html .= '<div id="wCompileCssStatus"></div><br><br>';

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
