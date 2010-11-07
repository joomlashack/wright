<?php

class AdapterJoomla_1_5Footer
{
	public function render($args)
	{
		$doc = Wright::getInstance();

		if ($doc->document->params->get('rebrand', 'no') !== 'yes')
		{
			$anchors = array("Joomla Templates"=>25,"Free Joomla Templates"=>45,"Joomla Tutorial"=>61,"Joomla Template Tutorial"=>75,"Joomla Template"=>80,"Joomla 1.5 Templates"=>84,"Joomla 1.5 Template"=>88,"Joomla Extensions"=>92,"Joomla Extension"=>96,"Joomla Training"=>100);
			$links = array("Joomla Templates" => "professional-joomla-templates","Free Joomla Templates"  => "free-joomla-templates","Joomla Tutorial"  => "tutorials","Joomla Template Tutorial"  => "tutorials","Joomla Template"  => "professional-joomla-templates","Joomla 1.5 Templates"  => "professional-joomla-templates","Joomla 1.5 Template"  => "free-joomla-templates","Joomla Extensions"  => "joomla-extensions","Joomla Extension"  => "joomla-extensions","Joomla Training"  => "university/");
			$endlines  = array(": by JoomlaShack"=>10,": from JoomlaShack"=>20," by JoomlaShack"=>30," from JoomlaShack"=>40, " at JoomlaShack"=>50,": by JoomlaShack.com"=>60,": from JoomlaShack.com"=>70," by JoomlaShack.com"=>80," from JoomlaShack.com"=>90," at JoomlaShack.com"=>100);


			$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

			$md5 = md5($url);

			$nums = ereg_replace("[^0-9]", "", $md5);

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
					if($second<66) {
						$url = "http://www.joomlashack.com";
					} else {
						$url = "http://www.joomlashack.com/".$links[$possibility];
					}
					foreach($endlines as $ends=>$v) {
						if($endline=='' && $v>$third) { $endline = $ends; }
					}
			  }
			}

			return '<div class="designer"><a href="'.$url.'">'.$anchor.'</a>'.$endline.'</div>';
		}
		else
		{
			return;
		}
	}
}