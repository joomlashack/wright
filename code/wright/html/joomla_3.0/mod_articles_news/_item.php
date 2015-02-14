<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

$wrightNewsEnableIcons = (isset($wrightNewsEnableIcons) ? $wrightNewsEnableIcons : true);  // Wright v.3: Enable icons parameter

$wrightEnableIntroText = (isset($wrightEnableIntroText) ? $wrightEnableIntroText : true);  // Wright v.3: Enable intro text parameter

$wrightTitlePosition = (isset($wrightTitlePosition) ? $wrightTitlePosition : 'above');  // Wright v.3: Title Position (above/below) parameter

$wrightImageFirst = (isset($wrightImageFirst) ? $wrightImageFirst : false);  // Wright v.3: Enable Link in content parameter

$wrightUsePageHeader = (isset($wrightUsePageHeader) ? $wrightUsePageHeader : true);  // Wright v.3: Use a page header

$wrightDisplayAuthor = (isset($wrightDisplayAuthor) ? $wrightDisplayAuthor : false);  // Wright v.3: Display the author

$wrightDisplayPublishedDate = (isset($wrightDisplayPublishedDate) ? $wrightDisplayPublishedDate : false);  // Wright v.3: Display the published date

$wrightItemContainer = (isset($wrightItemContainer) ? $wrightItemContainer : false); // Wright v.3: Item wrapper

// no direct access
defined('_JEXEC') or die;
$item_heading = $params->get('item_heading', 'h4');

// Wright v.3: Changing image intro on hover if file -hover exists
$images = json_decode($item->images);
$introFiles = explode(".", $images->image_intro);
$hoverImage = '';

if ($images->image_intro != '')
{
	$ext = pathinfo($images->image_intro, PATHINFO_EXTENSION);
	$hoverImage = substr($images->image_intro, 0, strlen($images->image_intro) - strlen($ext) - 1) . '-hover.' . $ext;

	if (!file_exists($hoverImage))
	{
		$hoverImage = '';
	}
}
// End Wright v.3: Changing image intro on hover if file -hover exists

?>

<?php if($wrightItemContainer):	// Wright v.3: Item wrapper ?>
	<div class="item-container">
<?php endif; ?>

<?php
	// Wright v.3: Added imge if show firts image is true
	if($wrightImageFirst):
		if ($params->get('image','1')) :
			if (isset($images->image_intro) and !empty($images->image_intro)) :
?>
				<div class="img-intro-left">
					<a href="<?php echo $item->link;?>">
						<img src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>"<?php if ($hoverImage != '') : ?> class="wrightHoverNewsflash" data-wrighthover="<?php echo $hoverImage ?>" data-wrighthoverorig="<?php echo $images->image_intro; ?>"<?php endif; ?> />
					</a>
				</div>
<?php
			endif;
		endif;
	endif;
	// End Wright v.3: Added imge if show firts image is true
?>
<?php if ($wrightTitlePosition == 'above') : ?> <?php /* Wright v.3: Added title above */ ?>
	<?php if ($params->get('item_title')) : ?>
		<<?php echo $item_heading; ?> class="newsflash-title<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($params->get('link_titles') && $item->link != '') : ?>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				<div class="page-header">
				<?php endif;  // End Wright v.3 Added page header ?>
					<a href="<?php echo $item->link;?>">
						<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
						<?php echo $item->title;?>
					</a>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				</div>
				<?php endif;  // End Wright v.3 Added page header ?>
			<?php else : ?>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				<div class="page-header">
				<?php endif;  // End Wright v.3 Added page header ?>
					<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
					<?php echo $item->title; ?>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				</div>
				<?php endif;  // End Wright v.3 Added page header ?>
			<?php endif; ?>
		</<?php echo $item_heading; ?>>

	<?php endif; ?>

<?php endif; ?> <?php /* End Wright v.3: Added title above */ ?>

<?php
	/* Wright v.3: Added intro image */
	if(!$wrightImageFirst):
		if ($params->get('image','1')) :
			if (isset($images->image_intro) and !empty($images->image_intro)) :
?>
				<div class="img-intro-left">
					<a href="<?php echo $item->link;?>">
						<img src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>"<?php if ($hoverImage != '') : ?> class="wrightHoverNewsflash" data-wrighthover="<?php echo $hoverImage ?>" data-wrighthoverorig="<?php echo $images->image_intro; ?>"<?php endif; ?> />
					</a>
				</div>
<?php
			endif;
		endif;
	endif;
	/* End Wright v.3: Added intro image */
?>

<?php if (!$params->get('intro_only')) :
	echo $item->afterDisplayTitle;
endif; ?>

<?php echo $item->beforeDisplayContent; ?>

<?php
	/* Wright v.3: Added intro text */
	if ($wrightEnableIntroText) :
		echo $item->introtext;
	endif;
	/* End Wright v.3: Added intro text */
?>

<?php
	// publish_up
	// Wright v.3: Display author and published date
	if ($wrightDisplayAuthor && $item->author != '')
		:
?>
	<span class="wright-newsflash-author">
		<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $item->author) ?>.
	</span>
<?php
	endif;

	if ($wrightDisplayPublishedDate && $item->publish_up != '')
		:
?>
	<span class="wright-newsflash-publish-up">
		<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC2'))) ?>.
	</span>
<?php
	endif;
	// End Wright v.3: Display author and published date
?>

<?php if ($wrightTitlePosition == 'below') : ?> <?php /* Wright v.3: Added title below */ ?>

	<?php if ($params->get('item_title')) : ?>

		<<?php echo $item_heading; ?> class="newsflash-title<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($params->get('link_titles') && $item->link != '') : ?>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				<div class="page-header">
				<?php endif;  // End Wright v.3 Added page header ?>
					<a href="<?php echo $item->link;?>">
						<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
						<?php echo $item->title;?>
					</a>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				</div>
				<?php endif;  // End Wright v.3 Added page header ?>
			<?php else : ?>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				<div class="page-header">
				<?php endif;  // End Wright v.3 Added page header ?>
					<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
					<?php echo $item->title; ?>
				<?php if ($wrightUsePageHeader) : // Wright v.3 Added page header ?>
				</div>
				<?php endif;  // End Wright v.3 Added page header ?>
			<?php endif; ?>
		</<?php echo $item_heading; ?>>

	<?php endif; ?>

<?php endif; ?> <?php /* End Wright v.3: Added title below */ ?>

<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) :
	// Wright v.3:  Added p.readmore
	echo '<p class="readmore"><a class="readmore" href="'.$item->link.'">'.$item->linkText.'</a></p>';
endif; ?>
<?php if($wrightItemContainer):	// Wright v.3: Item wrapper ?>
	</div>
<?php endif; ?>