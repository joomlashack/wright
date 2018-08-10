<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?><?php if ($wrightAddNavs) : ?> nav flex-column<?php endif; ?>">  <?php // Wright v.4: Added optional nav flex-column classes ?>
<?php foreach ($list as $item) :  ?>
	<li class="nav-item">
		<a href="<?php echo $item->link; ?>" class="nav-link">
			<?php
				/* Wright v.4: Add icon (optional) */
				if ($wrightAddIcon)
					:
			?>
				<i class="icon-file"></i>
			<?php
				endif;
				/* End Wright v.4: Add icon (optional) */
			?>
			<?php echo $item->title; ?></a>
	</li>
<?php endforeach; ?>
</ul>
