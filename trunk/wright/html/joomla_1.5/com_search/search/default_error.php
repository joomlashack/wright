<?php // @version $Id: default_error.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

<?php if($this->error): ?>
<div class="error<?php echo $this->escape($this->params->get( 'pageclass_sfx' )) ?>">
	<p><?php echo $this->escape($this->error); ?></p>
</div>
<?php endif; ?>