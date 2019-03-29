<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? ' title="' . $item->anchor_title . '" ' : '';

if ($item->menu_image) {
	$item->params->get('menu_text', 1 ) ?
		$linktype = $span1 . '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' . $span2 : // Wright v.4: Added optional spans
		$linktype = $span1 . '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />' . $span2; // Wright v.4: Added optional spans
}
else
{
	$linktype = $span1 . $item->title . $span2; // Wright v.4: Added optional spans
}

// Add the classes
$class  = ' heading';
$class .= $item->anchor_css;
$class .= ($item->deeper) ? ' dropdown-toggle' : '';
$class .= ($item->level == 1) ? ' nav-link ' : ' dropdown-item';
$class  = 'class="' . $class . '" ';

// Add the toggler
if($item->deeper) {
    $toggle = 'data-toggle="dropdown" aria-expanded="false"';
} else {
    $toggle = '';
}

?><a href="<?php echo $item->flink; // Wright v.4: Added link option for collapsible menus ?>" <?php echo $class . $item->licollapse // Wright v.4: Added collapsible option ?><?php echo $title; ?> <?php echo $toggle; ?>>
	<?php echo $structIcons . $linktype; ?><?php
	// Wright v.4: Closing pseudo-link for sub-menus
	if ($menuType == 'vertical') {
		echo '<b class="caret"></b>';
	}
	else{
		if($item->level == $params->get('startLevel', 1))
			echo '<b class="caret"></b>'; // Wright v.4: Added caret
	}
	?>
</a> <?php // Wright v.4 changed <span> for <a> for Bootstrap structure ?>
