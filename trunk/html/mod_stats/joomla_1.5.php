<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<dl class="stats-module<?php echo $params->get('moduleclass_sfx') ?>">
<?php foreach ($list as $item) : ?>
	<dt><?php echo $item->title;?></dt>
	<dd><?php echo $item->data;?></dd>
<?php endforeach; ?>
</dl>
