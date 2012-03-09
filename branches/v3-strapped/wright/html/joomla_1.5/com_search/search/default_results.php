	<?php // @version $Id: default_results.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

<?php if (count($this->results)) : ?>
<div class="search-results<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
	<h3><?php echo JText :: _('Search_result'); ?></h3>
	<?php $start = $this->pagination->limitstart + 1; ?>
	<ol class="list<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>" start="<?php echo (int)$start ?>">
		<?php foreach ($this->results as $result) : ?>
		<li>
			<?php if ($result->href) : ?>
			<h4>
				<a href="<?php echo JRoute :: _($result->href) ?>" <?php echo ($result->browsernav == 1) ? 'target="_blank"' : ''; ?> >
					<?php echo $this->escape($result->title); ?></a>
			</h4>
			<?php endif; ?>
			<?php if ($result->section) : ?>
			<p><?php echo JText::_('Category') ?>:
				<span class="small<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
					<?php echo $this->escape($result->section); ?>
				</span>
			</p>
			<?php endif; ?>

			<?php echo $result->text; ?>
			
			<span class="small<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">
				<?php echo $this->escape($result->created); ?>
			</span>
		</li>
		<?php endforeach; ?>
	</ol>
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php endif; ?>
