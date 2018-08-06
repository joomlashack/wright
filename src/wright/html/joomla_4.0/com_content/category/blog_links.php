<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>


<div class="items-more">
<h3><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></h3><?php // Wright v.4: added "more articles" text ?>
	<div class="list-group">
	<?php
		foreach ($this->link_items as &$item) :
	?>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>" class="list-group-item list-group-item-action">
			<?php echo $item->title; ?>
		</a>
	<?php endforeach; ?>
	</div>
</div>
