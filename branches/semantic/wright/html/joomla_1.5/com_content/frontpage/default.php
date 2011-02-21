<?php // @version $Id: default.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

<div class="blog-featured<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">

	<?php if ($this->params->get('show_page_title',1)) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</h1>
	<?php endif; ?>

	<?php // Leading items
		$i = $this->pagination->limitstart;
		$rowcount = $this->params->def('num_leading_articles', 1); 
	if ($rowcount) : ?>
	<div class="items-leading">
	<?php for ($y = 0; $y < $rowcount && $i < $this->total; $y++, $i++) : ?>
		<div class="leading num<?php echo $rowcount ?>">
			<?php $this->item =& $this->getItem($i, $this->params);
			include(dirname(__FILE__).DS.'default_item.php'); ?>
		</div>
	<?php endfor; ?>
	</div>
	<?php endif; ?>

	<?php 
	// Intro items
	$introcount = $this->params->def('num_intro_articles', 4);
	if ($introcount) :
		$colcount = (int)$this->params->def('num_columns', 2);
		if ($colcount == 0) :
			$colcount = 1;
		endif;
		$rowcount = (int) $introcount / $colcount;
		$ii = 0;
		for ($y = 0; $y < $rowcount && $i < $this->total; $y++) : ?>
			<div class="items-row cols-<?php echo $colcount; ?>">
				<?php for ($z = 0; $z < $colcount && $ii < $introcount && $i < $this->total; $z++, $i++, $ii++) : ?>
					<div class="item column-<?php echo $z + 1; ?>" >
						<?php 
							$this->item =& $this->getItem($i, $this->params);
							include(dirname(__FILE__).DS.'default_item.php') 
						?>
					</div>
				<?php endfor; ?>
				<span class="row_separator"></span>
			</div>
		<?php endfor;
	endif; ?>

	<?php 
	// Links 
	$numlinks = $this->params->def('num_links', 4);
	if ($numlinks && $i < $this->total) : ?>
		<?php $this->links = array_slice($this->items, $i - $this->pagination->limitstart, $i - $this->pagination->limitstart + $numlinks);
		include(dirname(__FILE__).DS.'default_links.php'); ?>
	<?php endif; ?>

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
</div>
