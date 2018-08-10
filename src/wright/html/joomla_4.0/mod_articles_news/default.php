<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
?>
<div class="mod-articlesnews newsflash">
	<?php foreach ($list as $item) : ?>
		<?php require ModuleHelper::getLayoutPath('mod_articles_news', '_item'); ?>
	<?php endforeach; ?>
</div>
