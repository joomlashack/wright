<?php

require_once "phing/Task.php";

class TemplateVersionTask extends Task {

	/**
	 * The file to generate
	 */
	private $todir = null;
	private $template = null;
	private $version = null;

	/**
	 * The setter for the attribute "template"
	 */
	public function setTemplate($str) {
		$this->template = $str;
	}
	
	/**
	 * The setter for the attribute "todir"
	 */
	public function setTodir($str) {
		$this->todir = $str;
	}
	public function setVersion($str) {
		$this->version = $str;
	}

    /**
     * The init method: Do init steps.
     */
    public function init() {
      // nothing to do here
    }
	
	protected function updateLanguageFile($fileName) {
		$file = file_get_contents($this->todir.'/language/' . $fileName);
		$file = str_replace('{version}', $this->version, $file);
		file_put_contents($this->todir.'/language/' . $fileName, $file);
		$this->log("Updated version in language file " . $fileName);
	}

    /**
     * The main entry point method.
     */
    public function main() {
	
		$fullpath = dirname(__FILE__);
		$path = str_replace('\\', '/', $fullpath);

		if (file_exists($this->todir . '/language/en-GB')) {
			$this->updateLanguageFile('en-GB/en-GB.tpl_' . $this->template . '.ini');
			$this->updateLanguageFile('en-GB/en-GB.tpl_' . $this->template . '.sys.ini');
		}
		if (file_exists($this->todir . '/language/es-ES')) {
			$this->updateLanguageFile('es-ES/es-ES.tpl_' . $this->template . '.ini');
			$this->updateLanguageFile('es-ES/es-ES.tpl_' . $this->template . '.sys.ini');
		}
		if (file_exists($this->todir . '/language/de-DE')) {
			$this->updateLanguageFile('de-DE/de-DE.tpl_' . $this->template . '.ini');
			$this->updateLanguageFile('de-DE/de-DE.tpl_' . $this->template . '.sys.ini');
		}

    }
}