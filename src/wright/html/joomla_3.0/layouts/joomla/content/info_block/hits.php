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
<dd class="hits">
	<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $displayData['item']->hits; ?>" />
	<span class="icon-eye"></span>
	<?php echo '<span class="hidden-phone"> ' . JText::sprintf('COM_CONTENT_ARTICLE_HITS', $displayData['item']->hits) . '</span>';  // Wright v.3: Non-mobile version
	echo '<span class="visible-phone"> ' . JText::sprintf($displayData['item']->hits) . '</span>';  // Wright v.3: Mobile version
	?>
</dd>
