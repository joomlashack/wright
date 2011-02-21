<?php
// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

if(JRequest::getVar('task') == 'edit' || JRequest::getVar('layout') == 'form'){
	$styles .= '#main{width:100%; background:none;} #content{width:100%;} #sidebar1{display:none;} #sidebar2{display:none;}'.PHP_EOL;
	$this->document->addStyleDeclaration($styles);
}
 


class BuildHeader {
	// getHeader() displays logo as text/tagline or SEO optimized graphic
  function getHeader() {
			$headertype				= $this->document->params->get( 'headertype', 'image' );
			$headline					= $this->document->params->get( 'headline', 'Onyx Template' );
			$tagline					= $this->document->params->get( 'tagline', 'for Joomla' );
			$item_spacing			= $this->document->params->get( 'item_spacing', '18' );
			$header_width			= $this->document->params->get( 'header_width', '244' );
			$header_height		= $this->document->params->get( 'header_height', '73' );
			$header_top_pad		= $this->document->params->get( 'header_top_pad', '15' );
			$header_right_pad	= $this->document->params->get( 'header_right_pad', '10' );
			$header_bot_pad		= $this->document->params->get( 'header_bot_pad', '10' );
			$header_left_pad	= $this->document->params->get( 'header_left_pad', '10' );
			$logo							= $this->document->params->get( 'logo', 'logo.png' );
			$style						= $this->document->params->get( 'style', 'blue' );


			if ($logo == 'template') {
			$background = JURI::base().'templates/'.$this->document->template.'/images/'.$style.'/logo.png';
			} else {
			$background = JURI::base().'images/'.$logo;
			}
			
			if ($headertype == "image") {
			echo "<h1 id=\"graphic\"><a style=\"width:".$header_width."px;height:".$header_height."px;\" href=\"".JURI::base()."\" title=\"".$tagline."\">".$headline."</a></h1>";
			$headerstyle = '#header span#graphic a,#header h1#graphic a {'
			        . 'height: '.$header_height.'px;'
			        . 'margin: '.$header_top_pad.'px '.$header_right_pad.'px '.$header_bot_pad.'px '.$header_left_pad.'px;'
							. 'background: url('.$background.') no-repeat left center;'
							. '}';
			$this->document->addStyleDeclaration($headerstyle);
			}
			if ($headertype == "text") {
			echo "<div class=\"logotext\"><h1 id=\"text-header\"><a href=\"".JURI::base()."\" title=\"".$headline."\">".$headline."</a></h1>"."<h2 id=\"text-slogan\">".$tagline."</h2></div>";
			$headerstyle = '.logotext {'
			        . 'width: '.$header_width.'px;float:left;'
			        . 'margin: '.$header_top_pad.'px 0px '.$header_bot_pad.'px 0px;'
							. '}';
			$this->document->addStyleDeclaration($headerstyle);
			}
		}
	// end getHeader function
	function getMenu() {
		$item_spacing			= $this->document->params->get( 'item_spacing', '18' );
		$header_width			= $this->document->params->get( 'header_width', '244' );
		$menuposition			= $this->document->params->get( 'menuposition', 'right' );
		$header_left_pad	= $this->document->params->get( 'header_left_pad', '10' );
		$header_right_pad	= $this->document->params->get( 'header_right_pad', '10' );

		if ($menuposition == "right") {
		$menu_offset = $header_width + $header_left_pad + $header_right_pad;
		$menu_width		= 950 - $menu_offset;
		} elseif ($menuposition == "below") {
		$menu_width		= "950";
		}
		$menustyle = '#menu_wrap {width: '.$menu_width.'px;float:right;}#menu ul li a {padding: 0px '.$item_spacing.'px;}';
		$this->document->addStyleDeclaration($menustyle);
	}
}


// Adds more modern styling to system messages

class JDocumentRendererMessage extends JDocumentRenderer
{
	/**
	 * Renders the error stack and returns the results as a string
	 *
	 * @param	string $name	(unused)
	 * @param	array $params	Associative array of values
	 * @return	string			The output of the script
	 */
	public function render($name, $params = array (), $content = null)
	{
		// Initialise variables.
		$buffer	= null;
		$lists	= null;

		// Get the message queue
		$messages = JFactory::getApplication()->getMessageQueue();

		// Build the sorted message list
		if (is_array($messages) && count($messages))
		{
			foreach ($messages as $msg)
			{
				if (isset($msg['type']) && isset($msg['message'])) {
					$lists[$msg['type']][] = $msg['message'];
				}
			}
		}

		// If messages exist render them
		if (is_array($lists))
		{
			// Build the return string
			$buffer .= "\n<div id=\"system-message\">";
			foreach ($lists as $type => $msgs)
			{
			if (count($msgs))
				{
					$buffer .= "\n<div class=\"".strtolower($type)." message\">";
					$buffer .= "\n<strong>".JText::_($type)."</strong><br />";
					$buffer .= "\n\t<ul>";
					foreach ($msgs as $msg) {
						$buffer .="\n\t\t<li>".$msg."</li>";
					}
					$buffer .= "\n\t</ul>";
					$buffer .= "\n</div>";
				}
			}
			$buffer .= "\n</div>";
		}
		return $buffer;
	}
}

