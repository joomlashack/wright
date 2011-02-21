<?php // @version $Id: blog_links.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>
<div class="items-more">
<h3>
	<?php echo JText::_('More Articles...'); ?>
</h3>

<ol>
	<?php foreach ($this->links as $link) : ?>
	<li>
		<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($link->slug, $link->catslug, $link->sectionid)); ?>">
			<?php echo $this->escape($link->title); ?></a>
	</li>
	<?php endforeach; ?>
</ol>