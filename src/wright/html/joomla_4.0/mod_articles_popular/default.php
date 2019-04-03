<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_popular
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="mostread<?php echo $moduleclass_sfx; ?> nav flex-column">  <?php // Wright v.4: Added nav flex-column classes ?>
<?php foreach ($list as $item) : ?>
	<li class="nav-item">
		<a href="<?php echo $item->link; ?>" class="nav-link">
			<i class="fas fa-file"></i>  <?php // Wright v.4: Added icon ?>
			<?php echo $item->title; ?></a>
	</li>
<?php endforeach; ?>
</ul>
