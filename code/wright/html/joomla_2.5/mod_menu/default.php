<?php
/**
 * @version		$Id: default.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
$nav_dropdown = '';
if ( preg_match( '/nav-dropdown/', $class_sfx ) ) {
	$nav_dropdown = " nav-dropdown";
}
$nav_flyout = '';
if ( preg_match( '/nav-flyout/', $class_sfx ) ) {
	$nav_flyout = " nav-flyout";
}
$nav_stacked = '';
if ( preg_match( '/nav-stacked/', $class_sfx ) ) {
	$nav_stacked = " nav-stacked";
}
$nav_list = '';
if ( preg_match( '/nav-list/', $class_sfx ) ) {
	$nav_list = " nav-list";
}

$isNavbar = false;
if ( preg_match( '/navbar/', $params->get('moduleclass_sfx') ) ) {
    $isNavbar = true;
}

// Note. It is important to remove spaces between elements.
?>

<?php if ($isNavbar):?>
    <div class="navbar-inner">
        <div class="container">
            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </a>
            <!-- collapse menu -->
            <div class="nav-collapse">
<?php endif; ?>

<ul class="nav<?php echo $class_sfx;?>"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (	$item->type == 'alias' &&
			in_array($item->params->get('aliasoptions'),$path)
		||	in_array($item->id, $path)) {
		$class .= ' active';
	}

	if (($item->deeper) && ($nav_dropdown)) {
		$class .= ' dropdown';
	}

	elseif ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}

	echo '<li'.$class.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
	        include('default_'.$item->type.'.php');
			break;

		default:
		    include('default_url.php');
			break;
	endswitch;

	// The next item is deeper.
	if (($item->deeper) && ($nav_flyout)) {
		echo '<ul class="flyout-menu">';
	}
	elseif (($item->deeper) && ($nav_dropdown)){
		if ($item->level < 2) {
			echo '<ul class="dropdown-menu">';
		}
		else {
			echo '<ul class="flyout-menu">';
		}
	}
	elseif ($item->deeper) {
		echo '<ul>';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
endforeach;
?></ul>

<?php if ($isNavbar):?>
            </div>
        </div>
    </div>
<?php endif; ?>
