<?php
// Wright v.3 Override: Joomla 2.5.18
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_categories
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
$wrightMaxColumns = (isset($wrightMaxColumns) ? $wrightMaxColumns : 3);  // Wright v.3: Max columns to be used
// no direct access
defined('_JEXEC') or die;
/* Wright v.3: Grab parameter for max column number, setting it to one of the allowed Bootstrap values */
if ($wrightMaxColumns > 6) {
	$wrightMaxColumns = 6;
}
elseif ($wrightMaxColumns == 5) {
	$wrightMaxColumns = 6;
}
$span = (12 / $wrightMaxColumns);
/* End Wright v.3: Grab parameter for max column number */

$c = 0; // Wright v.3: Counter variable to get horizontal columns (set by $wrightMaxColumns)
$n = 0;
foreach ($list as $item) :
?>
<?php if($wrightHorizontal){ ?>
<?php if ($c % $wrightMaxColumns ==  0):?>
	<div class="row-fluid">
<?php endif; ?>
<div class="span<?php echo $span ?>" <?php if ($_SERVER['PHP_SELF'] == JRoute::_(ContentHelperRoute::getCategoryRoute($item->id))) echo ' class="active"';?>> <?php $levelup=$item->level-$startLevel -1; ?>
  <?php if($item->getParams()->get('image')){  ?>
  	<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<img src="<?php echo $item->getParams()->get('image'); ?>" class="img-block">
	</a>
 <?php } ?>
  <h<?php echo $params->get('item_heading')+ $levelup; ?>>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
		<?php echo $item->title;?></a>
   </h<?php echo $params->get('item_heading')+ $levelup; ?>>

		<?php
		if($params->get('show_description', 0))
		{
			echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content');
		}
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
 <?php if ($c % $wrightMaxColumns ==  ($wrightMaxColumns-1) || $c == $n - 1): ?>
	</div>
<?php endif; ?>
 <?php
	$c = $c + 1;
?>
<?php }else{ ?>
<li <?php if ($_SERVER['PHP_SELF'] == JRoute::_(ContentHelperRoute::getCategoryRoute($item->id))) echo ' class="active"';?>> <?php $levelup=$item->level-$startLevel -1; ?>
  <h<?php echo $params->get('item_heading')+ $levelup; ?>>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
			<i class="icon-folder-open"></i>  <?php // Wright v.3: Added icon ?>
		<?php echo $item->title;?>jjj</a>
   </h<?php echo $params->get('item_heading')+ $levelup; ?>>

		<?php
		if($params->get('show_description', 0))
		{
			echo JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content');
		}
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
 </li>
<?php } ?>
<?php endforeach; ?>
