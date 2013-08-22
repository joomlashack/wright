<?php
/**
 * @package     Wright
 * @subpackage  Overrider
 *
 * @copyright   Copyright (C) 2005 - 2013 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

require_once(JPATH_PLATFORM . '/joomla/html/html/sliders.php');

abstract class JHtmlWrightSliders extends JHtmlSliders
{
	public static function panel($text, $id)
	{
		return '</div></div><div class="panel"><i class="icon-sort"> </i><h3 class="pane-toggler title" id="' . $id . '"><a href="javascript:void(0);"><span>' . $text
			. '</span></a></h3><div class="pane-slider content">';
			// Wright v.3: Added Icon
	}

}