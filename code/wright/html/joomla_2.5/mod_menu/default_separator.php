<?php
// Wright v.3 Override: Joomla 2.5.17
/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ?
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else { $linktype = $item->title;
}

?><a href="<?php echo $item->flink; // Wright v.3: Added link option for collapsible menus ?>" class="separator"<?php echo $item->licollapse  // Wright v.3: Added collapsible option ?>><?php echo $title; ?><?php echo $linktype; ?><?php
// Wright v.3: Closing pseudo-link for sub-menus
if ($item->deeper) {
	// Opens a caret-right for levels 2 and above
	echo '<b class="caret"></b>';
}
?></a> <?php // Wright v.3 changed <span> for <a> for Bootstrap structure ?>
