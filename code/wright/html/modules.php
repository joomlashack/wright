<?php
defined('_JEXEC') or die('Restricted access');

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

            $matches = Array();
            if (preg_match('/span([0-9]{1,2})/', $modParams->get('moduleclass_sfx'), $matches)) {
                $modColumns = (int)$matches[1];
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
 * WRIGHT FLEX GRID
 * (i.e. <jdoc:include type="modules" name="user1" grid="<?php echo $user2gridcount;?>" style="wrightflexgrid" />)
 */
function modChrome_wrightflexgrid($module, &$params, &$attribs) {
    $app = JFactory::getApplication();
    $templatename = $app->getTemplate();

    $document = JFactory::getDocument();
    static $modulenumbera = Array();
    if (!isset($modulenumbera[$attribs['name']]))
        $modulenumbera[$attribs['name']] = 1;

    $spanWidth = getPositionAutospanWidth($attribs['name']);
    $robModules = JModuleHelper::getModules($attribs['name']);
	
	$extradivs = explode(',',$attribs['extradivs']);

	$class = $params->get('moduleclass_sfx');
    static $modulenumber = 1;
    $matches = Array();
    if (preg_match('/span([0-9]{1,2})/', $params->get('moduleclass_sfx'), $matches)) {
        // user assigned span width in module parameters
        $params->set('moduleclass_sfx',preg_replace('/span([0-9]{1,2})/', '', $params->get('moduleclass_sfx')));
        $class = $params->get('moduleclass_sfx');
        $spanWidth = (int)$matches[1];
        $module->content = preg_replace('/<div class="([^""]*)span' . $spanWidth . '([^""]*)"([^>]*)>/sU', '<div class="$1 $2"$3>', $module->content);
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
<div class="module<?php echo $class; ?> <?php if (!$module->showtitle) : ?>no_title <?php endif; ?>span<?php echo ($spanWidth) ?>">
<?php if ($module->showtitle) : ?>
	<?php if (in_array('title',$extradivs)) : ?>	<div class="module_title"> <?php endif; ?>
		<h3><?php echo $module->title; ?></h3>		
	<?php if (in_array('title',$extradivs)) : ?>	</div> <?php endif; ?>
<?php endif; ?>
<?php
echo $module->content;
?>
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
