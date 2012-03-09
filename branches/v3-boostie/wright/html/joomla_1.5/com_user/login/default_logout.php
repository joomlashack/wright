<?php // @version $Id: default_logout.php 13 2010-11-05 16:28:16Z jeremy $
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div class="logout<?php echo $this->escape($this->params->get( 'pageclass_sfx' )); ?>">
	
	<?php if ( $this->params->get( 'show_logout_title' ) ) : ?>
		<h1>
			<?php echo $this->params->get( 'header_logout' ); ?>
		</h1>
	<?php endif; ?>

	<?php if ( $this->params->get( 'description_logout' ) || isset( $this->image ) ) : ?>
	<div class="logout-description">
		<?php if (isset ($this->image)) :
			echo $this->image;
		endif;
		if ( $this->params->get( 'description_logout' ) ) : ?>
		<p>
			<?php echo $this->params->get('description_logout_text'); ?>
		</p>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	
	<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="login" id="login" class="logout_form<?php echo $this->escape($this->params->get( 'pageclass_sfx' )); ?>">
		<div>
			<input type="submit" name="Submit" class="button" value="<?php echo JText::_( 'Logout' ); ?>" />
			<input type="hidden" name="option" value="com_user" />
			<input type="hidden" name="task" value="logout" />
			<input type="hidden" name="return" value="<?php echo $this->return; ?>" />
		</div>
	</form>
</div>