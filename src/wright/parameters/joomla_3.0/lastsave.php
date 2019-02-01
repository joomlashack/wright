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

jimport('joomla.form.formfield');

/**
 * Wright button to store the last time template settings were saved
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       3.9.1
 */
class JFormFieldLastsave extends JFormField
{
	protected $type = 'Lastsave';

	/**
	 * Creates the Compilecss button field
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
        // Get live date in format: 2019-01-17 19:57:29
        $document = JFactory::getDocument();
        $document->addScriptDeclaration('
        // Refresh time every 1 second
        function wRefreshTime() {
            var refresh  = 1000;
            newTime      = setTimeout(\'wCurrentTime()\', refresh)
        }

        // Get current time
        function wCurrentTime() {
            var x  = new Date();
            var x1 = x.getFullYear() + \'-\' + x.getMonth() + 1+ \'-\' + x.getDate();
                x1 = x1 + \' \' + x.getHours( ) + \':\' +  x.getMinutes() + \':\' + x.getSeconds();
            document.getElementById(\'lastSave\').value=x1;
            wRefreshTime();
        }

        document.addEventListener(\'DOMContentLoaded\', function(event) {
            wCurrentTime();
        });
        ');

        $date       = new JDate('now');
        $timezone   = new DateTimeZone( JFactory::getUser()->getParam('timezone') );
        $date->setTimezone($timezone);

        $html = '<input type="hidden" name="' . $this->name . '" id="lastSave" value="' . $date . '">';

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
