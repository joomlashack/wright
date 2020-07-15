<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Wright v.3: Created additional structure for icons
$structIcons    = '';
$span1          = '';
$span2          = '';
$hidden         = '';

if (preg_match_all('/icon-([\S]+)/', $item->anchor_css, $matches))
{
    $item->anchor_css = preg_replace('/icon-([\S]+)/', '', $item->anchor_css);
    $icons = 'icon-' . implode(' icon-', $matches[1]);
    $structIcons = '<i class="' . $icons . '"></i>';
}

if (preg_match_all('/hidden-text/', $item->anchor_css, $matches))
{
    $span1  = '<span class="hidden-text">';
    $span2  = '</span>';
    $hidden = 'hidden-text ';
}
// End Wright v.3: Created additional structure for icons

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? ' title="' . $item->anchor_title . '" ' : '';
if ($item->menu_image)
	{
		$item->params->get('menu_text', 1) ?
		$linktype = $span1 . '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' . $span2 :
		$linktype = $span1 . '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />' . $span2;
}
else
{
	$linktype = $span1 . $item->title . $span2;
}

$class = ($item->deeper) ? 'class="' . $hidden . 'separator dropdown-toggle" ' : 'class="' . $hidden . 'separator" ' ;

?><a href="<?php echo $item->flink; // Wright v.3: Added link option for collapsible menus ?>" <?php echo $class . $item->licollapse // Wright v.3: Added collapsible option ?>><?php echo $title; ?>
	<?php echo $structIcons . $linktype; ?><?php

// Wright v.3: Closing pseudo-link for sub-menus
if ($item->deeper) {
	// Opens a caret-right for levels 2 and above
	if ($menuType == 'vertical') {
		echo '<b class="caret"></b>';
	}
	else{
		if($item->level >= $params->get('startLevel', 1))
			echo '<b class="caret"></b>'; // Wright v.3: Added caret
	}
}
?></a> <?php // Wright v.3 changed <span> for <a> for Bootstrap structure
