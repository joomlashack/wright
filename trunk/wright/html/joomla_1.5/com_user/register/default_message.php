<?php // @version $Id: default_message.php 11917 2009-05-29 19:37:05Z ian $
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<h1>
	<?php echo $this->escape($this->message->title); ?>
</h1>

<p class="message">
	<?php echo $this->escape($this->message->text); ?>
</p>
