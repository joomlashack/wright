<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<?php if ($params->get('item_title')) : ?>

	<?php $item_heading = $params->get('item_heading', 'h4'); ?>
	<<?php echo $item_heading; ?> class="newsflash-title">
	<?php if ($item->link !== '' && $params->get('link_titles')) : ?>
		<a href="<?php echo $item->link; ?>" class="nav-link">
			<i class="icon-file"></i> <?php // Wright v.4: Added icon ?>
			<?php echo $item->title; ?>
		</a>
	<?php else : ?>
		<i class="icon-file"></i> <?php // Wright v.4: Added icon ?>
		<?php echo $item->title; ?>
	<?php endif; ?>
	</<?php echo $item_heading; ?>>
<?php endif; ?>

<?php if (!$params->get('intro_only')) : ?>
	<?php echo $item->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $item->beforeDisplayContent; ?>

<?php if ($params->get('show_introtext', '1')) : ?>
	<div class="nav-link">
		<?php echo $item->introtext; ?>
	</div>
<?php endif; ?>

<?php echo $item->afterDisplayContent; ?>

<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
	<div class="nav-link">
		<?php echo '<a class="btn btn-secondary" href="' . $item->link . '">' . $item->linkText . '</a>'; ?>
	</div>
<?php endif; ?>