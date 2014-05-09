<?php
// Wright v.3 Override: Joomla 2.5.18
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_categories
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/* Wright v.3: Grab parameter for max column number, setting it to one of the allowed Bootstrap values */
$wrightMaxColumns = (isset($wrightMaxColumns) ? $wrightMaxColumns : 4);  // Wright v.3: Max columns to be used
	/* Wright v.3: Added configuration horizontal/vertical */

		$wrightOrientationList = (isset($wrightOrientationList) ? $wrightOrientationList : 'vertical');  // Wright v.3: Max columns to be used
		if($wrightOrientationList = 'vertical'){
			$wrightMaxColumns = 12;
		}

	/* Wright v.3: End Added configuration horizontal/vertical */
if ($wrightMaxColumns > 6) {
	$wrightMaxColumns = 6;
}
elseif ($wrightMaxColumns == 5) {
	$wrightMaxColumns = 6;
}
$span = (12 / $wrightMaxColumns);
/* End Wright v.3: Grab parameter for max column number */


/* Wright v.3: Added icon */
$wrightEnableIcons = (isset($wrightEnableIcons) ? $wrightEnableIcons : true);  // Wright v.3: Enable icons parameter
/* End Wright v.3: Added icon */


$c = 0; // Wright v.3: Counter variable to get horizontal columns (set by $wrightMaxColumns)

for ($i = 0, $n = count($list); $i < $n; $i ++) :
$item = $list[$i];

?>

		<?php // Wright v.3: Added row-fluid for each horizontal set of columns ?>
			<?php if ($c % $wrightMaxColumns ==  0):?>
				<div class="row-fluid">
			<?php endif; ?>
		<?php // End Wright v.3: Added row-fluid for each horizontal set of columns ?>


	<?php // Wright v.3: Added span class for each column ?>
		<div class="span<?php echo $span; if ($_SERVER['PHP_SELF'] == JRoute::_(ContentHelperRoute::getCategoryRoute($item->id))) echo ' active';?>"> <?php $levelup=$item->level-$startLevel -1; ?>

			<?php // Wright v.3: Added image of Category ?>
				<?php if ($item->getParams()->get('image')) : ?>
					<img src="<?php echo $item->getParams()->get('image'); ?>" class='img-block'>
				<?php endif; ?>
			<?php // End Wright v.3: Added image of Category  ?>

			<h<?php echo $params->get('item_heading')+ $levelup; ?>>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
					<?php if($wrightEnableIcons) : ?><i class="icon-folder-open"></i>  <?php endif; // Wright v.3: Added icon ?>
					<?php echo $item->title;?>
					<?php // Wright v.3: Added description inline with title
						if($params->get('show_description', 0))
						{
							echo '<small>' .  JHtml::_('content.prepare', $item->description, $item->getParams(), 'mod_articles_categories.content') . '</small>';
						}
					// End Wright v.3: Added description inline with title ?>
				</a>

			</h<?php echo $params->get('item_heading')+ $levelup; ?>>

			<?php if ($params->get('show_description', 1)) : ?>
				<?php
				if($params->get('show_children', 0) && (($params->get('maxlevel', 0) == 0) || ($params->get('maxlevel') >= ($item->level - $startLevel))) && count($item->getChildren()))
				{

					echo '<div class="nav nav-list">';  // Wright v.3: Added nav nav-list classes
					$temp = $list;
					$list = $item->getChildren();
					require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default').'_items');
					$list = $temp;
					echo '</div>';
				}
				?>
			<?php endif; ?>

		</div>
	<?php // Wright v.3: Added span class for each column ?>
	<?php /* Wright v.3: Close row-fluid */ ?>

		<?php if ($c % $wrightMaxColumns ==  ($wrightMaxColumns-1) || $c == $n - 1): ?>
			</div>
		<?php endif; ?>

		<?php
			$c = $c + 1;
		?>
	<?php /* End Wright v.3: Close row-fluid */ ?>
<?php endfor; ?>








