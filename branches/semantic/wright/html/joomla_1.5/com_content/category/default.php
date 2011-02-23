<?php // @version $Id: default.php 13 2010-11-05 16:28:16Z jeremy $
defined('_JEXEC') or die('Restricted access');
$cparams = JComponentHelper::getParams ('com_media');
?>

<div class="category-list<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">

	<?php if ($this->params->get('show_page_title',1)) : ?>
	<h2>
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</h2>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_category', 1)) : ?>
	<h2>
		<span class="subheading-category"><?php echo $this->category->title;?></span>
	</h2>
	<?php endif; ?>

	<?php if ($this->params->def('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc">
		<?php if ($this->params->get('show_description_image') && $this->category->image) : ?>
			<img src="<?php echo $this->baseurl .'/'. $cparams->get('image_path').'/'.$this->category->image; ?>" class="image_<?php echo $this->category->image_position; ?>" />
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) :
			echo $this->category->description;
		endif; ?>
	</div>
	<?php endif; ?>

	<div class="cat-items">
		<?php $this->items =& $this->getItems();
		include(dirname(__FILE__).DS.'default_items.php'); ?>
	</div>

</div>