<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_categories
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$wrightHorizontal = (isset($wrightHorizontal) ? $wrightHorizontal : false);  // Wright v.3: Enable position horizontal parameter

?>
<?php if (!$wrightHorizontal) : // Wright v.3: Removed ul when used horizontal layout ?>
<ul class="categories-module<?php echo $moduleclass_sfx . ' unstyled'; ?>">  <?php // Wright v.3: Added nav nav-list classes ?>
<?php endif; // Wright v.3: Removed ul when used horizontal layout ?>
<?php
require JModuleHelper::getLayoutPath('mod_articles_categories', $params->get('layout', 'default').'_items');
?><?php if (!$wrightHorizontal) : // Wright v.3: Removed ul when used horizontal layout ?></ul>
<?php endif; // Wright v.3: Removed ul when used horizontal layout ?>
