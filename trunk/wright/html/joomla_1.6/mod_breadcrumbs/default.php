<?php
// no direct access
defined('_JEXEC') or die;
?>

<?php if ($params->get('showHere', 1))
	{
		echo JText::_('MOD_BREADCRUMBS_HERE');
	}
?>
<?php for ($i = 0; $i < $count; $i ++) :

	// If not the last item in the breadcrumbs add the separator
	if ($i < $count -1) {
		if (!empty($list[$i]->link)) {
			echo '<a href="'.$list[$i]->link.'" class="pathway">'.$list[$i]->name.'</a>';
		} else {
		    echo '<strong>';
			echo $list[$i]->name;
			  echo '</strong>';
		}
		if($i < $count -2){
			echo '<span class="sep">'.$separator.'</span>';
		}
	}  else if ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
		if($i > 0){
			echo '<span class="sep">'.$separator.'</span>';
		}
    echo '<strong>';
		echo $list[$i]->name;
	  echo '</strong>';
	}
endfor; ?>
