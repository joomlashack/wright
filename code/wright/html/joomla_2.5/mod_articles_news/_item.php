<?php
// Wright v.3 Override: Joomla 2.5.18
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

$wrightNewsEnableIcons = (isset($wrightNewsEnableIcons) ? $wrightNewsEnableIcons : true);  // Wright v.3: Enable icons parameter

$wrightEnableIntroText = (isset($wrightEnableIntroText) ? $wrightEnableIntroText : true);  // Wright v.3: Enable intro text parameter

$wrightTitlePosition = (isset($wrightTitlePosition) ? $wrightTitlePosition : 'above');  // Wright v.3: Title Position (above/below) parameter

$wrightImageFirst = (isset($wrightImageFirst) ? $wrightImageFirst : false);  // Wright v.3: Enable Link in content parameter

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
				<div class="page-header"> <?php // Wright v.3: Added link onclick en all content ?>
					<a href="<?php echo $item->link;?>">
						<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
						<?php echo $item->title;?>
					</a>
				</div>  <?php // Wright v.3: Added page-header style ?>
			<?php else : ?>
				<div class="page-header">  <?php // Wright v.3: Added page-header style ?>
					<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
					<?php echo $item->title; ?>
				</div>  <?php // Wright v.3: Added page-header style ?>
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

<?php if ($wrightTitlePosition == 'below') : ?> <?php /* Wright v.3: Added title below */ ?>

	<?php if ($params->get('item_title')) : ?>

		<<?php echo $item_heading; ?> class="newsflash-title<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($params->get('link_titles') && $item->link != '') : ?>
				<div class="page-header"> <?php // Wright v.3: Added link onclick en all content ?>
					<a href="<?php echo $item->link;?>">
						<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
						<?php echo $item->title;?>
					</a>
				</div>  <?php // Wright v.3: Added page-header style ?>
			<?php else : ?>
				<div class="page-header">  <?php // Wright v.3: Added page-header style ?>
					<?php if ($wrightNewsEnableIcons) : ?> <i class="icon-file"></i>  <?php endif; // Wright v.3: Added icon ?>
					<?php echo $item->title; ?>
				</div>  <?php // Wright v.3: Added page-header style ?>
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
	$fileHover=$imgt[0].'-hover.'.$fileExtention[1];

	if (file_exists($fileHover)) {
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


