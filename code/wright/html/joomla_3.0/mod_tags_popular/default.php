<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_tags_popular
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<?php JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php'); ?>
<div class="tagspopular<?php echo $moduleclass_sfx; ?>">
<?php if (!count($list)) : ?>
	<div class="alert alert-no-items"><?php echo JText::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
<?php else : ?>
<ul class="nav nav-list" > <?php // Wright v.3: nav-list ?>
	<?php foreach ($list as $item) : ?>
	<li><?php $route = new TagsHelperRoute; ?>
		<a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($item->tag_id . '-' . $item->alias)); ?>">
		<i class="icon-tag icons-left"></i>  <?php // Wright v.3: Added icon ?>
			<?php echo htmlspecialchars($item->title); ?></a>
		<?php if ($display_count) : ?>
			<span class="tag-count badge badge-info"><?php echo $item->count; ?></span>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>
