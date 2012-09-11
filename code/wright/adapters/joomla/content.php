<?php

class WrightAdapterJoomlaContent
{
	public function render($args)
	{
	    /* dissabled to set all positions in the template.php file. Cleaner for end user management
		if (!isset($args['above'])) $args['above'] = 'above-content';
		if (!isset($args['above-chrome'])) $args['above-chrome'] = 'xhtml';
		if (!isset($args['below'])) $args['below'] = 'below-content';
		if (!isset($args['below-chrome'])) $args['below-chrome'] = 'xhtml';
		*/

		$content = '<jdoc:include type="message" />';

		/* dissabled to set all positions in the template.php file. Cleaner for end user management
		$doc = Wright::getInstance();
		if ($doc->countModules($args['above']) && $args['above'] !== 'false') {
			$content .= '<div class="'.$args['above'].'">
				<jdoc:include type="modules" name="'.$args['above'].'" style="'.$args['above-chrome'].'" />
				</div>
			<div class="clr"></div>';
		}
		*/
		
		$content .= '<jdoc:include type="component" />';
		
		/* dissabled to set all positions in the template.php file. Cleaner for end user management
		if ($doc->countModules($args['below']) && $args['below'] !== 'false') {
			$content .= '<div class="'.$args['below'].'">
				<jdoc:include type="modules" name="'.$args['below'].'" style="'.$args['below-chrome'].'" />
				</div>
			<div class="clr"></div>';
		}
		*/

		return $content;
	}
}