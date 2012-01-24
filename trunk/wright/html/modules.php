<?php
defined('_JEXEC') or die('Restricted access');
require_once("suffixes.php");

/**
 * Wright GRID Module
 * (i.e. <jdoc:include type="modules" name="user3" grid="<?php echo $user3gridcount;?>" style="wrightgrid" />)
 */
function modChrome_wrightgrid($module, &$params, &$attribs) {
?>
<div class="module<?php echo $params->get( 'moduleclass_sfx' ); ?> grid_<?php echo $attribs['grid'] ?>">
  <?php if ($module->showtitle) : ?>
  <h3><?php echo $module->title; ?></h3>
  <?php endif; ?>
  <?php echo $module->content; ?>
</div>
<?php
}


/**
 * Wright GRID Module + Images
 * (i.e. <jdoc:include type="modules" name="user3" grid="<?php echo $user3gridcount;?>" style="wrightgridimages" />)
 */
function modChrome_wrightgridimages($module, &$params, &$attribs) {
	// stacked suffixes
	$icon = "";
	$iconposition = "";
	$gridwidth = "";

	// temporal application for simpleTech only (first template with icon and icon position)
    $app = &JFactory::getApplication();
	$templ = $app->getTemplate();
	if ($templ == "js_simpletech") {
		$suffix = $params->get('moduleclass_sfx');
		parse_suffix($suffix, $icon, $iconposition,$gridwidth);
		// suffix return to the parameters
		$params->set('moduleclass_sfx',$suffix);
		
		// checks if icon exists in wright/images/icons/modules
		if (!file_exists(JPATH_SITE.DS."templates".DS.$templ.DS."wright".DS."images".DS."icons".DS."modules".DS.$icon.".png")) {
			$icon = "";
		}
	}
	
?>
<div class="module<?php echo $params->get( 'moduleclass_sfx' ); ?> grid_<?php echo $attribs['grid'] ?><?php if($iconposition != "" && $icon != "") echo " icon-$iconposition" ?>">
  <div class="pad4">
  	<div class="pad5">
  		<div class="pad6"></div>
  	</div>
  </div>
  
  <div class="pad">
  	<div class="pad2">
  		<div class="pad3">
  			<div class="pad-title">
  <?php if ($module->showtitle) : ?>
  <h3><span><?php echo $module->title; ?></span></h3>
  <div class="clr"></div>
  <?php endif; ?>
  </div>
  
	<?php if ($icon != ""): ?>
		<div class="module_icon"><img width="48" height="48" src="<?php echo JRoute::_("templates/$templ/wright/images/icons/modules/$icon.png") ?>" alt="<?php echo $icon ?>" /></div>
		<div class="module_content">
	<?php endif; ?>
		<?php echo $module->content; ?>
	<?php if ($icon != ""): ?>
		</div>
	<?php endif; ?>
  
       </div>
  	</div> 
  </div>
  <div class="pad7">
  	<div class="pad8">
  		<div class="pad9"></div>
  	</div>
  </div>
</div>
<?php
}


/**
 * SHACK GRID + Rounded Corners
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="shackflexgridrounded" />)
 */
function modChrome_wrightgridrounded($module, &$params, &$attribs) {
	if (!$module->showtitle) {
		$moduletitle = ' notitle';
	} else {
		$moduletitle = NULL;
	}
?>
<div class="module<?php echo $params->get( 'moduleclass_sfx' ); ?> grid_<?php echo $attribs['grid']; ?>">
	<div class="side TL"></div>
	<div class="side TR"></div>
	<div class="side BL"></div>
	<div class="side BR"></div>
	<?php if ($module->showtitle) : ?>
		<h3><?php echo $module->title; ?></h3>
	<?php endif; ?>
		<div class="module_body<?php echo $moduletitle; ?>">
			<?php echo $module->content; ?>
		</div>
</div>
<?php
}

/**
 * SHACK FLEX GRID
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="shackflexgrid" />)
 */
function modChrome_wrightflexgrid($module, &$params, &$attribs) {
    $document = &JFactory::getDocument();
	static $modulenumbera = Array();
	if (!isset($modulenumbera[$attribs['name']]))
		$modulenumbera[$attribs['name']] = 1;
	
    static $modulenumber = 1;
    if (stripos($params->get('moduleclass_sfx'), 'flexgrid') === false) {
        $grid = $attribs['grid'];
        $class = $params->get('moduleclass_sfx');
    } else {
        $grid = preg_replace('/\D/', '', $params->get('moduleclass_sfx'));
        $class = '';
    }
	$class .= ' mod_'.$modulenumbera[$attribs['name']];
    $modulenumber++;
	if( $modulenumbera[$attribs['name']] == 1 ) {
        $class .= ' first';
    }
    if ( $modulenumbera[$attribs['name']] == $document->countModules( $attribs['name'] ) ) {
        $class .= ' last';
        $modulenumbera[$attribs['name']] = 0;
    }
    $modulenumbera[$attribs['name']]++;
?>
<div class="module<?php echo $class; ?> flexgrid_<?php echo $grid ?>">
  <div class="pad"> 
  	  <?php if ($module->showtitle) : ?>
  <h3><?php echo $module->title; ?></h3>
  <?php endif; ?>
  <?php echo $module->content; ?>
  </div>
</div>
<?php
}


/**
 * SHACK FLEX GRID + Images
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="shackflexgridimages" />)
 */
function modChrome_wrightflexgridimages($module, &$params, &$attribs) {
	// stacked suffixes
	$icon = "";
	$iconposition = "";
	$gridwidth = "";

	// temporal application for simpleTech only (first template with icon and icon position)
    $app = &JFactory::getApplication();
	$templ = $app->getTemplate();
	if ($templ == "js_simpletech") {
		$suffix = $params->get('moduleclass_sfx');
		parse_suffix($suffix, $icon, $iconposition,$gridwidth);
		// suffix return to the parameters
		$params->set('moduleclass_sfx',$suffix);
		
		// checks if icon exists in wright/images/icons/modules
		if (!file_exists(JPATH_SITE.DS."templates".DS.$templ.DS."wright".DS."images".DS."icons".DS."modules".DS.$icon.".png")) {
			$icon = "";
		}
	}

    $document = &JFactory::getDocument();
	static $modulenumbera = Array();
	if (!isset($modulenumbera[$attribs['name']]))
		$modulenumbera[$attribs['name']] = 1;
	
    static $modulenumber = 1;
    if (stripos($params->get('moduleclass_sfx'), 'flexgrid') === false) {
        $grid = $attribs['grid'];
        $class = $params->get('moduleclass_sfx');
    } else {
        $grid = preg_replace('/\D/', '', $params->get('moduleclass_sfx'));
        $class = '';
    }
	$class .= ' mod_'.$modulenumbera[$attribs['name']];
    $modulenumber++;
	if( $modulenumbera[$attribs['name']] == 1 ) {
        $class .= ' first';
    }
    if ( $modulenumbera[$attribs['name']] == $document->countModules( $attribs['name'] ) ) {
        $class .= ' last';
        $modulenumbera[$attribs['name']] = 0;
    }
    $modulenumbera[$attribs['name']]++;
?>
<div class="module<?php echo $class; ?> flexgrid_<?php echo ($gridwidth != "" ? $gridwidth : $grid) ?><?php if($iconposition != "" && $icon != "") echo " icon-$iconposition" ?>">
	<div class="pad4">
		<div class="pad5">
  		<div class="pad6"></div>
  	</div>
	</div>
	
	<div class="pad">
		<div class="pad2">
			<div class="pad3">
  				<?php if ($module->showtitle) : ?>
  					<div class="pad-title">
						<h3><span><?php echo $module->title; ?></span></h3>
					</div>  	
					<div class="clr"></div>		
  				<?php endif; ?>
  				<?php if ($icon != ""): ?>
  					<div class="module_icon"><img width="48" height="48" src="<?php echo JRoute::_("templates/$templ/wright/images/icons/modules/$icon.png") ?>" alt="<?php echo $icon ?>" /></div>
  					<div class="module_content">
  				<?php endif; ?>
			  		<?php echo $module->content; ?>
  				<?php if ($icon != ""): ?>
  					</div>
  				<?php endif; ?>
		  <div class="clr"></div>
  		</div>
  	 <div class="clr"></div>
   </div>
    </div>
    <div class="pad7">
    	<div class="pad8">
  		<div class="pad9"></div>
  	</div>
    </div>

</div>
<?php
}

/**
 * SHACK FLEX GRID + Rounded Corners
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="shackflexgridrounded" />)
 */
function modChrome_wrightflexgridrounded($module, &$params, &$attribs) {
	if (!$module->showtitle) {
		$moduletitle = ' notitle';
	} else {
		$moduletitle = NULL;
	}
?>
<div class="module<?php echo $params->get( 'moduleclass_sfx' ); ?> flexgrid_<?php echo $attribs['grid'] ?>">
	<div class="side TL"></div>
	<div class="side TR"></div>
	<div class="side BL"></div>
	<div class="side BR"></div>
	<?php if ($module->showtitle) : ?>
		<h3><?php echo $module->title; ?></h3>
	<?php endif; ?>
		<div class="module_body<?php echo $moduletitle; ?>">
			<?php echo $module->content; ?>
		</div>
</div>
<?php
}



/**
 * SHACK FLEX GRID + CSS3 Rounded
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="wrightCSS3" />)
 */
function modChrome_wrightCSS3($module, &$params, &$attribs) {
	if (!$module->showtitle) {
		$moduletitle = ' notitle';
	} else {
		$moduletitle = NULL;
	}
?>
<div class="module<?php echo $params->get( 'moduleclass_sfx' ); ?>">
	<div class="pad">
			<?php if ($module->showtitle) : ?>
				<h3><?php echo $module->title; ?></h3>
			<?php endif; ?>
			<?php echo $module->content; ?>
		</div>
</div>
<?php
}


/**
 * SHACK ROUNDED CORNER 1
 * (i.e. <jdoc:include type="modules" name="right" style="shackrounded" />)
 */
function modChrome_wrightrounded($module, &$params, &$attribs) {
?>
<div class="moduletable<?php echo $params->get( 'moduleclass_sfx' ); ?>">
<span class="tl"></span><span class="tr"></span>
    <div>
	<?php if ($module->showtitle) : ?>
  <h3><?php echo $module->title; ?></h3>
  <?php endif; ?>
  <?php echo $module->content; ?>
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
	if (!$module->showtitle) {
		$moduletitle = ' notitle';
	} else {
		$moduletitle = NULL;
	}
?>
<div class="moduletable<?php echo $params->get( 'moduleclass_sfx' ); ?>">
	<div class="side TL"></div>
	<div class="side TR"></div>
	<div class="side BL"></div>
	<div class="side BR"></div>
<?php if ($module->showtitle) : ?>
	<h3><?php echo $module->title; ?></h3>
<?php endif; ?>
	<div class="module_body<?php echo $moduletitle; ?>">
		<?php echo $module->content; ?>
	</div>
</div>
<?php
}
