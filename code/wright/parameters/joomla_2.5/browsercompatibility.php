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
			'BROWSER_CHROME' => Browser::BROWSER_CHROME,
			'BROWSER_FIREFOX' => Browser::BROWSER_FIREFOX,
			'BROWSER_IE' => Browser::BROWSER_IE,
			'BROWSER_SAFARI' => Browser::BROWSER_SAFARI,
			'BROWSER_IPHONE' => Browser::BROWSER_IPHONE,
			'BROWSER_IPOD' => Browser::BROWSER_IPOD,
			'BROWSER_IPAD' => Browser::BROWSER_IPAD,
			'BROWSER_OPERA' => Browser::BROWSER_OPERA,
			'BROWSER_OPERA_MINI' => Browser::BROWSER_OPERA_MINI,
			'BROWSER_POCKET_IE' => Browser::BROWSER_POCKET_IE,
			'BROWSER_KONQUEROR' => Browser::BROWSER_KONQUEROR,
			'BROWSER_ICAB' => Browser::BROWSER_ICAB,
			'BROWSER_OMNIWEB' => Browser::BROWSER_OMNIWEB,
			'BROWSER_FIREBIRD' => Browser::BROWSER_FIREBIRD,
			'BROWSER_ANDROID' => Browser::BROWSER_ANDROID,
			'BROWSER_BLACKBERRY' => Browser::BROWSER_BLACKBERRY,
		);
	}

	/**
	 * Creates the browser compatibility table
	 *
	 * @return  JFormField  Formatted input
	 */
	protected function getInput()
	{
		$doc = JFactory::getDocument();

		if (version_compare(JVERSION, '3', 'ge'))
		{
			JHtml::_('jquery.framework');
		}
		else
		{
			$doc->addScript(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $this->form->getValue('template') . '/wright/js/jquery.min.js');
			$doc->addScriptDeclaration('jQuery.noConflict();');
		}

		$doc->addScript(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $this->form->getValue('template') . '/wright/parameters/assets/browsercompatibility/browsercompatibility.js');
		$doc->addStylesheet(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $this->form->getValue('template') . '/wright/parameters/assets/browsercompatibility/browsercompatibility.css');

		$this->initializeBrowsers();
		$html = '';

		if ($this->value == '')
		{
			include_once dirname(__FILE__) . '../../../wright.php';
			$wright = Wright::getInstance();
			$this->value = json_encode($wright->setupDefaultBrowserCompatibility());
		}

		$browserCompatibility = json_decode($this->value);

		$html .= '<table class="wright-browser-table"><tr><th>' . JText::_('TPL_JS_WRIGHT_BROWSER_COMPATIBILITY_BROWSER') . '</th><th>' . JText::_('TPL_JS_WRIGHT_BROWSER_COMPATIBILITY_MINIMUM_VERSION') . '</th><th>' . JText::_('TPL_JS_WRIGHT_BROWSER_COMPATIBILITY_DESKTOP') . '</th><th>' . JText::_('TPL_JS_WRIGHT_BROWSER_COMPATIBILITY_RECOMMENDED') . '</th><th>' . JText::_('TPL_JS_WRIGHT_BROWSER_COMPATIBILITY_MOBILE') . '</th></tr>';

		foreach ($this->_browserCollection as $browserId => $browserName)
		{
			$html .= '<tr>'
				. '<td class="text-left">' . $browserName . '</td>'
				. '<td><input type="text" class="wbminv" name="wbminv_' . $browserId . '" id="wbminv_' . $browserId . '" value="' . (isset($browserCompatibility->$browserName) ? $browserCompatibility->$browserName->minimumVersion : '') . '" data-browser="' . $browserName . '" data-browserid="' . $browserId . '" /></td>'
				. '<td><input type="checkbox" class="wbdesktop" name="wbdesktop_' . $browserId . '" id="wbdesktop_' . $browserId . '"' . (isset($browserCompatibility->$browserName) ? ($browserCompatibility->$browserName->desktop ? 'checked="checked"' : '') : '') . ' data-browser="' . $browserName . '" data-browserid="' . $browserId . '" /></td>'
				. '<td><input type="checkbox" class="wbrecommended" name="wbrecommended_' . $browserId . '" id="wbrecommended_' . $browserId . '"' . (isset($browserCompatibility->$browserName) ? ($browserCompatibility->$browserName->recommended ? 'checked="checked"' : '') : '') . ' data-browser="' . $browserName . '" data-browserid="' . $browserId . '" /></td>'
				. '<td><input type="checkbox" class="wbmobile" name="wbmobile_' . $browserId . '" id="wbmobile_' . $browserId . '"' . (isset($browserCompatibility->$browserName) ? ($browserCompatibility->$browserName->mobile ? 'checked="checked"' : '') : '') . ' data-browser="' . $browserName . '" data-browserid="' . $browserId . '" /></td>'
				. '</tr>';
		}

		$html .= "</table>";
		$html .= '<input type="hidden" name="' . $this->name . '" id="wb_compatibility" value=\'' . $this->value . '\' /> ';

		return $html;
	}
}
