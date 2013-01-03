<?php
/**
 * @version		$Id: default.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

if (!function_exists("wright_joomla_nav")) :
	function convert_ul_main($matches) {
		return "<ul" . $matches[1] . "class" . $matches[2] . "\"nav " . $matches[3] . "\"" . $matches[4] . ">";
	}

	function convert_li($matches, $img) {
		$class = "";
		$classa = "";
		$link = "#";
		
		if (preg_match('/([^"]*)class="([^"]*)icon-([^"]*)"/Ui', $matches[5], $matches2)) {
			$class = trim($matches2[3]);
			
			$space = stripos($class," ");
			$afterspace = "";
			if ($space !== FALSE) {
				$classa = trim(substr($class,$space+1));
				$class = trim(substr($class,0,$space));
			}
		}
		elseif (preg_match('/([^"]*)class="([^"]*)icon-([^"]*)"/Ui', $matches[7], $matches2)) {
			$class = trim($matches2[3]);
			
			$space = stripos($class," ");
			$afterspace = "";
			if ($space !== FALSE) {
				$classa = trim(substr($class,$space+1));
				$class = trim(substr($class,0,$space));
			}
		}
		
		if ($matches[6] != "")
			$link = $matches[6];
		
		return "<li" . $matches[1] . "class" . $matches[2] . " parent dropdown " . $matches[3] . ">" . $matches[4] . "<a href='$link' class='dropdown-toggle disabled' data-toggle='dropdown-menus'>" .
			($class != "" ? "<i class='icon-$class'></i>" : "") . 
			($img != "" ? "<img" . $img . ">" : "") .
			"<span class='$classa'>" . $matches[8] . "</span><i class='icon-caret-right'></i></a>" . $matches[9] . "<ul" . $matches[10] . "class='" . $matches[11] . " dropdown-menu sub-menu'" . $matches[12] . ">";
	}



	function convert_span_separator($matches) {
		$matches2 = Array();
		$matches2[0] = $matches[0];
		$matches2[1] = $matches[1];
		$matches2[2] = $matches[2];
		$matches2[3] = $matches[3];
		$matches2[4] = $matches[4];
		$matches2[5] = $matches[6] . " " . $matches[7];
		$matches2[6] = "";
		$matches2[7] = "";
		$matches2[8] = $matches[8];
		$matches2[9] = $matches[9];
		$matches2[10] = $matches[10];
		$matches2[11] = $matches[11];
		$matches2[12] = $matches[12];
		
		return convert_li($matches2);
	}



	function convert_icons($matches) {
		$space = stripos($matches[5]," ");
		$afterspace = "";
		if ($space !== FALSE) {
			$afterspace = substr($matches[5],$space+1);
			$matches[5] = substr($matches[5],0,$space);
		}
		
		return "<li" . $matches[1] . ">" . $matches[2] .
			"<a" . $matches[3] . " " . $matches[6] . "><i class='icon-" . $matches[5] . "'></i>" .
			"<span class='" . $afterspace . "'>" . $matches[7] . "</span></a>";
	}
	
	function convert_main_lis($matches, $class) {
		return '<li' . $matches[1] . 'class="' . $matches[2] . ' ' . $matches[3] . '"' . $matches[4] . '>' .
			$matches[5] . '<a' . $matches[6] . '>' . $matches[7] . '<b class="caret"></b>' . $matches[10] .
			'</a>' . $matches[11] . '<ul class="dropdown-menu">';
	}

	function wright_joomla_nav($buffer) {
		// removes dividers (to ensure they can be parents)
		$buffer = preg_replace("/<li class=\"item-([^\"]*)divider([^\"]*)\"/iU", "<li class=\"item-$1$2\"", $buffer);
		
		// converts a (links) - parents with child ul - into bootstrap classes
		$buffer = preg_replace_callback('/<li([^>]*)class([^>]*)parent([^>]*)>([^<]*)<a([^>]*)href="([^"]*)"([^>]*)>([^<]*)<\/a>([^<]*)<ul([^>]*)class="([^"]*)"([^>]*)>/iU',  "convert_li", $buffer);

		// converts span (separators) - parents with child ul - into bootstrap classes
		$buffer = preg_replace_callback('/<li([^>]*)class([^>]*)parent([^>]*)>([^<]*)<span([^>]*)class="([^"]*)separator([^"]*)">([^<]*)<\/span>([^<]*)<ul([^>]*)class="([^"]*)"([^>]*)>/iU',  "convert_span_separator", $buffer);

		// converts icons into bootstrap/fontawesomemore icons format
		$buffer = preg_replace_callback("/<li([^>]*)>([^<]*)<a([^>]*)class=\"([^\"]*)icon\-([^\"]*)\"([^>]*)>([^<]*)<\/a>/iU",  "convert_icons", $buffer);
		// searches for <li> in the top level, only if they are dropdowns, to set the appropriate classes to <i> and <ul> elements
	 	$parents = Array();	
		$xml = new SimpleXMLElement($buffer);
		//echo $xml->getName();
		foreach ($xml->children() as $c) {
			$atts = $c->attributes();
			foreach ($atts as $a => $val) {
				if ($a == "class" && strpos(trim((string)$val), "dropdown") !== FALSE) {
					//$parents[] = trim((string)$val);
					
					$class = trim((string)$val);
					$buffer = preg_replace('/<li([^>]*)class="([^"]*)' . $class . '([^"]*)"([^>]*)>([^<]*)<a([^>]*)>(.*)<i([^>]*)>([^<]*)<\/i>([^<]*)<\/a>([^<]*)<ul([^>]*)>/Ui',
						'<li' . '$1' . 'class="' . '$2' . $class . '$3' . '"' . '$4' . '>' .
						'$5' . '<a' . '$6' . '>' . '$7' . '<b class="caret"></b>' . '$10' .
						'</a>' . '$11' . '<ul class="dropdown-menu">', $buffer);
					
				}
			}
		}
		return $buffer;
	}

endif;

ob_start("wright_joomla_nav");
require('modules/mod_menu/tmpl/default.php');
ob_end_flush();

?>
