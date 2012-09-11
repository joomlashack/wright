<?php
defined('_JEXEC') or die('Restricted access');
require_once("suffixes.php");

jimport('joomla.application.module.helper');

/**
 * Determines the autospan column width for a module position
 * @param string $position - desired position to check
 * @return number - column width for the generated spans
 */
function getPositionAutospanWidth($position) {
    $robModules = JModuleHelper::getModules($position);
    $maxColumns = 12;
    $availableColumns = $maxColumns;
    $autospanModules = count($robModules);
    if ($robModules) {
        foreach ( $robModules as $robModule ) {
            $modParams = new JRegistry($robModule->params);
            // module width has been fixed?
            if (stripos($modParams->get('moduleclass_sfx'), 'span')) {
                $modColumns = preg_replace('/\D/', '', $modParams->get('moduleclass_sfx'));
                $availableColumns -= $modColumns;
                $autospanModules--;
            }
        }
    }

    // calculate the span width ( columns / modules)
    if ($autospanModules <= 0 ) $autospanModules = 1;
    $spanWidth = $availableColumns / $autospanModules;
    return (int)$spanWidth;
}

/**
 * Wright GRID Module
 * (i.e. <jdoc:include type="modules" name="user3" grid="<?php echo $user3gridcount;?>" style="wrightgrid" />)
 */
function modChrome_wrightgrid($module, &$params, &$attribs) {
	// stacked suffixes (only if template allows it)
	$suffixes = false;
	$specialClasses = Array();
	$specialClassesResult = Array();
	if (class_exists("WrightTemplate")) {
		$wrightTemplate = WrightTemplate::getInstance();
		$suffixes = $wrightTemplate->suffixes;
		if (property_exists("WrightTemplate", "specialClasses"))
			$specialClasses = $wrightTemplate->specialClasses;
	}
	$icon = "";
	$iconposition = "";
	$gridwidth = "";
	$specialClassesString = "";

	$origsuffix = $params->get('moduleclass_sfx');
	$suffix = $origsuffix;

	$app = JFactory::getApplication();
	$templatename = $app->getTemplate();
	if ($suffixes) {
		parse_suffix($suffix, $icon, $iconposition,$gridwidth,$specialClasses,$specialClassesResult);
		// suffix return to the parameters
		$params->set('moduleclass_sfx',$suffix);

		// checks if icon exists in wright/images/icons/modules
		if (!file_exists(JPATH_SITE.'/'."templates".'/'.$templatename.'/'."wright".'/'."images".'/'."icons".'/'."modules".'/'.$icon.".png")) {
			$icon = "";
		}

		foreach ($specialClassesResult as $class => $result) {
			$specialClassesString .= " " . $class . "_" . $result;
		}
	}
?>
<div class="module<?php echo $params->get( 'moduleclass_sfx' ); ?> grid<?php echo (isset($attribs['grid']) ? "_" . $attribs['grid'] : "") ?><?php if($iconposition != "" && $icon != "") echo " icon-$iconposition" ?><?php echo $specialClassesString ?>">
  <?php if ($module->showtitle) : ?>
  <h3><?php echo $module->title; ?></h3>
  <?php endif; ?>
	<?php if ($icon != ""): ?>
		<div class="module_icon"><img width="48" height="48" src="<?php echo JRoute::_("templates/$templatename/wright/images/icons/modules/$icon.png") ?>" alt="<?php echo $icon ?>" /></div>
		<div class="module_content">
	<?php endif; ?>
		<?php
			// replaces only the first appearance of the original suffix (for the module class)
			if ($origsuffix != $suffix) {
				$pos = strpos($module->content,$origsuffix);
				if ($pos !== false) {
				    $module->content = substr_replace($module->content,$suffix,$pos,strlen($origsuffix));
				}
			}
			echo $module->content;
		?>
	<?php if ($icon != ""): ?>
		</div>
	<?php endif; ?>
</div>
<?php
}

/**
 * SHACK FLEX GRID
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="shackflexgrid" />)
 */
function modChrome_wrightflexgrid($module, &$params, &$attribs) {
    // stacked suffixes (only if template allows it)
    $suffixes = false;
    $specialClasses = Array();
    $specialClassesResult = Array();
    if (class_exists("WrightTemplate")) {
        $wrightTemplate = WrightTemplate::getInstance();
        $suffixes = $wrightTemplate->suffixes;
        if (property_exists("WrightTemplate", "specialClasses"))
            $specialClasses = $wrightTemplate->specialClasses;
    }
    $icon = "";
    $iconposition = "";
    $gridwidth = "";
    $specialClassesString = "";
    $origsuffix = $params->get('moduleclass_sfx');
    $suffix = $origsuffix;

    $app = JFactory::getApplication();
    $templatename = $app->getTemplate();
    if ($suffixes) {
        parse_suffix($suffix, $icon, $iconposition,$gridwidth,$specialClasses,$specialClassesResult);
        // suffix return to the parameters
        $params->set('moduleclass_sfx',$suffix);

        // checks if icon exists in wright/images/icons/modules
        if (!file_exists(JPATH_SITE.'/'."templates".'/'.$templatename.'/'."wright".'/'."images".'/'."icons".'/'."modules".'/'.$icon.".png")) {
            $icon = "";
        }

        foreach ($specialClassesResult as $class => $result) {
            $specialClassesString .= " " . $class . "_" . $result;
        }
    }

    $document = JFactory::getDocument();
    static $modulenumbera = Array();
    if (!isset($modulenumbera[$attribs['name']]))
        $modulenumbera[$attribs['name']] = 1;

    $spanWidth = getPositionAutospanWidth($attribs['name']);
    $robModules = JModuleHelper::getModules($attribs['name']);


    static $modulenumber = 1;
    if (stripos($params->get('moduleclass_sfx'), 'span') === false) {
        $grid = '';
        if (isset($attribs['grid']))
            $grid = $attribs['grid'];
        $class = $params->get('moduleclass_sfx');
    // user assigned span width in module parameters
    } else {
        $grid = preg_replace('/\D/', '', $params->get('moduleclass_sfx'));
        $class = '';
        $spanWidth = $grid;
    }

    $class .= ' mod_'.$modulenumbera[$attribs['name']];
    $modulenumber++;
    if( $modulenumbera[$attribs['name']] == 1 ) {
        $class .= ' first';
        // for 5 modules with span2 first and last modules will have 3 columns width
        if (count($robModules) == 5 && $spanWidth == 2) {
        	$spanWidth = 3;
        }
    }
    if ( $modulenumbera[$attribs['name']] == $document->countModules( $attribs['name'] ) ) {
        $class .= ' last';
        $modulenumbera[$attribs['name']] = 0;
        // for 5 modules with span2 first and last modules will have 3 columns width
        if (count($robModules) == 5 && $spanWidth == 2) {
        	$spanWidth = 3;
        }
    }
    $modulenumbera[$attribs['name']]++;
    ?>
<div class="module<?php echo $class; ?> span<?php echo $spanWidth ?><?php if($iconposition != "" && $icon != "") echo " icon-$iconposition" ?><?php echo $specialClassesString ?>">
<?php if ($module->showtitle) : ?>
<h3><?php echo $module->title; ?></h3>
<?php endif; ?>
<?php if ($icon != ""): ?>
<div class="module_icon"><img width="48" height="48" src="<?php echo JRoute::_("templates/$templatename/wright/images/icons/modules/$icon.png") ?>" alt="<?php echo $icon ?>" /></div>
<div class="module_content">
<?php endif; ?>
<?php
// replaces only the first appearance of the original suffix (for the module class)
if ($origsuffix != $suffix) {
$pos = strpos($module->content,$origsuffix);
if ($pos !== false) {
$module->content = substr_replace($module->content,$suffix,$pos,strlen($origsuffix));
}
}
echo $module->content;
?>
<?php if ($icon != ""): ?>
</div>
<?php endif; ?>
</div>
<?php
}


/**
 * SHACK FLEX GRID + CSS3 Rounded
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="wrightCSS3" />)
 */
function modChrome_wrightCSS3($module, &$params, &$attribs) {
	// stacked suffixes (only if template allows it)
	$suffixes = false;
	$specialClasses = Array();
	$specialClassesResult = Array();
	if (class_exists("WrightTemplate")) {
		$wrightTemplate = WrightTemplate::getInstance();
		$suffixes = $wrightTemplate->suffixes;
		if (property_exists("WrightTemplate", "specialClasses"))
			$specialClasses = $wrightTemplate->specialClasses;
	}
	$icon = "";
	$iconposition = "";
	$gridwidth = "";
	$specialClassesString = "";
	$origsuffix = $params->get('moduleclass_sfx');
	$suffix = $origsuffix;

	$app = JFactory::getApplication();
	$templatename = $app->getTemplate();
	if ($suffixes) {
		parse_suffix($suffix, $icon, $iconposition,$gridwidth,$specialClasses,$specialClassesResult);
		// suffix return to the parameters
		$params->set('moduleclass_sfx',$suffix);

		// checks if icon exists in wright/images/icons/modules
		if (!file_exists(JPATH_SITE.'/'."templates".'/'.$templatename.'/'."wright".'/'."images".'/'."icons".'/'."modules".'/'.$icon.".png")) {
			$icon = "";
		}

		foreach ($specialClassesResult as $class => $result) {
			$specialClassesString .= " " . $class . "_" . $result;
		}
	}

	if (!$module->showtitle) {
		$moduletitle = ' notitle';
	} else {
		$moduletitle = NULL;
	}

	if (!$module->showtitle) {
		$moduletitle = ' notitle';
	} else {
		$moduletitle = NULL;
	}
?>
<div class="module<?php echo $params->get( 'moduleclass_sfx' ); ?><?php if($iconposition != "" && $icon != "") echo " icon-$iconposition" ?><?php echo $specialClassesString ?>">
	<div class="pad">
			<?php if ($module->showtitle) : ?>
				<h3><?php echo $module->title; ?></h3>
			<?php endif; ?>
			<?php if ($icon != ""): ?>
				<div class="module_icon"><img width="48" height="48" src="<?php echo JRoute::_("templates/$templatename/wright/images/icons/modules/$icon.png") ?>" alt="<?php echo $icon ?>" /></div>
				<div class="module_content">
			<?php endif; ?>
			<?php
				// replaces only the first appearance of the original suffix (for the module class)
				if ($origsuffix != $suffix) {
					$pos = strpos($module->content,$origsuffix);
					if ($pos !== false) {
					    $module->content = substr_replace($module->content,$suffix,$pos,strlen($origsuffix));
					}
				}
				echo $module->content;
			?>
			<?php if ($icon != ""): ?>
				</div>
			<?php endif; ?>
		</div>
</div>
<?php
}


/**
 * SHACK ROUNDED CORNER 1
 * (i.e. <jdoc:include type="modules" name="right" style="shackrounded" />)
 */
function modChrome_wrightrounded($module, &$params, &$attribs) {
	// stacked suffixes (only if template allows it)
	$suffixes = false;
	$specialClasses = Array();
	$specialClassesResult = Array();
	if (class_exists("WrightTemplate")) {
		$wrightTemplate = WrightTemplate::getInstance();
		$suffixes = $wrightTemplate->suffixes;
		if (property_exists("WrightTemplate", "specialClasses"))
			$specialClasses = $wrightTemplate->specialClasses;
	}
	$icon = "";
	$iconposition = "";
	$gridwidth = "";
	$specialClassesString = "";
	$origsuffix = $params->get('moduleclass_sfx');
	$suffix = $origsuffix;

	$app = JFactory::getApplication();
	$templatename = $app->getTemplate();
	if ($suffixes) {
		parse_suffix($suffix, $icon, $iconposition,$gridwidth,$specialClasses,$specialClassesResult);
		// suffix return to the parameters
		$params->set('moduleclass_sfx',$suffix);

		// checks if icon exists in wright/images/icons/modules
		if (!file_exists(JPATH_SITE.'/'."templates".'/'.$templatename.'/'."wright".'/'."images".'/'."icons".'/'."modules".'/'.$icon.".png")) {
			$icon = "";
		}

		foreach ($specialClassesResult as $class => $result) {
			$specialClassesString .= " " . $class . "_" . $result;
		}
	}
?>
<div class="moduletable<?php echo $params->get( 'moduleclass_sfx' ); ?><?php if($iconposition != "" && $icon != "") echo " icon-$iconposition" ?><?php echo $specialClassesString ?>">
<span class="tl"></span><span class="tr"></span>
    <div>
	<?php if ($module->showtitle) : ?>
  <h3><?php echo $module->title; ?></h3>
  <?php endif; ?>
	<?php if ($icon != ""): ?>
		<div class="module_icon"><img width="48" height="48" src="<?php echo JRoute::_("templates/$templatename/wright/images/icons/modules/$icon.png") ?>" alt="<?php echo $icon ?>" /></div>
		<div class="module_content">
	<?php endif; ?>

		<?php
			// replaces only the first appearance of the original suffix (for the module class)
			if ($origsuffix != $suffix) {
				$pos = strpos($module->content,$origsuffix);
				if ($pos !== false) {
				    $module->content = substr_replace($module->content,$suffix,$pos,strlen($origsuffix));
				}
			}
			echo $module->content;
		?>

	<?php if ($icon != ""): ?>
		</div>
	<?php endif; ?>
  </div>
  <span class="bl"></span><span class="br"></span>
</div>
<?php
}

/**
 * SHACK ROUNDED CORNER 2
 * (i.e. <jdoc:include type="modules" name="right" style="shackrounded"2 />)
 */
function modChrome_wrightrounded2($module, &$params, &$attribs) {
	// stacked suffixes (only if template allows it)
	$suffixes = false;
	$specialClasses = Array();
	$specialClassesResult = Array();
	if (class_exists("WrightTemplate")) {
		$wrightTemplate = WrightTemplate::getInstance();
		$suffixes = $wrightTemplate->suffixes;
		if (property_exists("WrightTemplate", "specialClasses"))
			$specialClasses = $wrightTemplate->specialClasses;
	}
	$icon = "";
	$iconposition = "";
	$gridwidth = "";
	$specialClassesString = "";
	$origsuffix = $params->get('moduleclass_sfx');
	$suffix = $origsuffix;

	$app = JFactory::getApplication();
	$templatename = $app->getTemplate();
	if ($suffixes) {
		parse_suffix($suffix, $icon, $iconposition,$gridwidth,$specialClasses,$specialClassesResult);
		// suffix return to the parameters
		$params->set('moduleclass_sfx',$suffix);

		// checks if icon exists in wright/images/icons/modules
		if (!file_exists(JPATH_SITE.'/'."templates".'/'.$templatename.'/'."wright".'/'."images".'/'."icons".'/'."modules".'/'.$icon.".png")) {
			$icon = "";
		}

		foreach ($specialClassesResult as $class => $result) {
			$specialClassesString .= " " . $class . "_" . $result;
		}
	}

	if (!$module->showtitle) {
		$moduletitle = ' notitle';
	} else {
		$moduletitle = NULL;
	}
?>
<div class="moduletable<?php echo $params->get( 'moduleclass_sfx' ); ?><?php if($iconposition != "" && $icon != "") echo " icon-$iconposition" ?><?php echo $specialClassesString ?>">
	<div class="side TL"></div>
	<div class="side TR"></div>
	<div class="side BL"></div>
	<div class="side BR"></div>
<?php if ($module->showtitle) : ?>
	<h3><?php echo $module->title; ?></h3>
<?php endif; ?>
	<div class="module_body<?php echo $moduletitle; ?>">
		<?php if ($icon != ""): ?>
			<div class="module_icon"><img width="48" height="48" src="<?php echo JRoute::_("templates/$templatename/wright/images/icons/modules/$icon.png") ?>" alt="<?php echo $icon ?>" /></div>
			<div class="module_content">
		<?php endif; ?>

		<?php
			// replaces only the first appearance of the original suffix (for the module class)
			if ($origsuffix != $suffix) {
				$pos = strpos($module->content,$origsuffix);
				if ($pos !== false) {
				    $module->content = substr_replace($module->content,$suffix,$pos,strlen($origsuffix));
				}
			}
			echo $module->content;
		?>

		<?php if ($icon != ""): ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php
}

function modChrome_wrightmenu($module, &$params, &$attribs) {

	// only force menus without the navbar class
	if ($module->module == 'mod_menu' && !substr_count($params->get('moduleclass_sfx'), ' navbar')) {

		// add the navbar class to the menus
		$params->set('moduleclass_sfx',$params->get('moduleclass_sfx') . ' navbar');
		$params->set('class_sfx',$params->get('class_sfx') . ' nav-dropdown');

		// force to show children items
		$params->set('showAllChildren', 1);

		$module->params = $params;
		$module->content = JModuleHelper::renderModule($module);
		modChrome_wrightflexgrid($module, $params, $attribs);
		//$attribs['style'] = 'wrightflexgrid';

	}
	else
	{
		modChrome_wrightflexgrid($module, $params, $attribs);
	}

}
