<?php // @version $Id: default_message.php$
defined('_JEXEC') or die('Restricted access');
?>

<h1>
	<?php echo $this->escape($this->message->title); ?>
</h1>

<p class="message">
	<?php echo $this->escape($this->message->text); ?>
</p>
