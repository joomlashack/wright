<?php
/**
 * @package     Wright
 * @subpackage  Template File
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Wright Less Compiler class
 *
 * @package     Wright
 * @subpackage  Main Package
 * @since       3.1
 */
class WrightLessCompiler
{
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
	 * Get the actual less files that will get processed depending on the selected style
	 *
	 * @param   string   $style          Selected style being processed
	 * @param   string  $joomlaVersion  Joomla version in two digits (major, minor)
	 * @param   bool     $responsive     Whether it's for the responsive or the main css file (responsive = false)
	 *
	 * @return  array
	 */
	protected function getLessFiles($style, $joomlaVersion, $responsive = false)
	{
		$document = JFactory::getDocument();
		$files = array();

		$lessPath = JPATH_THEMES . '/' . $document->template . '/less';
		$wrightBuildPath = JPATH_THEMES . '/' . $document->template . '/wright/build';

		if (file_exists($lessPath . '/variables-' . $style . '.less'))
		{
			if ($responsive)
			{
				$this->checkAddFile($files, $lessPath . '/variables-' . $style . '.less');
				$this->checkAddFile($files, $wrightBuildPath . '/less/responsive.less');
				$this->checkAddFile($files, $wrightBuildPath . '/less/joomla-responsive.less');
				$this->checkAddFile($files, $wrightBuildPath . '/less/joomla' . $joomlaVersion . '-responsive.less');
				$this->checkAddFile($files, $lessPath . '/template-responsive.less');
				$this->checkAddFile($files, $lessPath . '/style-' . $style . '-responsive.less');
			}
			else
			{
				$this->checkAddFile($files, $lessPath . '/variables-' . $style . '.less');
				$this->checkAddFile($files, $wrightBuildPath . '/less/bootstrap.less');
				$this->checkAddFile($files, $lessPath . '/template.less');
				$this->checkAddFile($files, $wrightBuildPath . '/libraries/bootstrap/less/mixins.less');
				$this->checkAddFile($files, $wrightBuildPath . '/less/typography.less');
				$this->checkAddFile($files, $wrightBuildPath . '/less/joomla.less');
				$this->checkAddFile($files, $wrightBuildPath . '/less/joomla' . $joomlaVersion . '.less');
				$this->checkAddFile($files, $lessPath . '/style-' . $style . '.less');
			}
		}

		return $files;
	}

	/**
	 * Get the actual css files that will get generated depending on the Joomla version and selected style
	 *
	 * @param   string   $style          Selected style being processed
	 * @param   straing  $joomlaVersion  Joomla version in two digits (major, minor)
	 * @param   bool     $responsive     Whether it's for the responsive or the main css file (responsive = false)
	 *
	 * @return  array
	 */
	protected function getCSSFiles($style, $joomlaVersion, $responsive = false)
	{
		$document = JFactory::getDocument();
		$files = array();
		$cssPath = JPATH_THEMES . '/' . $document->template . '/css';

		if ($responsive)
		{
			$this->checkAddFile($files, $cssPath . '/joomla' . $joomlaVersion . '-' . $style . '-responsive.css');
		}
		else
		{
			$this->checkAddFile($files, $cssPath . '/style-' . $style . '.css');
			$this->checkAddFile($files, $cssPath . '/joomla' . $joomlaVersion . '-' . $style . '-extended.css');
		}

		return $files;
	}

	/**
	 * Get the most recent changed time for a bunch of times
	 *
	 * @param   array  $files  Array of files - it can be empty
	 *
	 * @return  int
	 */
	protected function getMaxFileTime($files)
	{
		$maxTime = 0;

		if ($files)
		{
			foreach ($files as $file)
			{
				$fileTime = filemtime($file);

				if ($fileTime > $maxTime)
				{
					$maxTime = $fileTime;
				}
			}
		}

		return $maxTime;
	}

	/**
	 * Run the compilation process
	 *
	 * @param   array   $lessFiles  Array of less files to include in compilation
	 * @param   string  $cssFile    Compiled css file
	 * 
	 * @return  void
	 */
	protected function compileWrightFile($lessFiles, $cssFile, $lessVarsFile = false, $lessVarsOverrides = false)
	{
		$document = JFactory::getDocument();
		$df = JPATH_THEMES . '/' . $document->template . '/less/build.less';
		$ds = '';

		if (file_exists($df))
		{
			unlink($df);
		}

		// Variable files only. Always loads as first
		if ($lessVarsFile)
		{
		    if (file_exists($lessVarsFile))
		    {
		        $ds .= '@import "' . $lessVarsFile . '";' . "\n";
		    }
		}

		// Override variables from $lessVarsFiles
		if ($lessVarsOverrides)
		{
		    foreach ($lessVarsOverrides as $key => $value)
		    {
		        $ds .= $key . ': ' . $value . ';' . "\n";
		    }
		}

		// The rest of the files
		if ($lessFiles)
		{
		    foreach ($lessFiles as $file)
		    {
		        if (file_exists($file))
		        {
		            $ds .= '@import "' . $file . '";' . "\n";
		        }
		    }
		}

		file_put_contents($df, $ds);
		$styleCompiler = new lessc;

		// Less vars coming from a PHP file to override variables from the variable less file
		if ($lessVarsOverrides)
		{
		    $styleCompiler->setVariables($lessVarsOverrides);
		}

		$styleCompiler->setFormatter("compressed");
		$styleCompiler->compileFile($df, $cssFile);
		unlink($df);
	}

	/**
	 * Run the whole compilation process
	 *
     * @param   string  $style                  The template style to use its LESS files as base
     * @param   array   $lessCustomizationVars  LESS vars to override
     *
	 * @return  void
	 */
	public function start($style, $lessCustomizationVars)
	{
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		$document = JFactory::getDocument();

		$version = explode('.', JVERSION);
		$joomlaVersion = $version[0] . '0';

		$lessPath           = JPATH_THEMES . '/' . $document->template . '/less';
		$lessCustomization  = $lessPath . '/customization.php';
		$cssPath            = JPATH_THEMES . '/' . $document->template . '/css';
		$wrightBuildPath    = JPATH_THEMES . '/' . $document->template . '/wright/build';

		$lessFiles = $this->getLessFiles($style, $joomlaVersion);
		$cssFiles = $this->getCSSFiles($style, $joomlaVersion);

		if ($cssFiles && $lessFiles)
		{

			$this->compileWrightFile(
				array(
					$wrightBuildPath . '/less/bootstrap.less'
				),
				$cssPath . '/style-custom.css',
				$lessPath . '/variables-' . $style . '.less',
				$lessCustomizationVars
			);

			$this->compileWrightFile(
				array(
					$wrightBuildPath . '/libraries/bootstrap/less/mixins.less',
					$wrightBuildPath . '/less/typography.less',
					$wrightBuildPath . '/less/joomla.less',
					$wrightBuildPath . '/less/joomla' . $joomlaVersion . '.less',
					$lessPath . '/template.less',
					$lessPath . '/style-' . $style . '.less'
				),
                $cssPath . '/joomla' . $joomlaVersion . '-custom-extended.css',
                $lessPath . '/variables-' . $style . '.less',
                $lessCustomizationVars
			);
		}
        else
        {
            echo '<div class="wStatusError">Error: CSS or LESS files are missing! (1)</div>';
            return false;
        }

		$lessFiles = $this->getLessFiles($style, $joomlaVersion, true);
		$cssFiles = $this->getCSSFiles($style, $joomlaVersion, true);

		if ($cssFiles && $lessFiles)
		{

			$this->compileWrightFile(
				array(
					$wrightBuildPath . '/less/responsive.less',
					$wrightBuildPath . '/less/joomla-responsive.less',
					$wrightBuildPath . '/less/joomla' . $joomlaVersion . '-responsive.less',
					$lessPath . '/template-responsive.less',
					$lessPath . '/style-' . $style . '-responsive.less'
				),
				$cssPath . '/joomla' . $joomlaVersion . '-custom-responsive.css',
				$lessPath . '/variables-' . $style . '.less',
				$lessCustomizationVars
			);
		}
        else
        {
            echo '<div class="wStatusError">Error: CSS or LESS files are missing! (2)</div>';
            return false;
        }

        echo '<div class="wStatusSuccess">' . JText::_('TPL_JS_WRIGHT_COMPILE_LESS_SUCCESS') . '</div>';
	}
}
