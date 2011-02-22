<?php
// $Id: default.php 13 2010-11-05 16:28:16Z jeremy $
defined( '_JEXEC' ) or die( 'Restricted access' );

$cparams = JComponentHelper::getParams ('com_media');
?>

<div id="contact<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">

	<?php if ( $this->params->get( 'show_page_title', 1 ) && !$this->contact->params->get( 'popup' ) && $this->params->get('page_title') != $this->contact->name ) : ?>
		<h1>
			<?php echo $this->params->get( 'page_title' ); ?>
		</h1>
	<?php endif; ?>
	
	
	<?php if ( $this->contact->name && $this->contact->params->get( 'show_name' ) ) : ?>
	<h2>
		<span class="contact-name"><?php echo $this->escape($this->contact->name); ?></span>
	</h2>
	<?php endif; ?>
	
	<?php if ( $this->params->get( 'show_contact_list' ) && count( $this->contacts ) > 1) : ?>
	<form action="<?php echo JRoute::_('index.php') ?>" method="post" name="selectForm" id="selectForm">
		<?php echo JText::_( 'Select Contact' ); ?>:
		<?php echo JHTML::_('select.genericlist',  $this->contacts, 'contact_id', 'class="inputbox" onchange="this.form.submit()"', 'id', 'name', $this->contact->id);?>
		<input type="hidden" name="option" value="com_contact" />
	</form>
	<?php endif; ?>
	
	<?php if ( $this->contact->image && $this->contact->params->get( 'show_image' ) ) : ?>
	<div class="contact-image">
		<?php echo JHTML::_('image', 'images/stories' . '/'.$this->contact->image, JText::_( 'Contact' ), array('align' => 'middle')); ?>
	</div>
	<?php endif; ?>

	<?php if ( $this->contact->con_position && $this->contact->params->get( 'show_position' ) ) : ?>
		<p class="contact-position><?php echo $this->escape($this->contact->con_position); ?>
	<?php endif; ?>
	
	<?php include(dirname(__FILE__).DS.'default_address.php'); ?>

	<?php if ( $this->contact->params->get( 'allow_vcard' ) ) : ?>
	<?php echo JText::_( 'Download information as a' );?>
		<a href="<?php echo JURI::base(); ?>index.php?option=com_contact&amp;task=vcard&amp;contact_id=<?php echo $this->contact->id; ?>&amp;format=raw&amp;tmpl=component">
			<?php echo JText::_( 'VCard' );?></a>
	<?php endif; ?>
	
	<?php if ( $this->contact->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id))
		include(dirname(__FILE__).DS.'default_form.php');
	?>

</div>
