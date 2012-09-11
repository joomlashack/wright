<?php // @version $Id: default.php 13 2010-11-05 16:28:16Z jeremy $
defined('_JEXEC') or die('Restricted access');
$cparams = JComponentHelper::getParams ('com_media');
?>
<div class="contact-category<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">

	<?php if ($this->params->get('show_page_title',1)) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</h1>
	<?php endif; ?>

	<?php if ($this->category->image || $this->category->description) : ?>
	<div class="category-desc">
		<?php if ($this->params->get('image') != -1 && $this->params->get('image') != '') : ?>
			<img src="<?php echo $this->baseurl .'/'. 'images/stories' . '/'. $this->params->get('image'); ?>" class="image_<?php echo $this->params->get('image_align'); ?>" alt="<?php echo JText::_( 'Contacts' ); ?>" />
		<?php elseif($this->category->image): ?>
			<img src="<?php echo $this->baseurl .'/'. 'images/stories' . '/'. $this->category->image; ?>" class="image_<?php echo $this->category->image_position; ?>" alt="<?php echo JText::_( 'Contacts' ); ?>" />
		<?php endif; ?>
		<?php echo $this->category->description; ?>
	</div>
	<?php endif; ?>

	<?php include(dirname(__FILE__).DS.'default_items.php'); ?>

</div>