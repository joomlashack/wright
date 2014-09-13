<?php
/**
 * @package     Wright
 * @subpackage  Phing Tasks
 *
 * @copyright   Copyright (C) 2005 - 2014 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

require_once "phing/Task.php";

/**
 * Task to update Wright version and other template details
 *
 * @package     Wright
 * @subpackage  Phing Tasks
 * @since       3.0
 */
class TemplateDetailsTask extends Task
{
	/**
	 * The file to generate
	 */
	private $todir = null;

	private $version = null;

	private $templateName = null;

	private $documentationLink = null;

	/**
	 * Sets the destination file
	 *
	 * @param   string  $str  Destination file
	 *
	 * @return  void
	 */
	public function setTodir($str)
	{
		$this->todir = $str;
	}

	/**
	 * Sets Wright version
	 *
	 * @param   string  $str  Version
	 *
	 * @return  void
	 */
	public function setVersion($str)
	{
		$this->version = $str;
	}

	/**
	 * Sets the template name
	 *
	 * @param   string  $str  Template Name
	 *
	 * @return  void
	 */
	public function setTemplateName($str)
	{
		$this->templateName = $str;
	}

	/**
	 * Sets the documentation link
	 *
	 * @param   string  $str  Documentation link
	 *
	 * @return  void
	 */
	public function setDocumentationLink($str)
	{
		$this->documentationLink = $str;
	}

	/**
	 * The init method: Do init steps
	 *
	 * @return  void
	 */
	public function init()
	{
		// Nothing to do here
	}

	/**
	 * Updates the given file
	 *
	 * @param   string  $fileName  File to update
	 * @param   string  $variable  Variable to update
	 * @param   string  $data      Data to set instead of the variable
	 *
	 * @return  void
	 */
	protected function updateFile($fileName, $variable, $data)
	{
		$file = file_get_contents($this->todir . $fileName);
		$file = str_replace('{' . $variable . '}', $data, $file);
		file_put_contents($this->todir . $fileName, $file);
		$this->log('Updated ' . $variable . ' to ' . $data . ' in file ' . $fileName);
	}

	/**
	 * Main entry of this phing task
	 *
	 * @return  void
	 */
	public function main()
	{
		$fullpath = dirname(__FILE__);
		$path = str_replace('\\', '/', $fullpath);

		if (file_exists($this->todir . '/wright/wright.php'))
		{
			$this->updateFile('/wright/wright.php', 'version', $this->version);
		}

		if (file_exists($this->todir . '/wrighttemplate.php'))
		{
			$this->updateFile('/wrighttemplate.php', 'templateName', $this->templateName);
			$this->updateFile('/wrighttemplate.php', 'documentationLink', $this->documentationLink);
		}
	}
}
