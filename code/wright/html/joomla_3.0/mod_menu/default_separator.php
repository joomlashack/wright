<?php
// Wright v.3 Override: Joomla 3.1.5
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? ' title="'.$item->anchor_title.'" ' : '';
if ($item->menu_image)
	{
		$item->params->get('menu_text', 1) ?
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else { $linktype = $item->title;
}

// Wright v.3: Opening pseudo-link for sub-menus
if ($item->parent) {
	echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
}
// End Wright v.3: Opening pseudo-link for sub-menus

?><span class="separator<?php if (!$item->parent) : ?> separator-only<?php endif;  // Wright v.3: Added separator-only class to separators without children ?>"<?php echo $title; ?>><?php echo $linktype; ?><?php
// Wright v.3: Closing pseudo-link for sub-menus
if ($item->parent) {
	// Opens a caret-right for levels 2 and above
	if ($item->level > 1)
		echo '<i class="icon-caret-right"></i>';
	else
		echo '<b class="caret"></b>';
}
?></span><?php
if ($item->parent)
	echo '</a>';
// End Wright v.3: Closing pseudo-link for sub-menus
?>
