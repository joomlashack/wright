<?php

abstract class HtmlAdapterAbstract
{
	protected $columns = array();
	protected $widths = array();
	protected $params;
	public $cols = '';

	protected $tags = array(	'doctype' =>	'/<doctype>/i',
								'html' =>		'/<html(.*)?>/i',
								'htmlComments' =>	'/<!--.*?-->/i',
								'body' => '/<body(.*)?>/i',
								'nav' => '/<nav(.*)>(.*)<\/nav>/isU',
								'sections' => '/<section(.*)>(.*)<\/section>/isU',
								'asides' => '/<aside(.*)>(.*)<\/aside>/isU',
								'footer' => '/<footer(.*)>(.*)<\/footer>/isU',
								'header' => '/<header(.*)>(.*)<\/header>/isU',
		);

	public function  __construct($params) {
		$this->params = $params;
		$this->setupColumns();
	}

	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * Functions below are in leu of an interface, each adapter will implement
	 * them in its own way if they don't like the default
	 */

	public function getDoctype($matches) {
		return '<!DOCTYPE html>';
	}

	public function getHtml($matches) {
		return '<html>';
	}

	public function getHtmlComments($matches)
	{
		return '';
	}

	public function getBody($matches)
	{
		$wright = Wright::getInstance();
		require_once(JPATH_ROOT.'/templates/'.$wright->document->template.'/wright/includes/browser.php');
		$browser = new Browser();
		$browser_version = explode('.', $browser->getVersion());
		$class = 'is_'.strtolower($browser->getBrowser()) . ' v_' . $browser_version[0];

		$style = "";

		if (isset($matches[1])) {
			if (strpos($matches[1], 'class=')) {
				preg_match('/class="([^"]*)"/i', $matches[1], $classes);
				if (isset($classes[1]))
					$class .= ' ' . $classes[1];
			}
			if (strpos($matches[1], 'style=')) {
				preg_match('/style="([^"]*)"/i', $matches[1], $styles);
				if (isset($styles[1]))
					$style = $styles[1];
			}
		}

		// if specific style add to class list
		//$class .= ' '.$wright->params->get('style');
		$xml = simplexml_load_file(JPATH_ROOT.'/templates/'.$wright->document->template.'/templateDetails.xml');
		$theme = $xml->xpath('//style[@name="'.$wright->params->get('style').'"]');
		if (count($theme)) $class .= ' '.$theme[0]['type'];

		// If user has custom typography selected, we need to add the classes to trigger it
		if ($this->params->get('body_font', 'default') !== 'default') {
			if ($this->params->get('body_font') == 'googlefonts') {
				if (strpos($this->params->get('body_googlefont'), ',')) {
					$gfont = substr($this->params->get('body_googlefont', 'Cuprum'), 0, strpos($this->params->get('body_googlefont', 'Cuprum'), ','));
				}
				else {
					$gfont = $this->params->get('body_googlefont', 'Cuprum');
				}
				$class .= ' b_' . strtolower(str_replace('+', '', $gfont));
			}
			else {
				$class .= ' b_' . $this->params->get('body_font', 'verdana');
			}
		}
		if ($this->params->get('header_font', 'default') !== 'default') {
			if ($this->params->get('header_font') == 'googlefonts') {
				if (strpos($this->params->get('header_googlefont'), ',')) {
					$gfont = substr($this->params->get('header_googlefont', 'Cuprum'), 0, strpos($this->params->get('header_googlefont', 'Cuprum'), ','));
				}
				else {
					$gfont = $this->params->get('header_googlefont', 'Cuprum');
				}
				
				$class .= ' h_' . strtolower(str_replace('+', '', $gfont));
			}
			else {
				$class .= ' h_' . $this->params->get('header_font', 'helvetica');
			}
		}
		if (JRequest::getVar('Itemid')) $class .= ' id_'.JRequest::getVar('Itemid');

		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		if ($menu->getActive() == $menu->getDefault()) $class .= ' home';

		$class .= " rev_" . $wright->revision;

		return '<body class="'.$class.'"' . ($style != '' ? ' style="' . $style . '"' : '') . '>';
	}

	public function getNav($matches)
	{
		return $matches[0];
	}

	public function getSections($matches)
	{
		$class = 'grid_'.$this->columns['main']->size;
		if ($this->columns['main']->push) $class .= ' push_'.$this->columns['main']->push;
		if ($this->columns['main']->pull) $class .= ' pull_'.$this->columns['main']->pull;
		if (strpos($matches[1], 'class=')) {
			preg_match('/class="(.*)"/i', $matches[1], $classes);
			$class .= ' ' . $classes[1];
		}

		$this->columns['main']->exists = true;  // marks that column really exists

		if (strpos($matches[1], 'class='))
			$main = preg_replace('/class=\".*\"/iU', 'class="'.$class.'"', $matches[0], 1);
		else
			$main = preg_replace('/<section/iU', '<section class="'.$class.'"', $matches[0], 1);

		return $main;
	}

	public function getAsides($matches)
	{
		// Get id and decide if to even bother
		preg_match('/id=\"(.*)\"/isU', $matches[1], $ids);
		$id = $ids[1];

		$doc = Wright::getInstance();
		if (!$doc->document->countModules($id)) {
			// addition for forcing a sidebar (if it is a template which must have a sidebar for some of its positions)
			$forcedSidebar = false;

			if (class_exists("WrightTemplate")) {
				if (property_exists("WrightTemplate", "forcedSidebar")) {
					$wrightTemplate = WrightTemplate::getInstance();
					if ($id == $wrightTemplate->forcedSidebar)
						$forcedSidebar = true;
				}
			}

			$editmode = false;
			
			// Check editing mode
			if (JRequest::getVar('task') == 'edit' || JRequest::getVar('layout') == 'form' || JRequest::getVar('layout') == 'edit') {
				$editmode = true;
			}
			
			if (!$forcedSidebar || $editmode)
				return;
		}
		
		$this->columns[$id]->exists = true;  // marks that column really exists

		$class = 'grid_'.$this->columns[$id]->size;
		if ($this->columns[$id]->push) $class .= ' push_'.$this->columns[$id]->push;
		if ($this->columns[$id]->pull) $class .= ' pull_'.$this->columns[$id]->pull;
		if (strpos($matches[1], 'class=')) {
			preg_match('/class="(.*)"/i', $matches[1], $classes);
			$class .= ' ' . $classes[1];
		}

		if (strpos($matches[1], 'class='))
			$sidebar = preg_replace('/class=\".*\"/iU', 'class="'.$class.'"', $matches[0], 1);
		else
			$sidebar = preg_replace('/<aside/iU', '<aside class="'.$class.'"', $matches[0], 1);

		return $sidebar;
	}

	public function getFooter($matches)
	{

		$class = 'footer';

		if (strpos($matches[1], 'class=')) {
			preg_match('/class="(.*)"/i', $matches[1], $classes);
			$class .= ' ' . $classes[1];
		}
		
		if (strpos($matches[1], 'class='))
			$footer = preg_replace('/class=\".*\"/iU', 'class="'.$class.'"', $matches[0], 1);

		return $footer;
	}

	public function getHeader($matches)
	{

		$class = 'header';

		if (strpos($matches[1], 'class=')) {
			preg_match('/class="(.*)"/i', $matches[1], $classes);
			$class .= ' ' . $classes[1];
		}

		if (strpos($matches[1], 'class='))
			$header = preg_replace('/class=\".*\"/iU', 'class="'.$class.'"', $matches[0], 1);

		return $header;
	}
	
	// Full Height Columns (sidebars)
	public function getFullHeightColumns($matches) {
		$before = 0;
		$after = 0;
		
		$i = 0;
		foreach ($this->columns as $col) {
			if ($col->exists) {  // only counts the column if really exists
				switch ($i) {
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
			$i++;
		}
		
		
		$content = $matches[1] .
			"<div id=\"columnscontainer\" class=\"container_12 main before_$before after_$after\">" .
		 	$matches[2] .
		 	"</div>" .
		 	$matches[3];
		return $content;
	}

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
		if (JRequest::getVar('task') == 'edit' || JRequest::getVar('layout') == 'form' || JRequest::getVar('layout') == 'edit') {
			$editmode = true;
		}

		if (class_exists("WrightTemplate") && !$editmode) {
			$wrightTemplate = WrightTemplate::getInstance();
			
			// checks if the template has full height sidebars for adding the tag for the columns (sidebars)
			if (property_exists("WrightTemplate", "fullHeightSidebars"))
				if ($wrightTemplate->fullHeightSidebars) {
					$this->tags['fullHeightColumns'] = '/(.*)<div class="container_12" id="columnscontainer">(.*)<\/div><div id="columnscontainer_close"><\/div>(.*)$/isU';
				}
		}
		
		foreach (explode(';', $doc->document->params->get('columns', 'sidebar1:3;main:6;sidebar2:3')) as $item)
		{
			list ($col, $val) = explode(':', $item);

			if ($col !== 'main' && $check == 0) $main++;
			else $check = 1;

            		$this->columns[$col] = new JObject();

			$this->columns[$col]->name = $col;
			$this->columns[$col]->size = $val;
			$this->columns[$col]->push = 0;
			$this->columns[$col]->pull = 0;
			$this->columns[$col]->check = $check;
			$this->columns[$col]->exists = false;  // contains if column really exists into content or not
			
			$number++;
			if ($doc->document->countModules($col) || $col == 'main')
					$layout[] = $col;
			else {
				// addition for forcing a sidebar (if it is a template which must have a sidebar for some of its positions)
				if ($wrightTemplate)
					if (property_exists("WrightTemplate", "forcedSidebar")) {
						$wrightTemplate = WrightTemplate::getInstance();
						if ($col == $wrightTemplate->forcedSidebar)
							$layout[] = $col;
					}
			}
		}
		
		// Auto set to full width if editing
		if (JRequest::getVar('task') == 'edit' || JRequest::getVar('layout') == 'form') {
			$layout = Array();
			$layout[] = 'main';
		}
		
		switch(implode('-', $layout))
		{
			case 'main':
				$this->columns['main']->size = 12;
				$this->cols = 'wide';
				break;

			case 'main-sidebar1':
				$this->columns['main']->size = (12-$this->columns['sidebar1']->size);
				$this->cols = 'm_'.$this->columns['main']->size.'_'.$this->columns['sidebar1']->size;
				break;

			case 'sidebar1-main':
				$this->columns['main']->size = (12-$this->columns['sidebar1']->size);
				$this->columns['sidebar1']->pull = $this->columns['main']->size;
				$this->columns['main']->push = $this->columns['sidebar1']->size;
				$this->cols = 'l_'.$this->columns['main']->size;
				break;

			case 'main-sidebar2':
				$this->columns['main']->size = (12-$this->columns['sidebar2']->size);
				$this->cols = 'm_'.$this->columns['main']->size.'_r_'.$this->columns['sidebar2']->size;
				break;

			case 'sidebar2-main':
				$this->columns['main']->size = (12-$this->columns['sidebar2']->size);
				$this->columns['sidebar2']->pull = $this->columns['main']->size;
				$this->columns['main']->push = $this->columns['sidebar2']->size;
				$this->cols = 'l_'.$this->columns['main']->size;
				break;
			case 'main-sidebar1-sidebar2':
				$this->cols = 'm_'.$this->columns['sidebar1']->size.'_'.$this->columns['sidebar2']->size;
				break;

			case 'main-sidebar2-sidebar1':
				$this->columns['sidebar2']->pull = $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->push = $this->columns['sidebar2']->size;
				$this->cols = 'm_'.$this->columns['sidebar2']->size.'_'.$this->columns['sidebar1']->size;
				break;

			case 'sidebar2-main-sidebar1':
				$this->columns['main']->push = $this->columns['sidebar2']->size;
				$this->columns['sidebar2']->pull = $this->columns['main']->size + $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->push = $this->columns['sidebar2']->size;
				$this->cols = $this->columns['sidebar2']->size.'_m_'.$this->columns['sidebar1']->size;
				break;

			case 'sidebar1-main-sidebar2':
				$this->columns['main']->push = $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->pull = $this->columns['main']->size;
				$this->cols = $this->columns['sidebar1']->size.'_m_'.$this->columns['sidebar2']->size;
				break;

			case 'sidebar1-sidebar2-main':
				$this->columns['main']->push = $this->columns['sidebar1']->size + $this->columns['sidebar2']->size;
				$this->columns['sidebar2']->pull = $this->columns['main']->size;
				$this->columns['sidebar1']->pull = $this->columns['main']->size;
				$this->cols = $this->columns['sidebar1']->size.'_'.$this->columns['sidebar2']->size.'_m';
				break;

			case 'sidebar2-sidebar1-main':
				$this->columns['main']->push = $this->columns['sidebar1']->size + $this->columns['sidebar2']->size;
				$this->columns['sidebar2']->pull = $this->columns['main']->size +  $this->columns['sidebar1']->size;
				$this->columns['sidebar1']->pull = $this->columns['main']->size - $this->columns['sidebar2']->size;
				$this->cols = 'l_'.$this->columns['sidebar2']->size.'_r_'.$this->columns['sidebar1']->size.'_m_'.$this->columns['main']->size;
				break;
		}
	}

}
