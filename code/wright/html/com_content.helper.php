<?php
/**
 * @version		$Id: com_content.helper.php
 * @package		Joomlashack.Wright
 * @subpackage	Overrider
 * @copyright	Copyright (C) 2005 - 2013 Joomlashack, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

	// btnActions puts the button actions (mail, print) at the beginning
	// articleInfo puts the <dl> article-info at the beginning
	// span6Images puts images in span6 (left, right or none), according to the configuration, next to the content
	// allImagesTop moves all the images to the beginning without floating (cannot be used with span6Images)
	// floatTitle can be "left" or "right" for floating the title (span6) next to the content
	
	// consider that the final order will be inverse to the application, stacked order
	
	function transformLeadingArticles($buffer, $btnActions = true, $articleInfo = true, $span6Images = true, $allImagesTop = false, $floatTitle = "") {
		if ($allImagesTop) $span6Images = false;
		
		$addContent = "";
		if ($floatTitle == "left" || $floatTitle == "right")
			$addContent = " span6";

		// mark separators to match each leading article's beginning, wraps content in a single div
		$buffer = preg_replace("/<div class=\"leading-([0-9]+)\">(.*)<div class=\"item-separator\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1 overlapped\"><div class=\"leading-content$addContent\">$2</div><div class=\"item-separator leadingabs-$1\">$3</div>$4</div>", $buffer);
		
		if ($floatTitle == "left") {
			// move title to the beginning with span6
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<div class=\"page-header\">(.*)<\/div>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><div class=\"leading-all-content row-fluid\"><div class=\"page-header span6\">$4</div>$3$5</div><div class=\"item-separator leadingabs-$1\">$6</div>$7</div>", $buffer);
		}
		elseif ($floatTitle = "right") {
			// move title to the end with span6
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<div class=\"page-header\">(.*)<\/div>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><div class=\"leading-all-content row-fluid\">$3$5<div class=\"page-header span6\">$4</div></div><div class=\"item-separator leadingabs-$1\">$6</div>$7</div>", $buffer);
		}
		
		if ($btnActions) {
			// move action buttons to the beginning
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<ul class=\"btn-group actions\">(.*)<\/ul>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><ul class=\"btn-group actions\">$4</ul>$3$5<div class=\"item-separator leadingabs-$1\">$6</div>$7</div>", $buffer);
		}

		if ($articleInfo) {
			// move article info to the beginning
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<dl class=\"article-info\">(.*)<\/dl>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><dl class=\"article-info\">$4</dl>$3$5<div class=\"item-separator leadingabs-$1\">$6</div>$7</div>", $buffer);
		}
		
		if ($span6Images) {
			// move non floated images to the beginning
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-none\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><div class=\"img-intro-none\">$4<img$5>$6</div>$3$7<div class=\"item-separator leadingabs-$1\">$8</div>$9</div>", $buffer);
	
			// move left images to a separate span6
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-left\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><div class=\"row-fluid\"><div class=\"span6\"><div class=\"img-intro-none\">$4<img$5>$6</div></div><div class=\"span6\">$3$7</div></div><div class=\"item-separator leadingabs-$1\">$8</div>$9</div>", $buffer);
	
			// move right images to a separate span6
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-right\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><div class=\"row-fluid\"><div class=\"span6\">$3$7</div><div class=\"span6\"><div class=\"img-intro-none\">$4<img$5>$6</div></div></div><div class=\"item-separator leadingabs-$1\">$8</div>$9</div>", $buffer);
		}
		
		if ($allImagesTop) {
			$buffer = preg_replace("/<div class=\"leading-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-([a-z]+)\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator leadingabs-\\1\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"leading-$1$2\"><div class=\"img-intro-none\">$5<img$6>$7</div>$3$8<div class=\"item-separator leadingabs-$1\">$9</div>$10</div>", $buffer);
		}
		return $buffer;
	}
	
	
	// btnActions puts the button actions (mail, print) at the beginning
	// articleInfo puts the <dl> article-info at the beginning
	// span6Images puts images in span6 (left, right or none), according to the configuration, next to the content
	// allImagesTop moves all the images to the beginning without floating (cannot be used with span6Images)
	
	// consider that the final order will be inverse to the application, stacked order
	
	function transformIntroArticles($buffer, $btnActions = true, $articleInfo = true, $span6Images = true, $allImagesTop = false) {
		if ($allImagesTop) $span6Images = false;

		$i = 1;
		while ($i) {
			// identify each column (intro post) with unique coordinate row-column
			$buffer = preg_replace("/<div class=\"items-row([^\"]*)row-([0-9]+)([^\"]*)\">(.*)<div class=\"item([^\"]*)column-([0-9]+)(?<=(?! itemabs))([^\"]*)\">(.*)<span class=\"row-separator\">([^<]*)<\/span>([^<]*)<\/div>/sUi", "<div class=\"items-row$1row-$2$3\">$4<div class=\"item$5column-$6 itemabs-$2-$6$7\">$8<span class=\"row-separator\">$9</span>$10</div>", $buffer, -1, $i);
		}
		
		// mark each separator with the unique coordinate (to mark beginning-end of each intro post)
		$buffer = preg_replace("/<div class=\"item([^\"]*)column-([0-9]+)([^\"]*)itemabs-([0-9]+)-([0-9]+)([^\"]*)\">(.*)<div class=\"item-separator\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"item$1column-$2$3itemabs-$4-$5$6 overlapped\"><div class=\"intro-content\">$7</div><div class=\"item-separator item-separator-abs-$4-$5\">$8</div>$9</div>", $buffer);
		
		if ($btnActions) {
			// move action buttons to the beginning
			$buffer = preg_replace("/<div class=\"item([^\"]*)column-([0-9]+)([^\"]*)itemabs-([0-9]+)-([0-9]+)([^\"]*)\">(.*)<ul class=\"btn-group actions\">(.*)<\/ul>(.*)<div class=\"item-separator item-separator-abs-\\4-\\5\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"item$1column-$2$3itemabs-$4-$5$6\"><ul class=\"btn-group actions\">$8</ul>$7$9<div class=\"item-separator item-separator-abs-$4-$5\">$10</div>$11</div>", $buffer);
		}

		if ($articleInfo) {
			// move article info to the beginning
			$buffer = preg_replace("/<div class=\"item([^\"]*)column-([0-9]+)([^\"]*)itemabs-([0-9]+)-([0-9]+)([^\"]*)\">(.*)<dl class=\"article-info\">(.*)<\/dl>(.*)<div class=\"item-separator item-separator-abs-\\4-\\5\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"item$1column-$2$3itemabs-$4-$5$6\"><dl class=\"article-info\">$8</dl>$7$9<div class=\"item-separator item-separator-abs-$4-$5\">$10</div>$11</div>", $buffer);
		}
		
		if ($span6Images) {
			// move non floated images to the beginning
			$buffer = preg_replace("/<div class=\"item([^\"]*)column-([0-9]+)([^\"]*)itemabs-([0-9]+)-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-none\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator item-separator-abs-\\4-\\5\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"item$1column-$2$3itemabs-$4-$5$6\"><div class=\"img-intro-none\">$8<img$9>$10</div>$7$11<div class=\"item-separator item-separator-abs-$4-$5\">$12</div>$13</div>", $buffer);
	
			// move left images to a separate span6		
			$buffer = preg_replace("/<div class=\"item([^\"]*)column-([0-9]+)([^\"]*)itemabs-([0-9]+)-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-left\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator item-separator-abs-\\4-\\5\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"item$1column-$2$3itemabs-$4-$5$6\"><div class=\"row-fluid\"><div class=\"span6\"><div class=\"img-intro-none\">$8<img$9>$10</div></div><div class=\"span6\">$7$11</div></div><div class=\"item-separator item-separator-abs-$4-$5\">$12</div>$13</div>", $buffer);
	
			// move right images to a separate span6
			$buffer = preg_replace("/<div class=\"item([^\"]*)column-([0-9]+)([^\"]*)itemabs-([0-9]+)-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-right\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator item-separator-abs-\\4-\\5\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"item$1column-$2$3itemabs-$4-$5$6\"><div class=\"row-fluid\"><div class=\"span6\">$7$11</div><div class=\"span6\"><div class=\"img-intro-none\">$8<img$9>$10</div></div></div><div class=\"item-separator item-separator-abs-$4-$5\">$12</div>$13</div>", $buffer);
		}
		
		if ($allImagesTop) {
			$buffer = preg_replace("/<div class=\"item([^\"]*)column-([0-9]+)([^\"]*)itemabs-([0-9]+)-([0-9]+)([^\"]*)\">(.*)<div class=\"img-intro-([a-z]+)\">([^<]*)<img([^>]*)>([^<]*)<\/div>(.*)<div class=\"item-separator item-separator-abs-\\4-\\5\">([^<]*)<\/div>([^<]*)<\/div>/sUi", "<div class=\"item$1column-$2$3itemabs-$4-$5$6\"><div class=\"img-intro-none\">$9<img$10>$11</div>$7$12<div class=\"item-separator item-separator-abs-$4-$5\">$13</div>$14</div>", $buffer);
		}

		return $buffer;
	}
	
	
?>