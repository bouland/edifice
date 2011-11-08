<?php
	/**
	 * Icon display
	 * 
	 * @package ElggGroups
	 */

	global $CONFIG;
	require_once( $_SERVER['DOCUMENT_ROOT'] . "/engine/start.php");

	$category_guid = get_input('category_guid');
	$category = get_entity($category_guid);
	
	$size = strtolower(get_input('size'));
	if (!in_array($size,array('large','medium','small','tiny','master','topbar')))
		$size = "medium";
	
	$success = false;
	
	$filehandler = new ElggFile();
	$filehandler->owner_guid = $category->owner_guid;
	$filehandler->setFilename("category/" . $category->guid . $size . ".jpg");
	
	$success = false;
	if ($filehandler->open("read")) {
		if ($contents = $filehandler->read($filehandler->size())) {
			$success = true;
		} 
	}
	
	if (!$success) {
		$contents = @file_get_contents($CONFIG->pluginspath . "edifice/graphics/edifice/default{$size}.gif");
	}
	
	header("Content-type: image/jpeg");
	header('Expires: ' . date('r',time() + 864000));
	header("Pragma: public");
	header("Cache-Control: public");
	header("Content-Length: " . strlen($contents));
	echo $contents;
?>