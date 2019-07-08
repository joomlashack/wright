<?php
/**
 * @package     Wright
 * @subpackage  Template File
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Wright Scss Compiler class
 *
 * @package     Wright
 * @subpackage  Main Package
 * @since       4.0
 */

require_once 'scssphp/scss.inc.php';

use ScssPhp\ScssPhp\Compiler;

class WrightScssCompiler {

    public function start($style, $scssCustomizationVars) {

        //var_dump($scssCustomizationVars);

        $scss = new Compiler();

        $ds = '';

        if ($scssCustomizationVars)
        {
            foreach ($scssCustomizationVars as $key => $value)
            {
                $ds .= $key . ': ' . $value . ';' . "\n";
            }
        }

        echo $scss->compile(
          $ds .
          'div { color: $link-color; }
        ');
    }
}