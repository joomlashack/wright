<?php

class WrightAdapterJoomlaNav
{
	public function render($args)
	{
		// Set module name
		if (!isset($args['name'])) $args['name'] = 'menu';
		// Set module name
		if (!isset($args['style'])) $args['style'] = 'raw';

		if (!isset($args['containerClass'])) $args['containerClass'] = '';

		// Set module name
		if (!isset($args['wrapClass'])) $args['wrapClass'] = '';
		if (!isset($args['wrapper'])) $args['wrapper'] = 'wrapper-' . $args['name'];

		if (!isset($args['type'])) $args['type'] = 'menu';

		$doc = Wright::getInstance();

		if (version_compare(JVERSION, '4', 'lt')) {

            // Menu for Joomla 3
			if ($args['type'] == 'toolbar') {
				$nav =
					'<div class="'.$args['wrapper'].'">
				<nav id="'.$args['name'].'">
					<div class="navbar ' . $args['wrapClass'] . '">
						<div class="navbar-inner">
							<div class="' . $args['containerClass'] . '">
					            <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target="#nav-'.$args['name'].'">
						            <span class="icon-bar"></span>
						            <span class="icon-bar"></span>
						            <span class="icon-bar"></span>
					            </a>
					            <div class="nav-collapse" id="nav-'.$args['name'].'">
									 <jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" />
								</div>
							</div>
						</div>
					</div>
				</nav>
			</div>';
				if ($doc->document->params->get('mobile_menu_text', '') != "") {
					$nav =
						'<div class="'.$args['wrapper'].'">
					<nav id="'.$args['name'].'">
						<div class="navbar ' . $args['wrapClass'] . '">
							<div class="navbar-inner">
								<div class="' . $args['containerClass'] . '">
						            <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target="#nav-'.$args['name'].'">
													' . $doc->document->params->get('mobile_menu_text') . '
						            </a>
						            <div class="nav-collapse" id="nav-'.$args['name'].'">
										 <jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" />
									</div>
								</div>
							</div>
						</div>
					</nav>
				</div>';
				}
			}
			else {
				$nav =
					'<div class="'.$args['wrapper'].'">
				<div class="' . $args['containerClass'] . '">
					<nav id="'.$args['name'].'">
						<div class="navbar ' . $args['wrapClass'] . '">
							<div class="navbar-inner">
					            <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target="#nav-'.$args['name'].'">
						            <span class="icon-bar"></span>
						            <span class="icon-bar"></span>
						            <span class="icon-bar"></span>
					            </a>
					            <div class="nav-collapse" id="nav-'.$args['name'].'">
									 <jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" />
								</div>
							</div>
						</div>
					</nav>
				</div>
			</div>';
				if ($doc->document->params->get('mobile_menu_text', '') != "") {
					$nav =
						'<div class="'.$args['wrapper'].'">
					<div class="' . $args['containerClass'] . '">
						<nav id="'.$args['name'].'">
							<div class="navbar ' . $args['wrapClass'] . '">
								<div class="navbar-inner">
						            <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target="#nav-'.$args['name'].'">
													' . $doc->document->params->get('mobile_menu_text') . '
						            </a>
						            <div class="nav-collapse" id="nav-'.$args['name'].'">
										 <jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" />
									</div>
								</div>
							</div>
						</nav>
					</div>
				</div>';
				}
			}

		} else {

            // Menu for Joomla 4
			if ($args['type'] == 'toolbar') {

				$nav =
					'<div class="'.$args['wrapper'].'">
				<div id="'.$args['name'].'">
                    <nav class="navbar navbar-expand-lg ' . $args['wrapClass'] . '">
                        <div class="' . $args['containerClass'] . '">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-'.$args['name'].'" aria-controls="nav-'.$args['name'].'" aria-expanded="false" aria-label="Toggle navigation">';

				if ($doc->document->params->get('mobile_menu_text', '') != "")
				{
					$nav .= $doc->document->params->get('mobile_menu_text');
				}
				else
				{
					$nav .= '<span class="navbar-toggler-icon"></span>';
				}

				$nav .= '</button>
                            <div class="collapse navbar-collapse" id="nav-'.$args['name'].'">
                                <jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" />
                            </div>
                        </div>
                    </nav>
                </div>
            </div>';

			}
			else {

				$nav =
					'<div class="'.$args['wrapper'].'">
				<div class="' . $args['containerClass'] . '">
					<div id="'.$args['name'].'">
					    <nav class="navbar navbar-expand-lg ' . $args['wrapClass'] . '">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-'.$args['name'].'" aria-controls="nav-'.$args['name'].'" aria-expanded="false" aria-label="Toggle navigation">';

				if ($doc->document->params->get('mobile_menu_text', '') != "")
				{
					$nav .= $doc->document->params->get('mobile_menu_text');
				}
				else
				{
					$nav .= '<span class="navbar-toggler-icon"></span>';
				}

				$nav .=
					'</button>
                            <div class="collapse navbar-collapse" id="nav-'.$args['name'].'">
                                <jdoc:include type="modules" name="'.$args['name'].'" style="'.$args['style'].'" />
                            </div>
                        </nav>
                    </div>
                </div>
            </div>';

			}

		}

		return $nav;
	}
}
