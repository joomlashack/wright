<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

?>
<dd class="create">
	<span class="icon-calendar-plus-o"></span> <?php // Wright v.3: Changed icon ?>
	<?php echo '<span class="hidden-phone"> ' . JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $displayData['item']->created, JText::_('DATE_FORMAT_LC3'))) . '</span>';  // Wright v.3: Non-mobile version
		echo '<span class="visible-phone"> ' . JText::sprintf(JHtml::_('date', $displayData['item']->created, JText::_('DATE_FORMAT_LC3'))) . '</span>';  // Wright v.3: Mobile version
	?>
</dd>
