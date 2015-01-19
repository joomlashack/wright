<?php
/**
 * @package     Wright
 * @subpackage  Adapters
 *
 * @copyright   Copyright (C) 2005 - 2015 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * HTML default doctype
 *
 * @package     Wright
 * @subpackage  Main Package
 * @since       2.0
 */
abstract class HtmlAdapterAbstract
{
	protected $columns = array();

	protected $widths = array();

	protected $params;

	public $cols = '';

	protected $tags = array(	'doctype' => '/<doctype>/i',
								'html' => '/<html(.*)?>/i',
								'htmlComments' => '/<!--.*?-->/i',
								'body' => '/<body(.*)?>/i',
								'nav' => '/<nav(.*)>(.*)<\/nav>/isU',
								'sections' => '/<section(.*)>(.*)<\/section>/isU',
								'asides' => '/<aside(.*)>(.*)<\/aside>/isU',
								'footer' => '/<footer(.*)>(.*)<\/footer>/isU',
								'header' => '/<header(.*)>(.*)<\/header>/isU',
								'toolbar' => '/<div(.*)id="toolbar">(.*)<\/div>/isU',
								'bodyclose' => '/<\/body>/i'
		);

	/**
	 * Constructor
	 *
	 * @param   array  $params  Parameters
	 */
	public function  __construct($params)
	{
		$this->params = $params;
		$this->setupColumns();
	}

	/**
	 * Gets all the tags
	 *
	 * @return  array
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 *  Gets and modifies the doctype
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getDoctype($matches)
	{
		return '<!DOCTYPE html>';
	}

	/**
	 *  Gets and modifies the HTML main tag
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getHtml($matches)
	{
		$lang = JFactory::getLanguage();
		$tag = $lang->getTag();
		$dir = ($lang->isRTL() ? "rtl" : "ltr");

		return '<html lang="' . $tag . '" dir="' . $dir . '">';
	}

	/**
	 *  Gets and modifies the HTML comments
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getHtmlComments($matches)
	{
		return '';
	}

	/**
	 *  Gets and modifies the body tag
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getBody($matches)
	{
		$wright = Wright::getInstance();
		$browser = new Browser;
		$browser_version = explode('.', $browser->getVersion());
		$class = 'is_' . strtolower($browser->getBrowser()) . ' v_' . $browser_version[0];

		$style = "";

		// Added for other data-(0-9) classes
		$data = "";

		if (isset($matches[1]))
		{
			if (strpos($matches[1], 'class='))
			{
				preg_match('/class="([^"]*)"/i', $matches[1], $classes);
				if (isset($classes[1]))
					$class .= ' ' . $classes[1];
			}

			if (strpos($matches[1], 'style='))
			{
				preg_match('/style="([^"]*)"/i', $matches[1], $styles);
				if (isset($styles[1]))
					$style = $styles[1];
			}

			preg_match_all('/data-([0-9]+)="([^"]*)"/', $matches[1], $dataclasses, PREG_SET_ORDER);

			if ($dataclasses)
			{
				foreach ($dataclasses as $dc)
				{
					$data .= ' data-' . $dc[1] . '="' . $dc[2] . '"';
				}
			}
		}
		else
		{
		}

		// If specific style add to class list
		$xml = simplexml_load_file(JPATH_ROOT . '/templates/' . $wright->document->template . '/templateDetails.xml');
		$theme = $xml->xpath('//style[@name="' . $wright->params->get('style') . '"]');

		if (count($theme))
		{
			$class .= ' ' . $theme[0]['type'];
		}
		else
		{
		}

		// If user has custom typography selected, we need to add the classes to trigger it
		if ($this->params->get('body_font', 'default') !== 'default')
		{
			if ($this->params->get('body_font') == 'googlefonts')
			{
				if (strpos($this->params->get('body_googlefont'), ','))
				{
					$gfont = substr($this->params->get('body_googlefont', 'Cuprum'), 0, strpos($this->params->get('body_googlefont', 'Cuprum'), ','));
				}
				else
				{
					$gfont = $this->params->get('body_googlefont', 'Cuprum');
				}

				$class .= ' b_' . strtolower(str_replace('+', '', $gfont));
			}
			else
			{
				$class .= ' b_' . $this->params->get('body_font', 'verdana');
			}
		}
		else
		{
		}

		if ($this->params->get('header_font', 'default') !== 'default')
		{
			if ($this->params->get('header_font') == 'googlefonts')
			{
				if (strpos($this->params->get('header_googlefont'), ','))
				{
					$gfont = substr($this->params->get('header_googlefont', 'Cuprum'), 0, strpos($this->params->get('header_googlefont', 'Cuprum'), ','));
				}
				else
				{
					$gfont = $this->params->get('header_googlefont', 'Cuprum');
				}

				$class .= ' h_' . strtolower(str_replace('+', '', $gfont));
			}
			else
			{
				$class .= ' h_' . $this->params->get('header_font', 'helvetica');
			}
		}

		if (JRequest::getVar('Itemid'))
		{
			$class .= ' id_' . JRequest::getVar('Itemid');
		}

		$app = JFactory::getApplication();
		$menu = $app->getMenu();

		if ($menu->getActive() == $menu->getDefault())
		{
			$class .= ' home';
		}

		$class .= " rev_" . $wright->revision;

		return '<body class="' . $class . '"' . ($style != '' ? ' style="' . $style . '"' : '') . $data . '>';
	}

	/**
	 *  Gets and modifies the body close tag
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getBodyclose($matches)
	{
		$doc = Wright::getInstance();
		$js = $doc->generateJS();
		$browserWarning = '';

		if ($doc->_showBrowserWarning)
		{
			ob_start();
			include JPATH_SITE . '/templates/' . $doc->document->template . '/wright/includes/browserwarning.php';
			$browserWarning = ob_get_clean();
		}

		return $browserWarning . $js . '</body>';
	}

	/**
	 *  Gets and modifies the nav tag
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getNav($matches)
	{
		return $matches[0];
	}

	/**
	 *  Gets and modifies the section tags
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getSections($matches)
	{
		$useMainSpans = true;

		if (class_exists("WrightTemplate"))
		{
			if (property_exists("WrightTemplate", "useMainSpans"))
			{
				$wrightTemplate = WrightTemplate::getInstance();

				if (!$wrightTemplate->useMainSpans)
				{
					$useMainSpans = false;
				}
			}
		}

		$class = "";

		// Use main Spans only if allowed by template internal configuration
		if ($useMainSpans)
		{
			$class .= 'span' . $this->columns['main']->size;
		}

		if (preg_match('/class="(.*)"/u', $matches[1], $classes))
		{
			$class .= ' ' . $classes[1];
		}

		// Marks that column really exists
		$this->columns['main']->exists = true;

		if (strpos($matches[1], 'class='))
		{
			$main = preg_replace('/class=\".*\"/iU', 'class="' . $class . '"', $matches[0], 1);
		}
		else
		{
			$main = preg_replace('/<section/iU', '<section class="' . $class . '"', $matches[0], 1);
		}

		return $main;
	}

	/**
	 *  Gets and modifies the aside tags
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getAsides($matches)
	{
		// Get id and decide if to even bother
		preg_match('/id=\"(.*)\"/isU', $matches[1], $ids);
		$id = $ids[1];

		$doc = Wright::getInstance();

		if (!$doc->document->countModules($id))
		{
			// Addition for forcing a sidebar (if it is a template which must have a sidebar for some of its positions)
			$forcedSidebar = false;

			if (class_exists("WrightTemplate"))
			{
				if (property_exists("WrightTemplate", "forcedSidebar"))
				{
					$wrightTemplate = WrightTemplate::getInstance();
					if ($id == $wrightTemplate->forcedSidebar)
						$forcedSidebar = true;
				}
			}

			$editmode = false;

			// Check editing mode
			if (JRequest::getVar('task') == 'edit' || JRequest::getVar('layout') == 'form' || JRequest::getVar('layout') == 'edit')
			{
				$editmode = true;
			}

			if (!$forcedSidebar || $editmode)
			{
				return;
			}
		}

		// Marks that column really exists
		$this->columns[$id]->exists = true;

		$useMainSpans = true;

		if (class_exists("WrightTemplate"))
		{
			if (property_exists("WrightTemplate", "useMainSpans"))
			{
				$wrightTemplate = WrightTemplate::getInstance();
				if (!$wrightTemplate->useMainSpans)
					$useMainSpans = false;
			}
		}

		$class = "";

		// Use main Spans only if allowed by template internal configuration
		if ($useMainSpans)
		{
			$class = 'span' . $this->columns[$id]->size;
		}

		if (preg_match('/class="(.*)"/u', $matches[1], $classes))
		{
			$class .= ' ' . $classes[1];
		}

		if (strpos($matches[1], 'class='))
		{
			$sidebar = preg_replace('/class=\".*\"/iU', 'class="' . $class . '"', $matches[0], 1);
		}
		else
		{
			$sidebar = preg_replace('/<aside/iU', '<aside class="' . $class . '"', $matches[0], 1);
		}

		// Only return sidebar if user has set columns > 0
		if ($this->columns[$id]->size > 0)
		{
			return $sidebar;
		}
	}

	/**
	 *  Gets and modifies the footer tag
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getFooter($matches)
	{
		$class = 'footer';
		$footer = $matches[0];

		// Footer attributes contain classes?
		if (strpos($matches[1], 'class='))
		{
			// Get aditional classes
			preg_match('/class="(.*)"/i', $matches[1], $classes);
			$class .= ' ' . $classes[1];

			$footer = preg_replace('/class=\".*\"/iU', 'class="' . $class . '"', $matches[0], 1);
		}
		// Doesn't contain classes. Insert it
		else
		{
			$footer = preg_replace('/<footer/iU', '<footer class="' . $class . '"', $matches[0], 1);
		}

		return $footer;
	}

	/**
	 *  Gets and modifies the header tag
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getHeader($matches)
	{
		$class = 'header';
		$header = $matches[0];

		if (strpos($matches[1], 'class='))
		{
			preg_match('/class="(.*)"/i', $matches[1], $classes);
			$class .= ' ' . $classes[1];
		}
		else
		{
		}

		if (strpos($matches[1], 'class='))
		{
			$header = preg_replace('/class=\".*\"/iU', 'class="' . $class . '"', $matches[0], 1);
		}
		else
		{
		}

		return $header;
	}

	/**
	 *  Process full Height Columns (Wright v.2)
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	public function getFullHeightColumns($matches)
	{
		$before = 0;
		$after = 0;

		$i = 0;

		foreach ($this->columns as $col)
		{
			// Only counts the column if really exists
			if ($col->exists)
			{
				switch ($i)
				{
					case 0:
						if ($col->name == "sidebar1" || $col->name == "sidebar2")
							$before += $col->size;
						break;
					case 1:
						if ($before > 0 && ($col->name == "sidebar1" || $col->name == "sidebar2"))
							$before += $col->size;
						elseif ($col->name == "sidebar1" || $col->name == "sidebar2") {
							$after += $col->size;
						}
						break;
					case 2:
						if ($col->name == "sidebar1" || $col->name == "sidebar2")
							$after += $col->size;
						break;
				}
			}
			else
			{
			}

			$i++;
		}

		$content = $matches[1] .
			"<div id=\"columnscontainer\" class=\"container_12 main before_$before after_$after\">" .
			$matches[2] .
			"</div>" .
			$matches[3];

		return $content;
	}

	/**
	 *  Gets and modifies the toolbar tag
	 *
	 * @param   array  $matches  Matches of the regular expression in $tags
	 *
	 * @return  string
	 */
	function getToolbar($matches)
	{
		$toolbar = $matches[0];

		return $toolbar;
	}

	/**
	 *  Sets up the main columns (main and sidebars)
	 *
	 * @return  string
	 */
	private function setupColumns()
	{
		$doc = Wright::getInstance();

		// Get our column info straight
		$main = 0;
		$check = 0;
		$number = 0;
		$layout = array();

		$wrightTemplate = null;
		$editmode = false;

		// Check editing mode
		if (JRequest::getVar('task') == 'edit'
			|| JRequest::getVar('layout') == 'form'
			|| JRequest::getVar('layout') == 'edit')
		{
			$editmode = true;
		}
		else
		{
		}

		if (class_exists("WrightTemplate") && !$editmode)
		{
			$wrightTemplate = WrightTemplate::getInstance();

			// Checks if the template has full height sidebars for adding the tag for the columns (sidebars)
			if (property_exists("WrightTemplate", "fullHeightSidebars"))
			{
				if ($wrightTemplate->fullHeightSidebars)
				{
					$this->tags['fullHeightColumns'] = '/(.*)<div class="container_12" id="columnscontainer">(.*)<\/div><div id="columnscontainer_close"><\/div>(.*)$/isU';
				}
			}
		}
		else
		{
		}

		foreach (explode(';', $doc->document->params->get('columns', 'sidebar1:3;main:6;sidebar2:3')) as $item)
		{
			list ($col, $val) = explode(':', $item);

			if ($col !== 'main' && $check == 0)
			{
				$main++;
			}
			else
			{
				$check = 1;
			}

			$this->columns[$col] = new JObject;

			$this->columns[$col]->name = $col;
			$this->columns[$col]->size = $val;
			$this->columns[$col]->push = 0;
			$this->columns[$col]->pull = 0;
			$this->columns[$col]->check = $check;

			// Contains if column really exists into content or not
			$this->columns[$col]->exists = false;

			$number++;

			if ($val > 0 && $doc->document->countModules($col) || $col == 'main')
			{
					$layout[] = $col;
			}
			else
			{
				// Addition for forcing a sidebar (if it is a template which must have a sidebar for some of its positions)
				if ($wrightTemplate)
				{
					if (property_exists("WrightTemplate", "forcedSidebar"))
					{
						$wrightTemplate = WrightTemplate::getInstance();
						if ($col == $wrightTemplate->forcedSidebar)
							$layout[] = $col;
					}
				}
			}
		}

		// Auto set to full width if editing
		if (JRequest::getVar('task') == 'edit' || JRequest::getVar('layout') == 'form')
		{
			$layout = Array();
			$layout[] = 'main';
		}

		switch (implode('-', $layout))
		{
			case 'main':
				$this->columns['main']->size = 12;
				$this->cols = 'wide';
				break;

			case 'main-sidebar1':
				$this->columns['main']->size = (12 - $this->columns['sidebar1']->size);
				$this->cols = 'm_' . $this->columns['main']->size . '_' . $this->columns['sidebar1']->size;
				break;

			case 'sidebar1-main':
				$this->columns['main']->size = (12 - $this->columns['sidebar1']->size);
				$this->columns['sidebar1']->pull = $this->columns['main']->size;
				$this->columns['main']->push = $this->columns['sidebar1']->size;
				$this->cols = 'l_' . $this->columns['main']->size;
				break;

			case 'main-sidebar2':
				$this->columns['main']->size = (12 - $this->columns['sidebar2']->size);
				$this->cols = 'm_' . $this->columns['main']->size . '_r_' . $this->columns['sidebar2']->size;
				break;

			case 'sidebar2-main':
				$this->columns['main']->size = (12 - $this->columns['sidebar2']->size);
				$this->columns['sidebar2']->pull = $this->columns['main']->size;
				$this->columns['main']->push = $this->columns['sidebar2']->size;
				$this->cols = 'l_' . $this->columns['main']->size;
				break;
			case 'main-sidebar1-sidebar2':
				$this->cols = 'm_' . $this->columns['sidebar1']->size . '_' . $this->columns['sidebar2']->size;
				break;

			case 'main-sidebar2-sidebar1':
				$this->columns['sidebar2']->pull = $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->push = $this->columns['sidebar2']->size;
				$this->cols = 'm_' . $this->columns['sidebar2']->size . '_' . $this->columns['sidebar1']->size;
				break;

			case 'sidebar2-main-sidebar1':
				$this->columns['main']->push = $this->columns['sidebar2']->size;
				$this->columns['sidebar2']->pull = $this->columns['main']->size + $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->push = $this->columns['sidebar2']->size;
				$this->cols = $this->columns['sidebar2']->size . '_m_' . $this->columns['sidebar1']->size;
				break;

			case 'sidebar1-main-sidebar2':
				$this->columns['main']->push = $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->pull = $this->columns['main']->size;
				$this->cols = $this->columns['sidebar1']->size . '_m_' . $this->columns['sidebar2']->size;
				break;

			case 'sidebar1-sidebar2-main':
				$this->columns['main']->push = $this->columns['sidebar1']->size + $this->columns['sidebar2']->size;
				$this->columns['sidebar2']->pull = $this->columns['main']->size;
				$this->columns['sidebar1']->pull = $this->columns['main']->size;
				$this->cols = $this->columns['sidebar1']->size . '_' . $this->columns['sidebar2']->size . '_m';
				break;

			case 'sidebar2-sidebar1-main':
				$this->columns['main']->push = $this->columns['sidebar1']->size + $this->columns['sidebar2']->size;
				$this->columns['sidebar2']->pull = $this->columns['main']->size + $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->pull = $this->columns['main']->size - $this->columns['sidebar2']->size;
				$this->cols = 'l_' . $this->columns['sidebar2']->size . '_r_' . $this->columns['sidebar1']->size . '_m_' . $this->columns['main']->size;
				break;
		}
	}
}
