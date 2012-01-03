<?php

class WrightAdapterJoomlaFooter
{
	public function render($args)
	{
		$doc = Wright::getInstance();

		if ($doc->document->params->get('rebrand', 'no') !== 'yes')
		{
			
			$anchors = array(	"Joomla template" => 50,				"joomla templates" => 100);
			$links = array(     "Joomla template" => "",				"joomla templates" => );
			$endlines  = array(	": by JoomlaShack" => 50,	": from JoomlaShack" => 100);
			$host = "http://www.joomlashack.com/";
			$class = 'joomlashack';
		

			$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

			$md5 = md5($url);

			$nums = filter_var($md5, FILTER_SANITIZE_NUMBER_INT);
			
			$first = substr($nums,0,2);
			$second = substr($nums,2,2);
			$third  = substr($nums,4,2);

			if(substr($first,0,1)=='0') { $first = substr($first,1,1); }
			if(substr($second,0,1)=='0') { $second = substr($second,1,1); }
			if(substr($third,0,1)=='0') { $third = substr($third,1,1); }

			$anchor = '';
			$endline = '';
			foreach($anchors as $possibility=>$val) {;
			  if($anchor=='' && $val>$first) {
					$anchor = $possibility;
					$host .= $links[$possibility];
					foreach($endlines as $ends=>$v) {
						if($endline=='' && $v>$third) { $endline = $ends; }
					}
			  }
			}

			return '<a class="joomlashack" href="'.$host.'">'.$anchor.$endline.'</a>';
		}
		else
		{
			return;
		}
	}
}