<?php // @version $Id: default_form.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

<form action="<?php echo JRoute::_( 'index.php?option=com_search#content' ) ?>" method="post" class="search_result<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
	
	<fieldset class="word">
		<label for="search_searchword"><?php echo JText::_('Search Keyword') ?> </label>
		<input type="text" name="searchword" id="search_searchword"  maxlength="20" value="<?php echo $this->escape($this->searchword) ?>" class="inputbox" />
		<button name="Search" onclick="this.form.submit()" class="button"><?php echo JText::_( 'Search' );?></button>
	</fieldset>
	
	<?php if (!empty($this->searchword)) : ?>
		<div class="searchintro<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
			<p>
				<?php echo JText::_('Search Keyword') ?> <strong><?php echo $this->escape($this->searchword) ?></strong>
				<?php echo $this->result ?>
			</p>
			<p>
				<a href="#form1" onclick="document.getElementById('search_searchword').focus();return false" onkeypress="document.getElementById('search_searchword').focus();return false" ><?php echo JText::_('Search_again') ?></a>
			</p>
		</div>
	<?php endif; ?>

	<fieldset class="phrase">
		<legend><?php echo JText::_('Search Parameters') ?></legend>
		<div class="phrases-box">
			<?php echo $this->lists['searchphrase']; ?>
		</div>
		<div class="ordering-box">
			<label for="ordering" class="ordering"><?php echo JText::_('Ordering') ?>:</label>
			<?php echo $this->lists['ordering']; ?>
		</div>
	</fieldset>

	<?php if ($this->params->get('search_areas', 1)) : ?>
	<fieldset class="only">
		<legend><?php echo JText::_('Search Only') ?>:</legend>
		<?php foreach ($this->searchareas['search'] as $val => $txt) : ?>
			<?php $checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="true"' : ''; ?>
			
			<input type="checkbox" name="areas[]" value="<?php echo $val ?>" id="area_<?php echo $val ?>" <?php echo $checked ?> />
			<label for="area_<?php echo $val ?>"><?php echo JText::_($txt); ?></label>
		<?php endforeach; ?>
	</fieldset>
	<?php endif; ?>

	<?php if (count($this->results)) : ?>
		<div class="form-limit">
			<label for="limit"><?php echo JText :: _('Display Num') ?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
	<?php endif; ?>

	<input type="hidden" name="task" value="search" />
</form>
