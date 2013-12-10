<?php
// Wright v.3 Override: Joomla 2.5.16
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

?>

<?php
	$cont = 0; // Wright v.3: Added cont variable for close row-fluid element
?>

<?php // Wright v.3: ?>

	<div class="newsflash-horiz<?php echo $params->get('moduleclass_sfx'); // Wright v.3: Changed ul for div element ?>">
		<?php for ($i = 0, $n = count($list); $i < $n; $i ++) :
			$item = $list[$i]; ?>

			<?php // Wright v.3: ?>
				<?php if ($cont % 4 ==  0):?>
					<div class="row-fluid">
				<?php endif; ?>
			<?php // End Wright v.3: Added row-fluid wrapp ?>

			<?php // Wright v.3: ?>
				<div class="span3">

					<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item');

					if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) : ?>

						<span class="article-separator">&#160;</span>

					<?php endif; ?>

				</div>
			<?php // End Wright v.3: Added span3 class for 4 columns ?>

			<?php // Wright v.3: ?>

				<?php if ($cont % 4 ==  3 || $cont == $n - 1): ?>
					</div>
				<?php endif; ?>

				<?php
					$cont = $cont + 1;
				?>

			<?php // End Wright v.3: Added close of row-fluid wrapp and  increase $cont variable ?>

		<?php endfor; ?>
	</div>

<?php // End Wright v.3: Changed structure list for flex grid of Bootstrap ?>

