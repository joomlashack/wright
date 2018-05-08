<?php
// Wright v.3 Override: Joomla 3.2
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* Wright v.3: Read parameters like columns or others */
$wrightMaxColumns = (isset($wrightMaxColumns) ? $wrightMaxColumns : 4);  // Wright v.3: Max columns to be used
if ($wrightMaxColumns > 6) {
	$wrightMaxColumns = 6;
}
elseif ($wrightMaxColumns == 5) {
	$wrightMaxColumns = 6;
}
$span = (12 / $wrightMaxColumns);

$wrightDivideRows = isset($wrightDivideRows) ? $wrightDivideRows : false;

$wrightProcessSecondRow = false;
$wrightTempShowImage = $params->get('image', 0);
$wrightTempShowTitle = $params->get('item_title', 0);
$wrightTempEnableIntroText = isset($wrightEnableIntroText) ? $wrightEnableIntroText : 0;
$wrightTempReadMore = $params->get('readmore', 0);

$wrightGeneralClass = isset($wrightGeneralClass) ? $wrightGeneralClass : '';

$wrightDivideRowsContainer1 = isset($wrightDivideRowsContainer1) ? $wrightDivideRowsContainer1 : '';
$wrightDivideRowsContainer2 = isset($wrightDivideRowsContainer2) ? $wrightDivideRowsContainer2 : '';

/* Wright v.3: Read parameters like columns or others */

$wrightEnableLinkContent = (isset($wrightEnableLinkContent) ? $wrightEnableLinkContent : false);  // Wright v.3: Enable Link in content parameter

$c = 0; // Wright v.3: Counter variable to get horizontal columns (set by $wrightMaxColumns)
?>

<div class="newsflash-horiz<?php echo $params->get('moduleclass_sfx'); // Wright v.3: Changed ul for div element ?><?php if ($wrightGeneralClass != '') : ?> <?php echo $wrightGeneralClass; endif; // Wright v.3: Added optional general class ?>">
	<?php for ($i = 0, $n = count($list); $i < $n; $i ++) :
		$item = $list[$i]; ?>

		<?php // Wright v.3: Added row-fluid for each horizontal set of columns ?>
			<?php if ($c % $wrightMaxColumns ==  0):
					$rowcounter = 1;  // Wright v.3: Row counter
					if ($wrightDivideRows) : ?>
					<?php if (!$wrightProcessSecondRow) : ?>
					<?php if ($wrightDivideRowsContainer1 != '') : ?>
					<div class="<?php echo $wrightDivideRowsContainer1 ?>">
					<?php endif; ?>
					<?php
							$wrightProcessSecondRow = false;
							$params->set('item_title', 0);
							$params->set('readmore', 0);
							$wrightEnableIntroText = 0;
							$params->set('image', $wrightTempShowImage);
						else :
					?>
					<?php if ($wrightDivideRowsContainer2 != '') : ?>
					<div class="<?php echo $wrightDivideRowsContainer2 ?>">
					<?php endif; ?>
					<?php
							$params->set('item_title', $wrightTempShowTitle);
							$params->set('readmore', $wrightTempReadMore);
							$wrightEnableIntroText = $wrightTempEnableIntroText;
							$params->set('image', 0);
						endif;
					endif;
				?>
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
				<?php if ($wrightDivideRows) : ?>
					<?php if ($wrightProcessSecondRow) : ?>
						<?php if ($wrightDivideRowsContainer2 != '') : ?>
						</div>
						<?php endif; ?>
					<?php else : ?>
						<?php if ($wrightDivideRowsContainer1 != '') : ?>
						</div>
						<?php endif; ?>
					<?php endif; ?>
				<?php
						if (!$wrightProcessSecondRow)
						{
							$i -= $rowcounter;
							$c -= $rowcounter;
							$wrightProcessSecondRow = true;
						}
						else
						{
							$wrightProcessSecondRow = false;
						}
					endif;
				?>
			<?php endif; ?>

			<?php
				$c = $c + 1;
				$rowcounter++; // Wright v.3: Row counter
			?>
		<?php /* End Wright v.3: Close row-fluid */ ?>

	<?php endfor; ?>
</div> <?php // Wright v.3: Changed ul for div element ?>
