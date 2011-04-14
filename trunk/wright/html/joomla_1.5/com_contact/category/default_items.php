<?php // @version $Id: default_items.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

	<script language="javascript" type="text/javascript">
	function tableOrdering( order, dir, task )
	{
		var form = document.adminForm;

		form.filter_order.value	 = order;
		form.filter_order_Dir.value	= dir;
		document.adminForm.submit( task );
	}
	</script>

<form action="<?php echo $this->action; ?>" method="post" name="adminForm">
	<?php if ($this->params->get('display')) : ?>
	<fieldset class="filters">
	<legend class="hidelabeltxt"><?php echo JText::_('Filters'); ?></legend>
		<div class="display-limit">
			<?php echo JText::_('Display Num'); ?>&nbsp;
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<?php endif; ?>

		<input type="hidden" name="catid" value="<?php echo (int)$this->category->id; ?>" />
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
	</fieldset>
</form>

<table class="category">

	<?php if ($this->params->get('show_headings')) : ?>
	<thead>
		<tr>
			<th id="Name" class="item-title">
				<?php echo JHTML::_('grid.sort', 'Name', 'cd.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
		
			<?php if ($this->params->get('show_position')) : ?>
			<th id="Position" class="item-position">
				<?php echo JHTML::_('grid.sort', 'Position', 'cd.con_position', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('show_email')) : ?>
			<th id="Mail" class="item-email">
				<?php echo JText::_('Email'); ?>
			</th>
			<?php endif; ?>

			<?php if ( $this->params->get('show_telephone')) : ?>
			<th id="Phone" class="item-phone">
				<?php echo JText::_('Phone'); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('show_mobile')) : ?>
			<th id="mobile" class="item-phone">
				<?php echo JText::_('Mobile'); ?>
			</th>
			<?php endif; ?>

			<?php if ( $this->params->get('show_fax')) : ?>
			<th id="Fax" class="item-phone">
				<?php echo JText::_('Fax'); ?>
			</th>
			<?php endif; ?>
		</tr>
	</thead>
	<?php endif; ?>
	
	<tbody>
	
	<?php foreach ($this->items as $item) : ?>
		<tr>
			<td height="20" class="item-name" headers="Name">
				<a href="<?php echo $item->link; ?>" class="category<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
					<?php echo $this->escape($item->name); ?></a>
			</td>
			
			<?php if ($this->params->get('show_position')) : ?>
			<td headers="Position" class="item-position">
				<?php echo $this->escape($item->con_position); ?>
			</td>
			<?php endif; ?>

			<?php if ($this->params->get('show_email')) : ?>
			<td headers="Mail" class="item-email">
				<?php echo $item->email_to; ?>
			</td>
			<?php endif; ?>

			<?php if ($this->params->get('show_telephone')) : ?>
			<td headers="Phone" class="item-phone">
				<?php echo $this->escape($item->telephone); ?>
			</td>
			<?php endif; ?>

			<?php if ($this->params->get('show_mobile')) : ?>
			<td headers="Mobile" class="item-phone">
				<?php echo $this->escape($item->mobile); ?>
			</td>
			<?php endif; ?>

			<?php if ($this->params->get('show_fax')) : ?>
			<td headers="Fax" class="item-phone">
				<?php echo $this->escape($item->fax); ?>
			</td>
			<?php endif; ?>
		</tr>
	<?php endforeach; ?>
	
	</tbody>
	
</table>

	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<div class="pagination">
		<?php if( $this->pagination->get('pages.total') > 1 ) : ?>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php endif; ?>
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>