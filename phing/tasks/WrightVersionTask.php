<?php

require_once "phing/Task.php";

class WrightVersionTask extends Task {

	/**
	 * The file to generate
	 */
	private $todir = null;
	private $version = null;

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
	
	protected function updateFile($fileName) {
		$file = file_get_contents($this->todir. $fileName);
		$file = str_replace('{version}', $this->version, $file);
		file_put_contents($this->todir. $fileName, $file);
		$this->log("Updated version in file " . $fileName);
	}

    /**
     * The main entry point method.
     */
    public function main() {
	
		$fullpath = dirname(__FILE__);
		$path = str_replace('\\', '/', $fullpath);

		if (file_exists($this->todir . '/wright/wright.php')) {
			$this->updateFile('/wright/wright.php');
		}

    }
}