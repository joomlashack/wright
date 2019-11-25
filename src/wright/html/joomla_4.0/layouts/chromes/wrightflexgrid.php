<?php
/**
 * @package     Wright
 * @subpackage  Modules
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Wright Flex Grid
 * (i.e. <w:module type="{row/row-fluid}" name="position" chrome="wrightflexgrid" extradivs="{optional}" extraclass="{optional}" />
 */

$module         = $displayData['module'];
$params         = $displayData['params'];
$attribs        = $displayData['attribs'];

$headerTag      = htmlspecialchars($params->get('header_tag', 'h4'));
$moduleTag      = $params->get('module_tag', 'div');
$headerClass    = ' class="' . htmlspecialchars($params->get('header_class', '')) . '"';

$wright = Wright::getInstance();
$app = JFactory::getApplication();
$templatename = $app->getTemplate();

$document = JFactory::getDocument();
static $modulenumbera = Array();
if (!isset($modulenumbera[$attribs['name']]))
    $modulenumbera[$attribs['name']] = 1;

$spanWidth = $wright->getPositionAutospanWidth($attribs['name']);
$bootstrapSize = (int) $params->get('bootstrap_size', 0);
$robModules = JModuleHelper::getModules($attribs['name']);

$extradivs = explode(',',$attribs['extradivs']);
$extraclass = ($attribs['extraclass'] != '' ? ' ' . $attribs['extraclass'] : '');

$class = $params->get('moduleclass_sfx');
static $modulenumber = 1;
$matches = Array();
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
    // for 5 modules with col-md-2 first and last modules will have 3 columns width
    if (count($robModules) == 5 && $spanWidth == 2) {
        $spanWidth = 3;
    }
}

if (preg_match('/col-md-([0-9]{1,2})/', $class, $matches)) {
    // user assigned col-md- width in module parameters
    $params->set('moduleclass_sfx',preg_replace('/col-md-([0-9]{1,2})/', '', $class));
    $class = $params->get('moduleclass_sfx');
    $spanWidth = (int)$matches[1];
    $module->content = preg_replace('/<([^>]+)class="([^""]*)col-md-' . $spanWidth . '([^""]*)"([^>]*)>/sU', '<$1class="$2 $3"$4>', $module->content);
}

if ($bootstrapSize != 0)
{
    $params->set('moduleclass_sfx',preg_replace('/col-md-([0-9]{1,2})/', '', $class));
    $class = $params->get('moduleclass_sfx');
    $spanWidth = $bootstrapSize;
    $module->content = preg_replace('/<([^>]+)class="([^""]*)col-md-' . $spanWidth . '([^""]*)"([^>]*)>/sU', '<$1class="$2 $3"$4>', $module->content);
}

$featured = false;
$featuredLinkImg = (preg_match("/featured-link-img/", $class)) ? true : false ;
$featuredImg = '';
$featuredSubtitle = '';
$moduleTitle = '';
if (preg_match("/featured/", $class)) {
    $featured = true;
    $linkTitle = '';

    $classold = $class;
    $class = preg_replace("/featured/", "", $class);
    $params->set('moduleclass_sfx',$class);
    if (preg_match('/<a([^>]*)href=\"([^\"]*)\"([^>]*)>Title<\/a>/i', $module->content, $matches)) {
        $module->content = preg_replace('/<a([^>]*)href=\"([^\"]*)\"([^>]*)>Title<\/a>/i', '', $module->content, 1);
        $linkTitle = $matches[2];
        $moduleTitle = '<h3><a href="' . $linkTitle . '">' . $module->title . '</a></h3>';
    }
    if (preg_match('/<img([^>]*)>/i', $module->content, $matches)) {
        $module->content = preg_replace('/<img([^>]*)>/i', '', $module->content, 1);
        if ($featuredLinkImg && $linkTitle != '')
            $featuredImg = '<div class="wrightmodule-imgfeatured">'.'<a href="' . $linkTitle . '">'.'<img' . $matches[1] . '>'.'</a>'.'</div>';
        else
            $featuredImg = '<div class="wrightmodule-imgfeatured">'.'<img' . $matches[1] . '>'.'</div>';
    }
    if (preg_match('/<h4([^>]*)>(.+?)<\/h4>/ims', $module->content, $matches)) {
        $module->content = preg_replace('/<h4([^>]*)>(.+?)<\/h4>/ims', '', $module->content, 1);
        $featuredSubtitle = '<h4' . $matches[1] . ' class="wrightmodule-subtitle">' . $matches[2] . '</h4>';
    }
}

if ($moduleTitle == '')
    $moduleTitle = '<' . $headerTag . $headerClass . '>' . $module->title . '</' . $headerTag . '>';


$class .= ' mod_'.$modulenumbera[$attribs['name']];
$modulenumber++;
$modulenumbera[$attribs['name']]++;

?>
<div class="col-md-<?php echo $spanWidth ?>">
    <<?php echo $moduleTag ?> class="module<?php echo $class . $extraclass ?><?php if (!$module->showtitle) : ?> no_title<?php endif; ?>">

    <?php if (in_array('module',$extradivs)) : ?>
    <div class="module-inner">
        <?php
        endif;

        if ($featured)
            echo $featuredImg . '<div class="wrightmodule-content">' . $featuredSubtitle;

        if ($module->showtitle) : ?>
            <?php if (in_array('title',$extradivs)) : ?>	<div class="module_title"> <?php endif; ?>
            <?php echo $moduleTitle; ?>
            <?php if (in_array('in-title',$extradivs)) : ?> <div class="module_title_in"></div> <?php endif; ?>
            <?php if (in_array('title',$extradivs)) : ?>	</div> <?php endif; ?>
        <?php endif;

        if ($module->content) :

            $module->content = preg_replace('/<([^>]+)class="([^""]*)' . $params->get('moduleclass_sfx') . '([^""]*)"([^>]*)>/sU', '<$1class="$2$3"$4>', $module->content);
            echo $module->content;

        endif;

        if ($featured)
            echo '</div>';

        if (in_array('module',$extradivs)) : ?>
    </div>
<?php endif; ?>

</<?php echo $moduleTag ?>>
</div>