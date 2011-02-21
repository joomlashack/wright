<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="archive<?php echo $this->escape($this->params->get('pageclass_sfx'));?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>
<form id="jForm" action="<?php JRoute::_('index.php')?>" method="post">
	<?php if ($this->params->get('filter')) : ?>
	<fieldset class="filters">
	<legend class="hidelabeltxt"><?php echo JText::_('Fiter'); ?></legend>
	<div class="filter-search">
		<input type="text" name="filter" value="<?php echo $this->escape($this->filter); ?>" class="inputbox" onchange="document.jForm.submit();" />
		<?php echo $this->form->monthField; ?>
		<?php echo $this->form->yearField; ?>
		<?php echo $this->form->limitField; ?>
		<button type="submit" class="button"><?php echo JText::_('Filter'); ?></button>
	</div>
	<?php endif; ?>
	<input type="hidden" name="view" value="archive" />
	<input type="hidden" name="option" value="com_content" />
	<input type="hidden" name="viewcache" value="0" />
	</fieldset>
	
	<?php echo include('default_items.php'); ?>
</form>
</div>