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

$wrightImageFirst = (isset($wrightImageFirst) ? $wrightImageFirst : true);  // Wright v.3: Enable Link in content parameter

$wrightUsePageHeader = (isset($wrightUsePageHeader) ? $wrightUsePageHeader : true);  // Wright v.3: Use a page header

$wrightDisplayAuthor = (isset($wrightDisplayAuthor) ? $wrightDisplayAuthor : false);  // Wright v.3: Display the author

$wrightDisplayPublishedDate = (isset($wrightDisplayPublishedDate) ? $wrightDisplayPublishedDate : false);  // Wright v.3: Display the published date

// no direct access
defined('_JEXEC') or die;
$item_heading = $params->get('item_heading', 'h4');
?>
<?php
	// Wright v.3: Added imge if show firts image is true
	if($wrightImageFirst):
		$images = json_decode($item->images);
		if ($params->get('image','1')) :
			if (isset($images->image_intro) and !empty($images->image_intro)) :
?>
				<div class="img-intro-left">
					<a href="<?php echo $item->link;?>">
						<img src="<?php echo $images->image_intro; ?>"  id="<?php echo $item->id; ?>" alt="<?php echo $images->image_intro_alt; ?>" />
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
		$images = json_decode($item->images);
		if ($params->get('image','1')) :
			if (isset($images->image_intro) and !empty($images->image_intro)) :
?>
				<div class="img-intro-left">
					<a href="<?php echo $item->link;?>">
						<img src="<?php echo $images->image_intro; ?>" class="" alt="<?php echo $images->image_intro_alt; ?>" />
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
	echo '<p class="readmore"><a class="readmore" href="'.$item->link.'">'.$item->linkText.'</a></p>';  // Wright v.3:  Added p.readmore
endif; ?>

<?php
	// Wright v.3: Changing image intro on hover if exist file -hover
	$fileExtention=explode(".",$images->image_intro);
	preg_match('/[^\.]+/',$images->image_intro, $imgt);
	if(isset($imgt[0])) {
		$fileHover=$imgt[0].'-hover.'.$fileExtention[1];
	}	

	if (isset($fileHover)) {
		    echo '<script type="text/javascript">
	jQuery(document).ready(function($) {
		var srcHover = jQuery("#'.$item->id.'").attr("src").match(/[^\.]+/) + "-hover.'.$fileExtention[1].'";
		var src = jQuery("#'.$item->id.'").attr("src").replace("-hover.png", ".'.$fileExtention[1].'");

		jQuery("#'.$item->id.'").after(\'<img src="\'+srcHover+\'" id="hover-'.$item->id.'" style="display:none">\');

	    jQuery("#'.$item->id.'").parent().parent().parent()
	        .hover(function() {	            
	            jQuery("#'.$item->id.'").hide();
	            jQuery("#hover-'.$item->id.'").show();
	        },
		    function () {
	            jQuery("#'.$item->id.'").show();
	            jQuery("#hover-'.$item->id.'").hide();
	        }).on("click touchend", function() {
		        location.href="'.$item->link .'";
		    });  
	});
	</script>';
	}
	// End Wright v.3: Changing image intro on hover if exist file -hover
?>