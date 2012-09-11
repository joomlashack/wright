<?php // @version $Id: default.php 13 2010-11-05 16:28:16Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>
<div class="weblink-category<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">

	<?php if ($this->params->get('show_page_title', 1)) : ?>
		<h1>
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</h1>
	<?php endif; ?>

	<?php if ( $this->category->image || $this->category->description) : ?>
	<div class="category-desc">
		<?php if ($this->category->image) :
			echo $this->category->image;
		endif; ?>
		<?php echo $this->category->description; ?>
	</div>
	<?php endif; ?>

	<?php include(dirname(__FILE__).DS.'default_items.php'); ?>

</div>