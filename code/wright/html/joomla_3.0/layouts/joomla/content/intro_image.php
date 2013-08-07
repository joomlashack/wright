<?php
// Wright v.3 Override: Joomla 3.1.5
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$params  = $displayData->params; // Wright v.3: Added params (fixed in Joomla 3.1.2)

?>
<?php $images = json_decode($displayData->images); ?>
<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
	<?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
	<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image"> <img
	<?php echo ' class="' . $displayData->wrightBootstrapImages . '"' // Wright v.3: Bootstrapped images ?>
	<?php if ($images->image_intro_caption):
		echo ' title="' .htmlspecialchars($images->image_intro_caption) .'"';  // Wright v.3: Removed caption (TODO: reconsider to reimplement with JCaption)
	endif; ?>
	src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
	<?php
		// Wright v.3: Caption
	if ($images->image_intro_caption) {
		echo '<p class="img_caption">' . $images->image_intro_caption . '</p>';
	}
		// End Wright v.3: Caption
	?>
	 </div>
<?php endif; ?>
