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

    /**
     * Get an instance of this file
     *
     * @return  void
     */
    public static function getInstance()
    {
        static $instance = null;

        if ($instance === null)
        {
            $instance = new Wright;
        }

        return $instance;
    }

    /**
     * Inserts a file in the files array if it exists
     * If it's a version-dependent check, it checks multiple Joomla versions using the major version
     *
     * @param   string  &$files      Array of files
     * @param   string  $file        File to check/add
     * @param   string  $versionDep  Decide if it's version-dependent
     *
     * @return  array
     */
    protected function checkAddFile(&$files, $file, $versionDep = false)
    {
        if (file_exists($file))
        {
            $files[] = $file;
        }
    }

    /**
     * Get the actual scss files that will get processed depending on the selected style
     *
     * @param   string   $style          Selected style being processed
     * @param   string   $joomlaVersion  Joomla version in two digits (major, minor)
     *
     * @return  array
     */
    protected function getScssCode($style, $joomlaVersion)
    {
        $document   = JFactory::getDocument();
        $files      = array();

        $scssTemplatePath   = JPATH_THEMES . '/' . $document->template . '/scss';
        $scssWrightPath     = JPATH_THEMES . '/' . $document->template . '/wright/build/scss';

        $this->checkAddFile($files, $scssWrightPath . '/_beforevars.scss');
        $this->checkAddFile($files, $scssTemplatePath . '/variables-' . $style . '.scss');
        $this->checkAddFile($files, $scssWrightPath . '/_aftervars.scss');
        $this->checkAddFile($files, $scssTemplatePath . '/style-' . $style . '.scss');

        return $files;
    }

    /**
     * Run the compilation process
     *
     * @param   array   $scssFiles          Array of scss files to include in compilation
     * @param   string  $cssOutputFile      Compiled css file
     * @param   string  $scssVarsOverrides  SCSS variables to override
     *
     * @return  void
     */
    protected function compileWrightFile($scssFiles, $cssOutputFile, $scssVarsOverrides = false)
    {
        $document   = JFactory::getDocument();
        $ds         = '';

        // Override SCSS variables
        if ($scssVarsOverrides)
        {
            foreach ($scssVarsOverrides as $key => $value)
            {
                $ds .= $key . ': ' . $value . ';' . "\n";
            }
        }

        // The rest of the files
        if ($scssFiles)
        {
            foreach ($scssFiles as $file)
            {
                //$ds .= '@import "' . $file . '";' . "\n";
                $ds .= file_get_contents($file) . "\n";
            }
        }

        $scss = new Compiler();
        if ($scssVarsOverrides)
        {
            $scss->setVariables($scssVarsOverrides);
        }

        $scss->setFormatter('ScssPhp\ScssPhp\Formatter\Compressed');
        $scss->setImportPaths(
            array(
                JPATH_THEMES . '/' . $document->template . '/wright/build/scss/',
                JPATH_THEMES . '/' . $document->template . '/scss/'
            )
        );

        file_put_contents(
            $cssOutputFile,
            $scss->compile($ds)
        );
    }

    /**
     * Run the whole compilation process
     *
     * @param   string  $style                  The template style to use its SCSS files as base
     * @param   array   $scssCustomizationVars  SCSS vars to override
     *
     * @return  void
     */
    public function start($style, $scssCustomizationVars)
    {
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');

        $document           = JFactory::getDocument();
        $version            = explode('.', JVERSION);
        $joomlaVersion      = $version[0] . '0';
        $cssPath            = JPATH_THEMES . '/' . $document->template . '/css';
        $scssFiles          = $this->getScssCode($style, $joomlaVersion);

        if ($scssFiles)
        {

            $this->compileWrightFile(
                $scssFiles,
                $cssPath . '/joomla-custom.css',
                $scssCustomizationVars
            );
        }
        else
        {
            echo '<div class="wStatusError">Error: CSS or SCSS files are missing! (1)</div>';
            return false;
        }

        echo '<div class="wStatusSuccess">' . JText::_('TPL_JS_WRIGHT_COMPILE_SCSS_SUCCESS') . '</div>';
    }
}