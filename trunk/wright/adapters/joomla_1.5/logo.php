<?php

class AdapterJoomla_1_5Logo
{
	public function render($args)
	{
		if (!isset($args['name'])) $args['name'] = 'newsflash';
		if (!isset($args['style'])) $args['style'] = 'xhtml';

		$doc = Wright::getInstance();
		if ($doc->document->params->get('logo', 'template') == 'template') {
			if (is_file(JPATH_ROOT.DS.'templates'.DS.$doc->document->template.DS.'images'.DS.'logo.png'))
				$logo = JURI::root().'templates/'.$doc->document->template.'/images/logo.png';
			elseif (is_file(JPATH_ROOT.DS.'templates'.DS.$doc->document->template.DS.'images'.DS.$doc->document->params->get('style').DS.'logo.png'))
				$logo = JURI::root().'templates/'.$doc->document->template.'/images/'.$doc->document->params->get('style').'/logo.png';
			else {
				$logo = JURI::root().'templates/'.$doc->document->template.'/wright/images/logo.png';
			}
		}
		else {
			$logo = JURI::root().'images/'.$doc->document->params->get('logo', 'logo.png');
		}

		$app = JFactory::getApplication();

		$html = '<div id="logo" class="grid_'.$doc->document->params->get('logowidth', '6').'"><a href="'.JURI::root().'"><span>'.$app->getCfg('sitename').'</span><img src="'.$logo.'" alt="" title="" /></a></div>';
		if ($doc->document->params->get('logowidth') !== '12') $html .= '<div id="'.$args['name'].'" class="grid_'.(12 - $doc->document->params->get('logowidth', '6')).'"><jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" /></div>';
		$html .= '<div class="clearfix"></div>';
		return $html;
	}
}