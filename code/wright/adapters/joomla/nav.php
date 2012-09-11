<?php

class WrightAdapterJoomlaNav
{
	public function render($args)
	{
		// Set module name
		if (!isset($args['name'])) $args['name'] = 'menu';
		// Set module name
		if (!isset($args['style'])) $args['style'] = 'raw';
		// Set module name
		if (!isset($args['class'])) $args['class'] = 'span12';
		// Set module name
		if (!isset($args['wrapclass'])) $args['wrapclass'] = '';

		switch ($args['type'])
		{
		    case 'row-fluid' :
				$wrapper = '<div class="'.$args['type'].'">';
		        break;
			default :
				$wrapper .= '<div class="'.$args['wrapper'].'">';
				break;
		}


		$nav = $wrapper . '
			<nav id="'.$args['name'].'" class="'.$args['class'].'">
				<div class="navbar">
					<div class="navbar-inner">
						<div class="container">
				            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					            <span class="icon-bar"></span>
					            <span class="icon-bar"></span>
					            <span class="icon-bar"></span>
				            </a>
				            <div class="nav-collapse">
								 <jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" />
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>';
		return $nav;
	}
}
