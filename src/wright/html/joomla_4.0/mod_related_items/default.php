<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_related_items
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="relateditems<?php echo $moduleclass_sfx; ?> nav flex-column">  <?php // Wright v.4: Added nav flex-column classes ?>
	<?php foreach ($list as $item) :	?>
		<li class="nav-item">
			<a href="<?php echo $item->route; ?>" class="nav-link">
				<?php if ($showDate) echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC4')). " - "; ?>
				<i class="far fa-file"></i>  <?php // Wright v.4: Added icon ?>
				<?php echo $item->title; ?></a>
		</li>
	<?php endforeach; ?>
</ul>
