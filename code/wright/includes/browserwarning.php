<?php
/**
 * @package     Wright
 * @subpackage  Includes
 *
 * @copyright   Copyright (C) 2005 - 2014 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

$browser = new Browser;
$isMobile = $browser->isMobile();

?>
 
<!-- Modal -->
<div id="wrightBCW" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="wrightBCWLabel" aria-hidden="true" data-controls-modal="wrightBCW" data-backdrop="static" data-keyboard="false">
	<div class="modal-header">
		<h3 id="wrightBCWLabel">
	    <?php
			echo JText::_('TPL_JS_WRIGHT_BROWSER_WARNING_TITLE')
		?>
		</h3>
	</div>
	<div class="modal-body">
		<p>
		    <?php
				echo JText::_('TPL_JS_WRIGHT_BROWSER_WARNING_CONTENT')
			?>
		</p>
		<p>
			<ul>
		<?php
			if (isset($doc) && isset($doc->_browserCompatibility))
			{
				$browsers = get_object_vars($doc->_browserCompatibility);

				foreach ($browsers as $browser => $compat)
				{
					if ($compat->desktop != $isMobile || $compat->mobile == $isMobile)
					{
		?>
				<li>
		<?php
						echo $browser . ' (' . JText::sprintf('TPL_JS_WRIGHT_BROWSER_WARNING_VERSION', $compat->minimumVersion) . ')';

						if ($compat->recommended && !$isMobile)
						{
		?>
					<bold>
		<?php
							echo JText::_('TPL_JS_WRIGHT_BROWSER_WARNING_RECOMMENDED');
		?>
					</bold>
					<i class="icon-star"></i>
		<?php
						}
		?>
				</li>
		<?php
					}
				}
			}
		?>
			</ul>
		</p>
	</div>
	<div class="modal-footer">
		<p>	
		    <?php
				echo JText::_('TPL_JS_WRIGHT_BROWSER_WARNING_CONCLUSION')
			?>
		</p>
		<p>
			<button class="btn btn-primary" onclick="jQuery('#wrightBCW').modal('hide');">
		    <?php
				echo JText::_('TPL_JS_WRIGHT_BROWSER_WARNING_BUTTON')
			?>
			</button>
		</p>
	</div>
</div>
