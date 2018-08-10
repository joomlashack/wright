<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_archive
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if (!empty($list)) :?>
	<div class="archive-module<?php echo $moduleclass_sfx; ?> list-group">  <?php // Wright v.4: Added list-group class ?>
		<?php foreach ($list as $item) : ?>
			<a href="<?php echo $item->link; ?>" class="list-group-item"> <?php // Wright v.4: Added list-group-item class ?>
				<i class="icon-calendar"></i>  <?php // Wright v.4: Added Icon ?>
				<?php echo $item->text; ?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
