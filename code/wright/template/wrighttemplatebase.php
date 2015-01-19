<?php
/**
 * @package     Wright
 * @subpackage  TemplateBase
 *
 * @copyright   Copyright (C) 2005 - 2015 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('You are not allowed to directly access this file');

/**
 * WrightTemplateBase class, for special settings on Wright.  Overridable for every different template
 *
 * @package     Wright
 * @subpackage  TemplateBase
 * @since       3.0
 */
class WrightTemplateBase
{
	// Local variable to know if there is a logo for the site
	private $_isThereALogo = null;

	// Sets Template Name
	public $templateName = null;

	// Checks if template allows stacked suffixes
	public $suffixes = false;

	// Checks if this template uses full height sidebars
	public $fullHeightSidebars = false;

	// Special stacked suffixes classes
	public $specialClasses = Array();

	// Optional forced sidebar position, starts with nothing to be decided by fixed position (parameter) or auto setting
	public $forcedSidebar = "";

	// Positions that cause the forced sidebar, must be set here
	public $forcedSidebarPositions = Array();

	// If using forced sidebar has to be set with the local JDocumentHTML ($this from inside the template itself)
	public $JDocumentHTML = null;

	// Use Bootstrap's span classes for main content and sidebars
	public $useMainSpans = true;

	// Menu positions in the template - using the <w:nav> adapter
	public $menuPositions = Array('toolbar', 'menu', 'bottom-menu');

	// Documentation link (for the help section in the template backend configuration)
	public $documentationLink = null;

	/**
	 * Function to get an instance of this class
	 *
	 * @return  void
	 */
	public static function getInstance()
	{
		static $instance = null;

		if ($instance === null)
		{
			// Prefers to use the inherited WrightTemplate class for customized settings on the template itself
			if (class_exists("WrightTemplate"))
			{
				$instance = new WrightTemplate;
			}
			else
			{
				$instance = new WrightTemplateBase;
			}
		}

		return $instance;
	}

	/**
	 * Function to determine if sidebar has to be forced (sets the forcedSidebar property)
	 *
	 * @param   boolean  $forcedSidebar  Refers to the value of the parameter read, to know what's the sidebar to be forced, or empty for automatic config
	 *
	 * @return  void
	 */
	function defineForcedSidebar($forcedSidebar)
	{
		$isSidebarForced = false;

		// Checks if any of the positions has modules on it
		foreach ($this->forcedSidebarPositions as $pos)
		{
			if ($pos == 'logo')
			{
				$isSidebarForced = $this->isThereALogo();
			}
			else
			{
				if ($this->JDocumentHTML->countModules($pos))
				{
					$isSidebarForced = true;
				}
			}
		}

		// Checks, depending on the logoPosition parameter, which is the sidebar to be forced
		if ($isSidebarForced)
		{
			// If sidebar1 is defined by config, or if config is auto and there's modules on sidebar1 already, or if config is auto and there are no modules on any sidebar
			if ($forcedSidebar == 'sidebar1'
				|| ($forcedSidebar == '' && $this->JDocumentHTML->countModules('sidebar1')
				|| ($forcedSidebar == '' && !$this->JDocumentHTML->countModules('sidebar1') && !$this->JDocumentHTML->countModules('sidebar2'))))
			{
				$this->forcedSidebar = 'sidebar1';
			}

			// If sidebar2 is defined by config, or if there are modules on sidebar2 and not on sidebar1
			if ($forcedSidebar == 'sidebar2'
				|| ($forcedSidebar == '' && !$this->JDocumentHTML->countModules('sidebar1') && $this->JDocumentHTML->countModules('sidebar2')))
			{
				$this->forcedSidebar = 'sidebar2';
			}
		}
	}

	/**
	 * Check if there is a logo (based on Wright's logo.php file or on the local variable if set)
	 *
	 * @return  boolean
	 */
	function isThereALogo()
	{
		if (!is_null($this->_isThereALogo))
		{
			return $this->_isThereALogo;
		}

		require_once dirname(__FILE__) . '/../adapters/joomla/logo.php';

		$this->_isThereALogo = WrightAdapterJoomlaLogo::isThereALogo();

		return $this->_isThereALogo;
	}

	/**
	 * Gets the template object
	 *
	 * @return  Template object
	 */
	public function getTemplate()
	{
		static $template;

		if ($this->templateName == '')
			return false;

		if (!isset($template))
		{
			// Load the template name from the database
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('template, s.params');
			$query->from('#__template_styles as s');
			$query->leftJoin('#__extensions as e ON e.type=' . $db->quote('template') . ' AND e.element=s.template AND e.client_id=s.client_id');
			$query->where('e.name = ' . $db->quote($this->templateName), 'AND');
			$query->order('home');
			$db->setQuery($query);

			$template = $db->loadObject();

			$template->template = JFilterInput::getInstance()->clean($template->template, 'cmd');
			$template->params = new JRegistry($template->params);

			if (!file_exists(JPATH_THEMES . '/' . $template->template . '/index.php'))
			{
				$template->params = new JRegistry;
				$template->template = '';
			}
		}

		return $template;
	}
}
