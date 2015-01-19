<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$wrightMaxColumns = (isset($wrightMaxColumns) ? $wrightMaxColumns : 3);  // Wright v.3: Max columns to be used
$wrightHorizontal = (isset($wrightHorizontal) ? $wrightHorizontal : false);  // Wright v.3: Horizontal view
$wrightHorizontalLinkedDescriptions = (isset($wrightHorizontalLinkedDescriptions) ? $wrightHorizontalLinkedDescriptions : false);  // Wright v.3: Link categories on horizontal view
/* Wright v.3: Grab parameter for max column number, setting it to one of the allowed Bootstrap values */
if ($wrightMaxColumns > 6) {
	$wrightMaxColumns = 6;
}

$span = (int)(12 / $wrightMaxColumns);
/* End Wright v.3: Grab parameter for max column number */

$c = 0; // Wright v.3: Counter variable to get horizontal columns (set by $wrightMaxColumns)

foreach ($list as $item) :

	/* Wright v.3: If horizontal display is enabled, displays categories showing category image (when available) and in horizontal / column layout */
 if ($wrightHorizontal) {
 ?>
<?php if ($c % $wrightMaxColumns ==  0):?>
	<div class="row-fluid categories-module<?php echo $moduleclass_sfx; ?>">
<?php endif; ?>
<div class="span<?php echo $span ?>" <?php if ($_SERVER['PHP_SELF'] == JRoute::_(ContentHelperRoute::getCategoryRoute($item->id))) echo ' class="active"';?>> <?php $levelup=$item->level-$startLevel -1; ?>
  <?php if($item->getParams()->get('image')){  ?>
  	<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<img src="<?php echo $item->getParams()->get('image'); ?>" class="img-block">
	</a>
 <?php } ?>
<span class="category-title">
  <h<?php echo $params->get('item_heading')+ $levelup; ?>>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<?php echo $item->title;?></a>
   </h<?php echo $params->get('item_heading')+ $levelup; ?>>
</span>
		<?php
		if($params->get('show_description', 0)) :
		?>
			<span class="category-separator">
				-
			</span>
			<span class="category-description">
		<?php
			if ($wrightHorizontalLinkedDescriptions) :
		?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<?php
			endif;
			echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content');
			if ($wrightHorizontalLinkedDescriptions) :
		?>
			</a>
		<?php
			endif;
		?>
			</span>
		<?php
		endif;
		if($params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0) || ($params->get('maxlevel') >= ($item->level - $startLevel))) && count($item->getChildren()))
		{

			echo '<ul class="nav nav-list">';  // Wright v.3: Added nav nav-list classes
			$temp = $list;
			$list = $item->getChildren();
			require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default').'_items');
			$list = $temp;
			echo '</ul>';
		}
		?>
 </div>
 <?php if ($c % $wrightMaxColumns == ($wrightMaxColumns-1) || (count($list)-1) == $c): ?>
	</div>
<?php endif; ?>
 <?php
	$c = $c + 1;
?>
<?php }
 else
 	{
	/* End Wright v.3: If horizontal display is enabled, displays categories showing category image (when available) and in horizontal / column layout */
?>
	<li <?php if ($_SERVER['PHP_SELF'] == JRoute::_(ContentHelperRoute::getCategoryRoute($item->id))) echo ' class="active"';?>> <?php $levelup = $item->level - $startLevel - 1; ?>
  <h<?php echo $params->get('item_heading') + $levelup; ?>>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<i class="icon-folder-open"></i>  <?php // Wright v.3: Added icon ?>
		<?php echo $item->title;?><?php if($params->get('numitems')): ?>
			(<?php echo $item->numitems; ?>)
		<?php endif; ?></a>
   </h<?php echo $params->get('item_heading') + $levelup; ?>>

		<?php
		if ($params->get('show_description', 0))
		{
			echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content');
		}
		if ($params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0) || ($params->get('maxlevel') >= ($item->level - $startLevel))) && count($item->getChildren()))
		{

			echo '<ul class="nav nav-list">';  // Wright v.3: Added nav nav-list classes
			$temp = $list;
			$list = $item->getChildren();
			require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default').'_items');
			$list = $temp;
			echo '</ul>';
		}
		?>
 </li>
<?php } // Wright v.3: If horizontal display is enabled, displays categories showing category image (when available) and in horizontal / column layout */
 ?>
<?php endforeach; ?>
