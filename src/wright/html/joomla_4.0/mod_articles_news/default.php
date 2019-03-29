<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
?>
<ul class="mod-articlesnews newsflash nav flex-column"> <?php // Wright v.4: Added classes nav flex-column ?>
	<?php foreach ($list as $item) : ?>
		<li class="nav-item">
			<?php require ModuleHelper::getLayoutPath('mod_articles_news', '_item'); ?>
		</li>
	<?php endforeach; ?>
</ul>
