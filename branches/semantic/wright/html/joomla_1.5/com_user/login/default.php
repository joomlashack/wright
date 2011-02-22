<?php // @version $Id: default.php 13 2010-11-05 16:28:16Z jeremy $
defined( '_JEXEC' ) or die( 'Restricted access' );
 ?>
 
<?php if($this->params->get('show_page_title',1)) : ?>
	<h1>
		<?php echo $this->params->get('page_title') ?>
	</h1>
<?php endif; ?>

<?php include( 'default_'.$this->type.'.php' ); ?>
