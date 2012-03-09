<?php // @version $Id: default_items.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript">
	function tableOrdering(order, dir, task) {
		var form = document.adminForm;

		form.filter_order.value = order;
		form.filter_order_Dir.value = dir;
		document.adminForm.submit(task);
	}
</script>


<form action="<?php echo $this->escape($this->action); ?>" method="post" name="adminForm">
	<fieldset class="filters">
		<div class="display-limit">
			<?php echo JText :: _('Display Num'); ?>&nbsp;
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<input type="hidden" name="filter_order" value="<?php echo $this->lists['order'] ?>" />
		<input type="hidden" name="filter_order_Dir" value="" />
	</fieldset>
</form>

<table class="category">

	<?php if ($this->params->def('show_headings', 1)) : ?>
	<thead>
		<tr>
			<th class="title" id="title">
				<?php echo JHTML::_('grid.sort', 'Web Link', 'title', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>

			<?php if ($this->params->get('show_link_hits')) : ?>
			<th class="hits" nowrap="nowrap" id="hits">
				<?php echo JHTML::_('grid.sort', 'Hits', 'hits', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			<?php endif; ?>
		</tr>
	</thead>
	<?php endif; ?>
	
	<tbody>
	<?php foreach ($this->items as $item) : ?>
	<tr class="cat-list row<?php echo $item->odd + 1; ?>">

		<td headers="title" class="title">
			<?php if ($item->image) : ?>
			<span class="jicons-icons">
				<?php echo $item->image; ?>
			</span>
			<?php endif; ?>
			<p>
				<?php echo $item->link; ?>
			</p>
			<?php if ($this->params->get('show_link_description')) : ?>
			<p>
				<?php echo nl2br($item->description); ?>
			</p>
			<?php endif; ?>
		</td>

		<?php if ($this->params->get('show_link_hits')) : ?>
		<td headers="hits" class="hits">
			<?php echo (int)$item->hits; ?>
		</td>
		<?php endif; ?>

	</tr>
	<?php endforeach; ?>
	
	</tbody>

</table>


<?php 
// Pagination
if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
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