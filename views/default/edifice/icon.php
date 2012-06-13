<?php

	/**
	 * Elgg group icon
	 * 
	 * @package ElggGroups
	 * 
	 * @uses $vars['entity'] The user entity. If none specified, the current user is assumed.
	 * @uses $vars['size'] The size - small, medium or large. If none specified, medium is assumed. 
	 */

	$category = $vars['entity'];
	
	if ($category instanceof ElggObject && $category->getSubtype() == 'category') {
	
	// Get size
	if (!in_array($vars['size'],array('small','medium','large','tiny','master','topbar')))
		$vars['size'] = "medium";
			
	// Get any align and js
	if (!empty($vars['align'])) {
		$align = " align=\"{$vars['align']}\" ";
	} else {
		$align = "";
	}
	
?>


<img src="<?php echo $vars['entity']->getIcon($vars['size']); ?>" border="0" <?php echo $align; ?> title="<?php echo $vars['entity']->title; ?>" <?php echo $vars['js']; ?> />


<?php

	}

?>