<?php
// Wright v.3 Override: Joomla 2.5.14
/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.

// Wright v.3: Created additional structure for icons
$structIcons = '';
if (preg_match_all('/icon-([\S]+)/', $item->anchor_css, $matches)) {
	$item->anchor_css = preg_replace('/icon-([\S]+)/', '', $item->anchor_css);
	$icons = 'icon-' . implode(' icon-',$matches[1]);
	$structIcons = '<i class="' . $icons . '"></i>';
}
// End Wright v.3: Created additional structure for icons

$class = ($item->anchor_css || $item->parent) ? 'class="'.$item->anchor_css. ($item->parent ? ' dropdown-toggle disabled' : '') . '" ' : '';  // Wright v.3:  Added parent classes for Bootstrap
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
$toggle = $item->parent ? ' data-toggle="dropdown-menus"' : '';  // Wright v.3: Added data-toggle attribute to parents
$caret = $item->parent ? ($item->level > 1 ? '<i class="icon-caret-right"></i>' : '<b class="caret"></b>') : '';  // Wright v.3: Added caret

if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ?
		$linktype = '<span ' . $class . '>' . '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span>' . '</span>' :  // Wright v.3: Added span to apply classes
		$linktype = '<span ' . $class . '>' . '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />' . '</span>';  // Wright v.3: Added span to apply classes
}
else { $linktype = '<span ' . $class . '>' . $item->title . '</span>';  // Wright v.3: Added span to apply classes
	$class = '';
}
$flink = $item->flink;
$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));

switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo $toggle; // Wright v.3: Removed class and added toggle for submenus ?> href="<?php echo $flink; ?>" <?php echo $title; ?>><?php echo $structIcons . $linktype; // Wright v.3: Added icons structure ?><?php echo $caret // Wright v.3: Added caret ?></a><?php
		break;
	case 1:
		// _blank
?><a <?php echo $toggle; // Wright v.3: Removed class and added toggle for submenus ?> href="<?php echo $flink; ?>" target="_blank" <?php echo $title; ?>><?php  echo $structIcons . $linktype; // Wright v.3: Added icons structure ?><?php echo $caret // Wright v.3: Added caret ?></a><?php
		break;
	case 2:
		// window.open
		$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$params->get('window_open');
			?><a <?php echo $toggle; // Wright v.3: Removed class and added toggle for submenus ?> href="<?php echo $flink; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;" <?php echo $title; ?>><?php  echo $structIcons . $linktype; // Wright v.3: Added icons structure ?><?php echo $caret // Wright v.3: Added caret ?></a><?php
		break;
endswitch;
