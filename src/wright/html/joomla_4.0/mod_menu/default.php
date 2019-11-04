<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once(JPATH_THEMES.'/'.$app->getTemplate().'/wrighttemplate.php');

// Note. It is important to remove spaces between elements.

$wrightTemplate = WrightTemplate::getInstance();

/* @todo Find out what is removing empty spaces in module and menu classes.
 * Currently we use double empty space due one space is removed.
 * /

 *
/* Wright v.4: Distinguish collapsible and non-collapsible menus.  If the position is an official menu position in the template, or if it has the suffixe "no-collapse", it won't do the collapse */
$wrightCollapseMenus = true;
$menuType = 'vertical';

if (preg_match('/nav\-pills/', $class_sfx) || preg_match('/nav\-tabs/', $class_sfx) || preg_match('/justify\-content\-center/', $class_sfx) || preg_match('/justify\-content\-end/', $class_sfx)){
    $wrightCollapseMenus = false;
    $menuType = 'horizontal';
}
if (preg_match('/nav\-pills/', $class_sfx) && preg_match('/flex\-column/', $class_sfx)){
    $wrightCollapseMenus = false;
    $menuType = 'vertical';
}

if (preg_match('/no\-collapse/', $class_sfx)) {
	$wrightCollapseMenus = false;
    $menuType = 'vertical';
} else {
	if (in_array($module->position, $wrightTemplate->menuPositions)){
		$wrightCollapseMenus = false;
		$menuType = 'horizontal';
	}
}

/* End Wright v.4: Distinguish collapsible and non-collapsible menus */

// Set base menu class depending if the menu module is in native menu positions (menu, toolbar, bottom-menu)
if (in_array($module->position, $wrightTemplate->menuPositions)){
	$basemenu_class = 'navbar-nav';
}
else {
	$basemenu_class = 'nav';
}

$navlist = '';
if ($menuType == 'vertical'){
	if($class_sfx == '')
		$navlist = '  flex-column';
	elseif($class_sfx == ' no-collapse')
		$navlist = '  flex-column';
}

?>

<ul class="menu <?php echo $class_sfx . $navlist . ' ' . $basemenu_class;?> "<?php  // Wright v.4: Added $basemenu_class class
	$tag = '';

	if ($params->get('tag_id') != null)
	{
		$tag = $params->get('tag_id') . '';
		echo ' id="' . $tag . '"';
	}
?>>
<?php
foreach ($list as $i => &$item)
{
	$active = false;  // Wright v.4: Active toggle for collapsible menus
	$class = 'item-' . $item->id . ' ';

	if ($item->id == $active_id)
	{
		$class .= ' current';
	}

	if (in_array($item->id, $path))
	{
		$active = true;  // Wright v.4: Active toggle for collapsible menus
		$class .= ' active';
	}
	elseif ($item->type == 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$active = true;  // Wright v.4: Active toggle for collapsible menus
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator')
	{
		$class .= ''; // Wright v.4: Removed divider class from separators
	}


	if ($item->deeper)
	{
        $class  .= ' deeper dropdown';  // Wright v.4: Added dropdown class to parent items
	}

	if ($item->parent) {
		if($item->level > $params->get('startLevel', 1) && $menuType == 'horizontal')
		{
			$class .= ' parent dropdown-submenu'; // Wright v.4: Add dropdown-submenu class
		}
		else{
			$class .= ' parent ';
		}
	}

	$class .= ' nav-item';

	if (!empty($class))
	{
		$class = ' class="' . trim($class) . '"';
	}

    /* Wright v.4: Unique tagging for collapsible submenus */
    if ($item->deeper && !in_array($module->position, $wrightTemplate->menuPositions)){
        // When this property is added to a menu, the parent menu links won't work
        // however makes the dropdown accessible
        // @TODO check how to make dropdown accessible through keyboard
        $item->licollapse  = 'data-toggle="dropdown" ';
    } else {
        $item->licollapse = '';
    }
    $ulid = '';
    $idul = '';
    $uladd = '';

	if ($item->type == "separator" || $item->type == "heading")
		$item->flink = '#';
	if ($menuType == "vertical" && !$wrightCollapseMenus)
		$uladd .= 'submenu  unstyled';
	if ($item->deeper && $wrightCollapseMenus)
	{
		$ulid = 'wul_' . uniqid();
		$item->licollapse = ' data-toggle="collapse"';
		$item->flink = '#' . $ulid;
		$idul = ' id="' . $ulid . '"';
		$uladd = 'submenu  collapse' . ($active ? ' in' : '');
	}
	/* End Wright v.4: Unique tagging for collapsible submenus */

	echo '<li' . $class . '>';  // Wright v.4: Added collapsible option


	// Wright v.4: Created additional structure for icons
	$structIcons    = '';
	$span1          = '';
	$span2          = '';
	$hidden         = '';

    // Solid Font Awesome Icons. e.g. fas fa-user
    if (preg_match_all('/fas fa-([\S]+)/', $item->anchor_css, $matches))
    {
        $item->anchor_css = preg_replace('/fas fa-([\S]+)/', '', $item->anchor_css);
        $icons = 'fas fa-' . implode(' fas fa-', $matches[1]);
        $structIcons = '<i class="' . $icons . '"></i>';
    }

    // Regular Font Awesome Icons. e.g. far fa-check-square
    if (preg_match_all('/far fa-([\S]+)/', $item->anchor_css, $matches))
    {
        $item->anchor_css = preg_replace('/far fa-([\S]+)/', '', $item->anchor_css);
        $icons = 'far fa-' . implode(' far fa-', $matches[1]);
        $structIcons = '<i class="' . $icons . '"></i>';
    }

	// Brands Font Awesome Icons. e.g. fab fab-facebook
	if (preg_match_all('/fab fa-([\S]+)/', $item->anchor_css, $matches))
	{
		$item->anchor_css = preg_replace('/fab fa-([\S]+)/', '', $item->anchor_css);
		$icons = 'fab fa-' . implode(' fab fa-', $matches[1]);
		$structIcons = '<i class="' . $icons . '"></i>';
	}

	if (preg_match_all('/hidden-text/', $item->anchor_css, $matches))
	{
		$span1 = '<span class="hidden-text">';
		$span2 = '</span>';
	}
	// End Wright v.4: Created additional structure for icons

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
		case 'heading':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {

		// Wright v.4 adds sub-menu for level 2 and beyond

		$dropdownmenu = $menuType == 'vertical' ? '' : 'dropdown-menu';  // Wright v.4 adds sub-menu for level 2 and beyond
		echo '<ul' . $idul . ' class="' . $dropdownmenu . $uladd . '" role="menu">';  // Wright v.4: Added dropdown-menu class for submenus and collapsible menus options (including collapsed)
	}
	// The next item is shallower.
	elseif ($item->shallower)
	{
		// The next item is shallower.
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	else
	{
		// The next item is on the same level.
		echo '</li>';
	}
}
?></ul>
