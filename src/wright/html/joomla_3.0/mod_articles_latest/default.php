<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="latestnews<?php echo $moduleclass_sfx; ?><?php if ($wrightAddNavs) : ?> nav nav-list<?php endif; ?>">  <?php // Wright v.3: Added optional nav nav-list classes ?>
<?php foreach ($list as $item) :  ?>
	<li>
		<a href="<?php echo $item->link; ?>">
			<?php
				/* Wright v.3: Add icon (optional) */
				if ($wrightAddIcon)
					:
			?>
				<i class="icon-file"></i>
			<?php
				endif;
				/* End Wright v.3: Add icon (optional) */
			?>
			<?php echo $item->title; ?></a>
	</li>
<?php endforeach; ?>
</ul>
