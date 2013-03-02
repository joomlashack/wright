<?php
// Wright v.3 Override: Joomla 3.0.3
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="items-more<?php echo " well"; // Wright v.3: More articles ?>">
<h3><?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></h3><?php // Wright v.3: added "more articles" text ?>
<ol class="nav nav-list<?php // Wright v.3: replaced nav-stacked for nav-list ?>"><?php foreach ($this->link_items as &$item) : ?>
	<li>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>">
			<?php echo $item->title; ?></a>
	</li>
<?php endforeach; ?>
</ol>
