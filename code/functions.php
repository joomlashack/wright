<?php
/**
 * @package     Wright
 * @subpackage  Functions
 *
 * @copyright   Copyright (C) 2005 - 2013 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Code for Joomla
if (defined('_JEXEC')) {

	//FIXME: move this to the Wright platform (joomla/wp) classes to improve abstraction

	// get the bootstrap row mode ( row / row-fluid )
	$gridMode = $this->params->get('bs_rowmode','row-fluid');
	$containerClass = 'container';
	if ($gridMode == 'row-fluid') {
	    $containerClass = 'container-fluid';
	}

	$responsivePage = $this->params->get('responsive','1');
	$responsive = ' responsive';
	if ($responsivePage == 0) {
	    $responsive = ' no-responsive';
	}
}

//Code for Wordpress
elseif(defined('ABSPATH')) {


	//kickstart the options page stuff
	require_once('wright-options.php');

	// **** Action Hooks ****

	//Add javascript resources
	function wright_wp_enqueue_scripts() {
		//get the WordpressWright instance
		$wright = WrightFactory::getInstance();
		$wright->generateJS();
	}
	add_action('wp_enqueue_scripts', 'wright_wp_enqueue_scripts');

	//Add style resources
	function wright_wp_enqueue_styles() {
		//get the WordpressWright instance
		$wright = WrightFactory::getInstance();
		//generate the <script> tags for src-based scripts
		$wright->generateStyles();
	}
	add_action('wp_enqueue_scripts', 'wright_wp_enqueue_styles');

	function wright_wp_head_action() {

		//get the WordpressWright instance
		$wright = WrightFactory::getInstance();

		//if javascript declarations should go in <head>, add them now
		if ( ! $wright->getOption('javascriptBottom')) {
			echo $wright->generateJSDeclarations();
		}

	}
	add_action('wp_head', 'wright_wp_head_action');

	function wright_wp_footer_action() {

		//get the WordpressWright instance
		$wright = WrightFactory::getInstance();

		//if javascript declarations should go at the bottom of the document, add them now
		if ($wright->getOption('javascriptBottom')) {
			echo $wright->generateJSDeclarations();
		}

	}
	add_action('wp_footer', 'wright_wp_footer_action');

}

else {
	die('Restricted access');
}
