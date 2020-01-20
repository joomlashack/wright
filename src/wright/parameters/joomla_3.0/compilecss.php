<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
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
        $template = $this->form->getValue('template');

        /**
         * Check if this template style is the one with lowest id
         * due is the only template style where we can compile the custom style
         */

        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);

        $query
            ->select($db->quoteName(array('id','title')))
            ->from($db->quoteName('#__template_styles'))
            ->where($db->quoteName('template') . ' LIKE '. $db->quote($template))
            ->order('id ASC')
            ->setLimit('1');

        $db->setQuery($query);

        // Record from database
        $lowestTemplateStyle    = $db->loadResult();

        // Taken from id parameter from the URL
        $currentTemplateStyle   = JFactory::getApplication()->input->get('id', null, 'integer');

        // Output CSS and Javascript
        $doc = JFactory::getDocument();
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

                // A message while the compiling process is happening
                $(\'#wCompileCssBtn\').bind(\'ajaxStart\', function(){
                    $(\'#wCompileCssStatus\').html(
                        \'<div class="wStatusInfo">' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS_COMPILING') . '</div>\'
                    );
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

        /**
         * Output the compile button if current template style
         * uses the lowest id from the template.
         *
         * If not, just output a message pointing to
         * the right template style.
         */

        $html           = '';

        if($lowestTemplateStyle == $currentTemplateStyle){
            $html      .= '<button class="btn btn-primary hasPopover"';
            $html      .= ' id="wCompileCssBtn"';
            $html      .= ' data-compiler="../">';
            $html      .= ' <span class="icon-loop" aria-hidden="true"></span>';
            $html      .= ' ' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS');
            $html      .= '</button>';
            $html      .= '<div id="wCompileCssStatus"></div>';
            $html      .= '<br><br>';
        }
        else
        {
            // Disable all custom colors parameters
            $doc->addScriptDeclaration('
                jQuery(document).ready(function($){
                    try {
                        $(\'.wCustomColor\').attr(\'disabled\', \'disabled\').trigger(\'liszt:updated\');
                        $(\'.wCustomColor\').css({\'opacity\': \'0.5\'});
                    } catch(err) {
                          console.log(err.message);
                    }
                });
            ');

            // Output a message
            $html      .= '<div class="wStatusInfo">';
            /*$html      .= JText::sprintf(
                            'TPL_JS_WRIGHT_COMPILE_LESS_MODIFY_CUSTOM_STYLE',
                            'index.php?option=com_templates&amp;task=style.edit&amp;id='. $lowestTemplateStyle
                          );*/
            $html      .= 'Modify and compile the Custom style from <strong><a href="index.php?option=com_templates&amp;task=style.edit&amp;id=' . $lowestTemplateStyle. '" target="_blank">this template style <span class="icon-out-2"></span></a></strong>';
            $html      .= '</div>';
            $html      .= '<br>';
        }

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
