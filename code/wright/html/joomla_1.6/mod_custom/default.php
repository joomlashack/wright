<?php
// no direct access
defined('_JEXEC') or die;
?>
<div class="custom<?php echo $moduleclass_sfx ?>"<?php if ($params->get('backgroundimage')): ?> style="background-image:url(<?php echo $params->get('backgroundimage');?>)"<?php endif;?>>
	<?php echo $module->content;?>
</div>