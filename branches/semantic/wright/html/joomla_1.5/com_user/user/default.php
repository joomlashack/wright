<?php // @version $Id: default.php 11917 2009-05-29 19:37:05Z ian $
defined('_JEXEC') or die('Restricted access');
?>
<?php if($this->params->get('show_page_title',1)) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_title')) ?>
	</h1>
<?php endif; ?>

<h2>
	<?php echo JText::_('Welcome!'); ?>
</h2>

<p class="contentdescription">
	<?php echo $this->params->get('welcome_desc', JText::_( 'WELCOME_DESC' ));; ?>
</p>
