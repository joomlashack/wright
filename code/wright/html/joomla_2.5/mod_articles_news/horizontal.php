<?php
// Wright v.3 Override: Joomla 2.5.16
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_category
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

?>

<ul class="newsflash-horiz<?php echo $params->get('moduleclass_sfx') . "unstyled row-fluid"; // Wright v.3: Added row-fluid  class ?>">
<?php for ($i = 0, $n = count($list); $i < $n; $i ++) :
	$item = $list[$i]; ?>
	<li class="span3"> <?php // Wright v.3: Added span3 class for 4 columns ?>
	<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item');

	if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) : ?>

	<span class="article-separator">&#160;</span>

	<?php endif; ?>
	</li>
<?php endfor; ?>
</ul>
