<?php
// Wright v.3 Override: Joomla 3.1.5
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.

/* Wright v.3: Distinguish collapsible and non-collapsible menus.  If the position is an official menu position in the template, or if it has the suffixe "no-collapse", it won't do the collapse */
$wrightCollapseMenus = true;
if (preg_match('/no\-collapse/', $class_sfx)) {
	$wrightCollapseMenus = false;
}
else {
	$wrightTemplate = WrightTemplate::getInstance();
	if (in_array($module->position, $wrightTemplate->menuPositions))
		$wrightCollapseMenus = false;
}
/* End Wright v.3: Distinguish collapsible and non-collapsible menus */

?>
<?php // The menu class is deprecated. Use nav instead. ?>
<ul class="nav menu<?php echo $class_sfx;?>"<?php
	$tag = '';
	if ($params->get('tag_id') != null)
	{
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$active = false;  // Wright v.3: Active toggle for collapsible menus
	$class = 'item-'.$item->id;
	if ($item->id == $active_id)
	{
		$class .= ' current';
	}

	if (in_array($item->id, $path))
	{
		$active = true;  // Wright v.3: Active toggle for collapsible menus
		$class .= ' active';
	}
	elseif ($item->type == 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator')
	{
		$class .= ''; // Wright v.3: Removed divider class from separators
	}

	if ($item->deeper)
	{
		$class .= ' deeper dropdown';  // Wright v.3: Added dropdown class to parent items
	}

	if ($item->parent)
	{
		$class .= ' parent';
	}

	if (!empty($class))
	{
		$class = ' class="'.trim($class) .'"';
	}

	/* Wright v.3: Unique tagging for collapsible submenus */
	$ulid = '';
	$item->licollapse = '';
	$idul = '';
	$uladd = '';
	if ($item->type == "separator" || $item->type == "heading")
		$item->flink = '#';
	if ($item->deeper && $wrightCollapseMenus) {
		$ulid = 'wul_' . uniqid();
		$item->licollapse = ' data-toggle="collapse"';
		$item->flink = '#' . $ulid;
		$idul = ' id="' . $ulid . '"';
		$uladd = ' collapse' . ($active ? ' in' : '');
	}
	/* End Wright v.3: Unique tagging for collapsible submenus */

	echo '<li'.$class . '>';  // Wright v.3: Added collapsible option

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
		case 'heading':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper)
	{
		$submenu = $item->level > 1 ? ' sub-menu' : '';  // Wright v.3 adds sub-menu for level 2 and beyond
		echo '<ul' . $idul . ' class="nav-child unstyled small dropdown-menu' . $uladd . $submenu . '">';  // Wright v.3: Added dropdown-menu class for submenus and collapsible menus options (including collapsed)
	}
	// The next item is shallower.
	elseif ($item->shallower)
	{
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
endforeach;
?></ul>
