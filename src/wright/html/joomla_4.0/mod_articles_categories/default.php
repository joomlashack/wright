<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$wrightHorizontal = (isset($wrightHorizontal) ? $wrightHorizontal : false);  // Wright v.4: Enable position horizontal parameter

?>
<?php if (!$wrightHorizontal) : // Wright v.4: Removed ul when used horizontal layout ?>
<ul class="categories-module<?php echo $moduleclass_sfx . ' unstyled'; ?> nav flex-column">  <?php // Wright v.4: Added nav flex-column classes ?>
<?php endif; // Wright v.4: Removed ul when used horizontal layout ?>
<?php
require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default').'_items');
?><?php if (!$wrightHorizontal) : // Wright v.4: Removed ul when used horizontal layout ?></ul>
<?php endif; // Wright v.4: Removed ul when used horizontal layout ?>
