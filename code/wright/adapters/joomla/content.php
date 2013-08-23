<?php

class WrightAdapterJoomlaContent
{
	public function render($args)
	{
		$content = '';

		// Checks queue for messages
		$messages = JFactory::getApplication()->getMessageQueue();
		if (is_array($messages) && !empty($messages)) {
			$content .= '<div class="alert">';
			$content .= '<a href="#" class="close" data-dismiss="alert">&times;</a>';
			$content .= '<jdoc:include type="message" />';
			$content .= '</div>';
		}


		$content .= '<jdoc:include type="component" />';
		
		return $content;
	}
}
