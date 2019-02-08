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

                // Show instructions to compile
                $(\'.wCustomColor\').on(\'change\', function () {
                    try {
                        $(\'#wCompileCssBtn\').attr(\'disabled\', \'disabled\');
                        $(\'#wCompileCssStatus\').html(
                            \'<div class="wStatusInfo">' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS_INSTRUCTIONS') . '</div>\'
                        );
                    } catch(err) {
                          console.log(err.message);
                    }

                });

                // Run compiler
                $(\'#wCompileCssBtn\').on(\'click\', function (event) {
                    event.preventDefault();

                    $.ajax({
                        type: \'POST\',
                        data: {
                            tmpl: \'render\',
                            template: \''. $template . '\',
                            c: \'1\'
                        },
                        url: $(this).data(\'compiler\'),
                        success: function(data) {
                            $(\'#wCompileCssStatus\').html(data);
                        },
                        error: function(data) {
                            console.log(data);
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
            #wCompileCssStatus .wStatusInfo {
                color: #555;
            }
            #wCompileCssStatus .wStatusError {
                color: #8a6d3b;
            }
        ');

        $link       = '../';
        $html       = '<button class="btn btn-primary hasPopover"';
        $html      .= ' id="wCompileCssBtn"';
        $html      .= ' data-compiler="' . $link . '">';
        $html      .= ' <span class="icon-loop" aria-hidden="true"></span> ' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS');
        $html      .= ' </button>';
        $html      .= '<div id="wCompileCssStatus"></div><br><br>';

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
