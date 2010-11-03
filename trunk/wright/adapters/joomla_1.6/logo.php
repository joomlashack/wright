<?php

class AdapterJoomla_1_6Logo
{
	public function render($args)
	{
		if (!isset($args['name'])) $args['name'] = 'newsflash';
		if (!isset($args['style'])) $args['style'] = 'xhtml';

		$doc = Wright::getInstance();
		if ($doc->document->params->get('logo', 'template') == 'template')
			$logo = JURI::root().'templates/'.$doc->document->template.'/images/logo.png';
		else
			$logo = JURI::root().'images/'.$doc->document->params->get('logo');
		$app = JFactory::getApplication();

		$html = '<div id="logo" class="grid_'.$doc->document->params->get('logowidth', '6').'"><a href="'.JURI::root().'"><span>'.$app->getCfg('sitename').'</span><img src="'.$logo.'" alt="" title="" /></a></div>';
		if ($doc->document->params->get('logowidth') !== '12') $html .= '<div id="'.$args['name'].'" class="grid_'.(12 - $doc->document->params->get('logowidth', '6')).'"><jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" /></div>';
		$html .= '<div class="clearfix"></div>';
		return $html;
	}
}