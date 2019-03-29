<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tags_popular
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
?>

<div class="mod-tagspopular tagspopular">
	<?php if (!count($list)) : ?>
		<joomla-alert type="info"><?php echo Text::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></joomla-alert>
	<?php else : ?>
		<ul class="nav flex-column">
			<?php foreach ($list as $item) : ?>
				<li class="nav-item">
					<a href="<?php echo Route::_(TagsHelperRoute::getTagRoute($item->tag_id . ':' . $item->alias)); ?>"
						class="nav-link">
						<?php echo htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8'); ?>
						<?php if ($display_count) : ?>
							<span class="tag-count badge badge-info"><?php echo $item->count; ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
