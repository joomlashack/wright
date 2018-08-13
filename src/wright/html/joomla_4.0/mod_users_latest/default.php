<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_users_latest
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if (!empty($names)) : ?>
	<ul class="latestusers<?php echo $moduleclass_sfx ?> nav flex-column">  <?php // Wright v.4: Added nav flex-column classes ?>
	<?php foreach ($names as $name) : ?>
		<li class="nav-item">
			<span class="nav-link">
				<i class="icon-user"></i>  <?php // Wright v.4: Added icon ?>
				<?php echo $name->username; ?>
			</span>
		</li>
	<?php endforeach;  ?>
	</ul>
<?php endif; ?>
