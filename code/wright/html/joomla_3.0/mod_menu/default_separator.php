<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? ' title="' . $item->anchor_title . '" ' : '';
if ($item->menu_image)
	{
		$item->params->get('menu_text', 1) ?
		$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' :
		$linktype = '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />';
}
else
{
	$linktype = $item->title;
}

$class = ($item->deeper) ? 'class="separator dropdown-toggle" ' : 'class="separator" ' ;

?><a href="<?php echo $item->flink; // Wright v.3: Added link option for collapsible menus ?>" <?php echo $class . $item->licollapse // Wright v.3: Added collapsible option ?>><?php echo $title; ?>
	<?php echo $linktype; ?><?php
	// Wright v.3: Closing pseudo-link for sub-menus
	if ($menuType == 'vertical') {
		echo '<b class="caret"></b>';
	}
	else{
		if($item->level == 1)
			echo '<b class="caret"></b>'; // Wright v.3: Added caret
	}
	?>
</a> <?php // Wright v.3 changed <span> for <a> for Bootstrap structure ?>
