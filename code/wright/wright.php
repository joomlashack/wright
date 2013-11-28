<?php

class Wright {

	public function display()
	{
		// Setup the header
		$this->header();

		// Parse by platform
		$this->platform();

		// Parse by doctype
		$this->doctype();

		print trim($this->template);

		return true;
	}

	protected function css() {
		$styles = $this->loadCSSList();
		$this->addCSSToHead($styles);
	}

}