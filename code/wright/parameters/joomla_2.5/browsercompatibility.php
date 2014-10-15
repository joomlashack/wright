<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2014 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

include_once dirname(__FILE__) . '../../../includes/browser.php';

/**
 * Browser compatibility table
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       3.0
 */
class JFormFieldBrowserCompatibility extends JFormField
{
	protected $type = 'BrowserCompatibility';

	private $_browserCollection;

	/**
	 * Initializes the browser collection using Chris Schuld's Browser.php library
	 *
	 * @return  void
	 */
	private function initializeBrowsers()
	{
		$this->_browserCollection = array(
			Browser::BROWSER_OPERA,
			Browser::BROWSER_OPERA_MINI,
			Browser::BROWSER_IE,
			Browser::BROWSER_POCKET_IE,
			Browser::BROWSER_KONQUEROR,
			Browser::BROWSER_ICAB,
			Browser::BROWSER_OMNIWEB,
			Browser::BROWSER_FIREBIRD,
			Browser::BROWSER_FIREFOX,
			Browser::BROWSER_SAFARI,
			Browser::BROWSER_IPHONE,
			Browser::BROWSER_IPOD,
			Browser::BROWSER_IPAD,
			Browser::BROWSER_CHROME,
			Browser::BROWSER_ANDROID,
			Browser::BROWSER_BLACKBERRY,
		);
	}

	/**
	 * Creates the browser compatibility table
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
		if ($this->value == '')
		{
			include_once dirname(__FILE__) . '../../../wright.php';
			$wright = Wright::getInstance();
			$this->value = json_encode($wright->setupDefaultBrowserCompatibility());
		}

		$html = '';
		$html .= '<input type="text" name="' . $this->name . '" id="' . $this->name . '" value=\'' . $this->value . '\' /> ';

		return $html;
	}
}
