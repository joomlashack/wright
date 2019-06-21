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

// @TODO after the end of Joomla 3 support:
// 1. Remove this file
// 2. Change the type from "wright.radio" to "radio" in templateDetails.xml
// 3. Remove the file wright/parameters/assets/radio/radio.css

JFormHelper::loadFieldClass('radio');

class WrightFormFieldRadio extends JFormFieldRadio {

    protected $type = 'Radio';

    /**
     * Method to override the data to be passed to the layout for rendering.
     *
     * @return  array
     *
     * @since   4.0.0
     */
    protected function getLayoutData()
    {
        $class  = null;

        if (version_compare(JVERSION, '4', 'lt')) {
            // Define the field class in Joomla 3
            $class  = 'btn-group btn-group-yesno';
        } else {
            // Load a CSS file to fix the switcher design in Joomla 4
            $doc = JFactory::getDocument();
            $doc->addStylesheet(
                str_replace(
                    '/administrator/', '/', JURI::base()
                ) . 'templates/' . $this->form->getValue('template') . '/wright/parameters/assets/radio/radio.css'
            );

        }

        $data       = parent::getLayoutData();
        $extraData  = array(
            'class' => $class
        );

        return array_merge($data, $extraData);
    }
}