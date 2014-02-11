<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  mod_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="weblinks<?php echo $moduleclass_sfx; ?> list-striped">  <?php // Wright v.3: Added list-striped class ?>
	<?php
	foreach ($list as $item) :
		?>
		<li>
			<?php
			$link = $item->link;

			switch ($params->get('target', 3))
			{
				case 1:
					// Open in a new window
					echo '<a href="' . $link . '" target="_blank" rel="' . $params->get('follow', 'nofollow') . '">' .
						'<i class="icon-link"></i>' .  // Wright v.3: Added icon
						htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8') . '</a>';
					break;

				case 2:
					// Open in a popup window
					echo "<a href=\"#\" onclick=\"window.open('" . $link . "', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\">" .
						'<i class="icon-link"></i>' .  // Wright v.3: Added icon
						htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8') . '</a>';
					break;

				default:
					// Open in parent window
					echo '<a href="' . $link . '" rel="' . $params->get('follow', 'nofollow') . '">' .
						'<i class="icon-link"></i>' .  // Wright v.3: Added icon
						htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8') . '</a>';
					break;
			}

			if ($params->get('description', 0))
			{
				echo nl2br($item->description);
			}

			if ($params->get('hits', 0))
			{
				echo /*'(' .*/ $item->hits . ' ' . JText::_('MOD_WEBLINKS_HITS') /*. ')'*/; // Wright v.3: removed parenthesis
			}
			?>
		</li>
	<?php
	endforeach;
	?>
</ul>
