<?php
/**
 * @package     Wright
 * @subpackage  Modules
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Wright Featured Module
 * (i.e. <w:module name="position" chrome="wrightfeatured" extraclass="{optional}" />
 */

$module         = $displayData['module'];
$params         = $displayData['params'];
$attribs        = $displayData['attribs'];

//$modulePos      = $module->position;
//$moduleTag      = $params->get('module_tag', 'div');
//$headerTag      = htmlspecialchars($params->get('header_tag', 'h4'));
//$headerClass    = htmlspecialchars($params->get('header_class', ''));

if ($module->content) :

    $class = $params->get('moduleclass_sfx');
    $extradivs = explode(',',$attribs['extradivs']);
    $extraclass = ($attribs['extraclass'] != '' ? ' ' . $attribs['extraclass'] : '');
    ?>
    <?php
    $img = '';
    $h4 = '';
    $linkTitle = '';
    $featuredLinkImg = (preg_match("/featured-link-img/", $class)) ? true : false ;

    if (preg_match("/featured/", $class)) {
        $classold = $class;
        $class = preg_replace("/featured/", "", $class);
        $params->set('moduleclass_sfx',$class);
        if (preg_match('/<a([^>]*)href=\"([^\"]*)\"([^>]*)>Title<\/a>/i', $module->content, $matches)) {
            $module->content = preg_replace('/<a([^>]*)href=\"([^\"]*)\"([^>]*)>Title<\/a>/i', '', $module->content, 1);
            $linkTitle = $matches[2];
        }
        if (preg_match('/<img([^>]*)>/i', $module->content, $matches)) {
            $module->content = preg_replace('/<img([^>]*)>/i', '', $module->content, 1);
            if($featuredLinkImg && $linkTitle != '')
                $img = '<div class="wrightmodule-imgfeatured">'.'<a href="'.$linkTitle.'">'.'<img' . $matches[1] . '>'.'</a>'.'</div>';
            else
                $img = '<div class="wrightmodule-imgfeatured">'.'<img' . $matches[1] . '>'.'</div>';
        }
        if (preg_match('/<h4([^>]*)>(.+?)<\/h4>/ims', $module->content, $matches)) {
            $module->content = preg_replace('/<h4([^>]*)>(.+?)<\/h4>/ims', '', $module->content, 1);
            $h4 = '<h4' . $matches[1] . ' class="wrightmodule-subtitle">' . $matches[2] . '</h4>';
        }
    }
    ?>
    <div class="moduletable<?php echo $class; ?><?php if (!$module->showtitle) : ?> no_title<?php endif; ?><?php echo $extraclass ?>">
        <?php
        echo $img;
        echo "<div class=\"wrightmodule-content\">";
        echo $h4;
        if ($module->showtitle) {
            if (in_array('title',$extradivs)) : ?> <div class="module_title"> <?php endif;
            echo "<h3>" . ($linkTitle != "" ? "<a href='$linkTitle'>" : "") . $module->title . ($linkTitle != "" ? "</a>" : "") . "</h3>";
            if (in_array('in-title',$extradivs)) : ?> <div class="module_title_in"></div> <?php endif;
            if (in_array('title',$extradivs)) : ?> </div> <?php endif;
        }
        echo $module->content;
        echo "</div>";
        ?>
    </div>

<?php endif; ?>