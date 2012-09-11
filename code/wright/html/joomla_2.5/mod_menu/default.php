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

	function convert_li($matches) {
		return "<li" . $matches[1] . "class" . $matches[2] . " parent dropdown " . $matches[3] . "><a href='#' class='dropdown-toggle' data-toggle='dropdown'>" .
			$matches[6] . "<i class='icon-arrow-right'></i></a>" . $matches[7] . "<ul class='dropdown-menu sub-menu'>";
	}
	
	function convert_icons($matches) {
		$space = stripos($matches[5]," ");
		$afterspace = "";
		if ($space !== FALSE)
			$afterspace = substr($matches[5],$space+1);
		
		return "<li" . $matches[1] . ">" . $matches[2] . "<a" . $matches[3] . "class='" . $afterspace . "'" . $matches[6] . "><i class='icon-" . $matches[5] . "'></i>";
	}

	function wright_joomla_nav($buffer) {
		// sets main ul nav class
		$buffer = preg_replace_callback("/<ul([^>]*)class([^>]*)\"([^>]*)\"([^>]*)>/i",  "convert_ul_main", $buffer);

		// converts a (links) into bootstrap classes
		$buffer = preg_replace_callback("/<li([^>]*)class([^>]*)parent([^>]*)>([^<a]*)<a([^>]*)>([^\<\/]*)\<\/a>([^<]*)<ul>/iU",  "convert_li", $buffer);
	
		// converts span (separators) into bootstrap classes
		$buffer = preg_replace_callback("/<li([^>]*)class([^>]*)parent([^>]*)>([^<sp]*)<span([^>]*)>([^\<\/]*)\<\/span>([^<]*)<ul>/iU",  "convert_li", $buffer);

		// converts icons into bootstrap/fontawesomemore icons format
		$buffer = preg_replace_callback("/<li([^>]*)>([^<a]*)<a([^>]*)class=\"([^\"]*)icon\-([^\"]*)\"([^>]*)>/iU",  "convert_icons", $buffer);

		// extracts first childs to change submenu to main dropdown
		$dom = new DOMDocument();
		$res = $dom->loadHTML($buffer);
		$ul = $dom->lastChild->firstChild->firstChild;

		$li = $ul->firstChild;
		while ($li) {
			$class = $li->getAttribute("class");
			if (stristr($class, 'parent') !== FALSE) {
				$a = $li->firstChild;
				$i = $a->firstChild;
				$i = $i->nextSibling;

				$a->removeChild($i);

				$ulc = $a->nextSibling;
				if (!$ulc->tagName)
					$ulc = $ulc->nextSibling;
				$ulc->setAttribute("class","dropdown-menu");

				$b = $dom->createElement("b");
				$b->setAttribute("class","caret");

				//TODO: consider no image / no text and combinations
				/*
				if ($img !== NULL) {
					$a->appendChild($img);
					$a->appendChild($spanimg);
				}
				else {
					$a->appendChild($t);
				}
				 */

				$a->appendChild($b);
			}
			$li = $li->nextSibling;
		}

		$s = $dom->saveHTML();
		$s = preg_replace("/<!DOCTYPE([^>]*)>/Ui", "", $s);
		$s = preg_replace("/<html([^>]*)>/Ui", "", $s);
		$s = preg_replace("/<body([^>]*)>/Ui", "", $s);
		$s = preg_replace("/<\/body([^>]*)>/Ui", "", $s);
		$s = preg_replace("/<\/html([^>]*)>/Ui", "", $s);	

		return $s;
	}

endif;

ob_start("wright_joomla_nav");
require('modules/mod_menu/tmpl/default.php');
ob_end_flush();
?>