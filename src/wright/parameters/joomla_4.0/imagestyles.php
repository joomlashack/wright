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
// 2. Change the type from "imagestyles" to "list" in templateDetails.xml
// 3. Include the <options> for "wright_bootstrap_images" field in templateDetails.xml

JFormHelper::loadFieldClass('list');

class JFormFieldImageStyles extends JFormFieldList {

    protected $type = 'ImageStyles';

    /**
     * Method to populate the image styles select field
     *
     * @return  array
     *
     * @since   4.0.0
     */
    protected function getOptions()
    {
        if (version_compare(JVERSION, '4', 'lt')) {
            // Joomla 3 options
            $images = array(
                'img-rounded'   => JText::_('TPL_JS_WRIGHT_BOOTSTRAP_IMAGES_ROUNDED'),
                'img-circle'    => JText::_('TPL_JS_WRIGHT_BOOTSTRAP_IMAGES_CIRCLE'),
                'img-polaroid'  => JText::_('TPL_JS_WRIGHT_BOOTSTRAP_IMAGES_POLAROID')
            );
        } else {
            // Joomla 4 options
            $images = array(
                'img-thumbnail' => JText::_('TPL_JS_WRIGHT_BOOTSTRAP_IMAGES_THUMBNAIL'),
                'rounded'       => JText::_('TPL_JS_WRIGHT_BOOTSTRAP_IMAGES_ROUNDED')
            );
        }

        $options = array_merge(parent::getOptions(), $images);

        return $options;
    }
}