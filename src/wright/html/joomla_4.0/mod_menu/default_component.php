<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Wright v.4: Created additional structure for icons
$structIcons = '';
$span1 = '';
$span2 = '';

if (preg_match_all('/icon-([\S]+)/', $item->anchor_css, $matches))
{
	$item->anchor_css = preg_replace('/icon-([\S]+)/', '', $item->anchor_css);
	$icons = 'icon-' . implode(' icon-', $matches[1]);
	$structIcons = '<i class="' . $icons . '"></i>';
}

if (preg_match_all('/hidden-text/', $item->anchor_css, $matches))
{
	$span1 = '<span class="hidden-text">';
	$span2 = '</span>';
}
// End Wright v.4: Created additional structure for icons

// Add the classes
$class  = $item->anchor_css;
$class .= ($item->deeper) ? ' dropdown-toggle' : '';
$class .= ($item->level == 1) ? ' nav-link' : ' dropdown-item';
$class  = 'class="' . $class . '" ';

// Add the toggler
if($item->deeper) {
    $toggle = 'data-toggle="dropdown" aria-expanded="false"';
} else {
    $toggle = '';
}

// The anchor title
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';

if ($menuType == 'vertical') {
	$caret = $item->deeper ? '<b class="caret"></b>' : '';  // Wright v.4: Added caret
}
else{
	$caret = '';
	if($item->level == 1)
		$caret = $item->deeper ? '<b class="caret"></b>' : '';  // Wright v.4: Added caret
}

if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ?
		$linktype = $span1 . '<img src="' . $item->menu_image . '" alt="' . $item->title . '" /><span class="image-title">' . $item->title . '</span> ' . $span2 : // Wright v.4: Added optional spans
		$linktype = $span1 . '<img src="' . $item->menu_image . '" alt="' . $item->title . '" />' . $span2; // Wright v.4: Added optional spans
}
else
{
	$linktype = $span1 . $item->title . $span2; // Wright v.4: Added optional spans
}

switch ($item->browserNav)
{
	default:
	case 0:
?><a<?php echo $item->licollapse  // Wright v.4: Added collapsible option ?> <?php echo $class; ?>href="<?php echo $item->flink; ?>" <?php echo $title; ?> <?php echo $toggle; ?>><?php  echo $structIcons . $linktype; // Wright v.4: Added icons structure ?><?php echo $caret // Wright v.4: Added caret ?></a><?php
		break;
	case 1:
		// _blank
?><a<?php echo $item->licollapse  // Wright v.4: Added collapsible option ?> <?php echo $class; ?>href="<?php echo $item->flink; ?>" target="_blank" <?php echo $title; ?> <?php echo $toggle; ?>><?php  echo $structIcons . $linktype; // Wright v.4: Added icons structure ?><?php echo $caret // Wright v.4: Added caret ?></a><?php
		break;
	case 2:
	// window.open
?><a<?php echo $item->licollapse  // Wright v.4: Added collapsible option ?> <?php echo $class; ?>href="<?php echo $item->flink; ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;" <?php echo $title; ?> <?php echo $toggle; ?>><?php  echo $structIcons . $linktype; // Wright v.4: Added icons structure ?><?php echo $caret // Wright v.4: Added caret ?></a>
<?php
		break;
}
