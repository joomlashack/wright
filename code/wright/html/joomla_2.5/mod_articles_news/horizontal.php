<?php
// Wright v.3 Override: Joomla 2.5.18
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/* Wright v.3: Grab parameter for max column number, setting it to one of the allowed Bootstrap values */
$wrightMaxColumns = (isset($wrightMaxColumns) ? $wrightMaxColumns : 4);  // Wright v.3: Max columns to be used
if ($wrightMaxColumns > 6) {
	$wrightMaxColumns = 6;
}
elseif ($wrightMaxColumns == 5) {
	$wrightMaxColumns = 6;
}
$span = (12 / $wrightMaxColumns);
/* End Wright v.3: Grab parameter for max column number */
$wrightEnableLinkContent = (isset($wrightEnableLinkContent) ? $wrightEnableLinkContent : false);  // Wright v.3: Enable Link in content parameter


$c = 0; // Wright v.3: Counter variable to get horizontal columns (set by $wrightMaxColumns)
?>

<div class="newsflash-horiz<?php echo $params->get('moduleclass_sfx'); // Wright v.3: Changed ul for div element ?>">
	<?php for ($i = 0, $n = count($list); $i < $n; $i ++) :
		$item = $list[$i]; ?>

		<?php // Wright v.3: Added row-fluid for each horizontal set of columns ?>
			<?php if ($c % $wrightMaxColumns ==  0):?>
				<div class="row-fluid">
			<?php endif; ?>
		<?php // End Wright v.3: Added row-fluid for each horizontal set of columns ?>

			<div class="span<?php echo $span ?>" <?php echo $wrightEnableLinkContent ? 'style="cursor:pointer" onclick="location.href=\'' . $item->link . '\'"' : '' ?>> <?php // Wright v.3: Added span class for each column ?>
				<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item');

				if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) : ?>
					<span class="article-separator">&#160;</span>
				<?php endif; ?>

			</div> <?php // Wright v.3: Added span3 class for each column ?>
		<?php /* Wright v.3: Close row-fluid */ ?>

			<?php if ($c % $wrightMaxColumns ==  ($wrightMaxColumns-1) || $c == $n - 1): ?>
				</div>
			<?php endif; ?>

			<?php
				$c = $c + 1;
			?>
		<?php /* End Wright v.3: Close row-fluid */ ?>

	<?php endfor; ?>
</div> <?php // Wright v.3: Changed ul for div element ?>