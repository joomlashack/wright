<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Router\Route;

?>
			<dd class="parent-category-name">
				<span class="far fa-folder"></span> <?php // Wright v.4: Changed icon ?>
				<?php $title = $this->escape($displayData['item']->parent_title);
				$url = '<a href="' . Route::_(
                        ContentHelperRoute::getCategoryRoute($displayData['item']->parent_id, $displayData['item']->parent_language)
                    )
                    . '">'.$title.'</a>';?>
				<?php if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_id)) : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', $url);  // Wright v.4: Non-mobile version
					?>
				<?php else : ?>
					<?php echo JText::sprintf('COM_CONTENT_PARENT', $title);  // Wright v.4: Non-mobile version
					?>
				<?php endif; ?>
			</dd>
