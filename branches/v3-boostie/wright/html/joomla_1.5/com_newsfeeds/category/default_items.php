<?php // @version $Id: default_items.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

<?php if ( $this->params->get( 'show_limit' ) ) : ?>
	<form action="index.php" method="post" name="adminForm">
		<fieldset class="filters">
		<div class="display-limit">
			<label for="limit"><?php echo JText::_( 'Display Num' ); ?>&nbsp;</label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		</fieldset>
	</form>
<?php endif; ?>

<table class="category">
	<?php if ( $this->params->get( 'show_headings' ) ) : ?>
	<thead>
		<tr>
			<?php if ( $this->params->get( 'show_name' ) ) : ?>
			<th class="item-title" id="name">
				<?php echo JText::_( 'Feed Name' ); ?>
			</th>
			<?php endif; ?>

			<?php if ( $this->params->get( 'show_articles' ) ) : ?>
			<th class="item-num-art" nowrap="nowrap" id="num_a">
				<?php echo JText::_('Num Articles'); ?>
			</th>
			<?php endif; ?>
		</tr>
	</thead>
	<?php endif; ?>

	<tbody>
	<?php foreach ( $this->items as $item ) : ?>
		<tr class="cat-list row<?php echo $item->odd + 1; ?>">
			<td class="item-title" headers="name">
				<a href="<?php echo $item->link; ?>" class="category<?php echo $this->escape($this->params->get( 'pageclass_sfx' )); ?>">
					<?php echo $this->escape($item->name); ?></a>
			</td>

			<?php if ( $this->params->get( 'show_articles' ) ) : ?>
			<td class="item-num-art" headers="num_a"><?php echo $item->numarticles; ?></td>
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