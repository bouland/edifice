<?php

global $CONFIG;
gatekeeper();

$container_guid = (int) get_input('container_guid');
$container = get_entity($container_guid);

if ($container->canEdit()) {
    $title = get_input('title');
    $description = get_input('description');
    $category_guid = (int) get_input('category_guid');
    $parent_guid = (int) get_input('parent_guid');
    $level = (int) get_input('level');
    $access_id = get_input('access');
    $color = get_input('color');
    $owner_guid = (int) get_input('owner_guid');
    if ($owner_guid == 0) {
		$owner_guid = get_loggedin_userid();
    }
	
    $category = new ElggObject($category_guid);
    $category->subtype = 'category';
    $category->title = $title;
    $category->description = $description;
    $category->level = $level;
    
    $category->owner_guid = $owner_guid;
    $category->access_id = $access_id;
	$category->color = $color;
    // If access is limited to a group, make that group a container
    $access_collection = get_access_collection($access_id);
    $group_check = get_entity($access_collection->owner_guid);
    if ($group_check instanceof ElggGroup
            && $parent_guid == get_item_categories($group_check->guid)) {
        $category->container_guid = $group_check->guid;
    } else {
        $category->container_guid = $container_guid;
    }

    $category->save();

    if ($parent_guid) {
        add_entity_relationship($category->guid, 'child', $parent_guid);
    }


//if(get_input('categoryicon')) {
    $topbar = get_resized_image_from_uploaded_file('categoryicon', 16, 16, true, true);
    $tiny = get_resized_image_from_uploaded_file('categoryicon', 25, 25, true, true);
    $small = get_resized_image_from_uploaded_file('categoryicon', 40, 40, true, true);
    $medium = get_resized_image_from_uploaded_file('categoryicon', 100, 100, true, true);
    $large = get_resized_image_from_uploaded_file('categoryicon', 200, 200);
    $master = get_resized_image_from_uploaded_file('categoryicon', 550, 550);

    if ($small !== false
            && $medium !== false
            && $large !== false
            && $tiny !== false) {


        $filehandler = new ElggFile();
        $filehandler->owner_guid = $category->owner_guid;
        $filehandler->setFilename("category/" . $category->guid . "large.jpg");
        $filehandler->open("write");
        $filehandler->write($large);
        $filehandler->close();
        $filehandler->setFilename("category/" . $category->guid . "medium.jpg");
        $filehandler->open("write");
        $filehandler->write($medium);
        $filehandler->close();
        $filehandler->setFilename("category/" . $category->guid . "small.jpg");
        $filehandler->open("write");
        $filehandler->write($small);
        $filehandler->close();
        $filehandler->setFilename("category/" . $category->guid . "tiny.jpg");
        $filehandler->open("write");
        $filehandler->write($tiny);
        $filehandler->close();
        $filehandler->setFilename("category/" . $category->guid . "topbar.jpg");
        $filehandler->open("write");
        $filehandler->write($topbar);
        $filehandler->close();
        $filehandler->setFilename("category/" . $category->guid . "master.jpg");
        $filehandler->open("write");
        $filehandler->write($master);
        $filehandler->close();
    }
//}
    forward($_SERVER['HTTP_REFERER']);
} else {
    register_error('edifide:manage:noprivileges');
    forward($_SERVER['HTTP_REFERER']);
}
?>