<?php

/**
 * Edifice Plugin for Elgg
 *
 * @package Edifice
 * @author Ismayil Khayredinov
 */

// Initialize
function edifice_init() {

    global $CONFIG;

// Register actions for manipulation of categories
    register_action('category/save', false, $CONFIG->pluginspath . 'edifice/actions/save.php', false);

// Register page handlers for better navigation
    register_page_handler('category', 'category_url_handler');
    register_entity_url_handler('edifice_category_url', 'object', 'category');

// Extend existing views, create new views
    elgg_extend_view('css', 'edifice/css');

    elgg_extend_view('input', 'edifice/forms/assign');
	//elgg_extend_view('input', 'input/color');
//    extend_view('elgg_topbar/extend', 'edifice/menulist');

    elgg_extend_view('profile/icon', 'edifice/icon');

    elgg_extend_view('metatags', 'metatags/meta');

    elgg_extend_view('page_elements', 'edifice/list');

    if (get_plugin_setting('show_sidebar', 'edifice') == 'yes') {
        if (!in_array(get_context(), string_to_tag_array(get_plugin_setting('sidebar_display', 'edifice')))
                && get_context() != 'groups') {
            elgg_extend_view('page_elements/owner_block', 'edifice/list');
        } elseif (get_plugin_setting('allow_groups', 'edifice') == 'yes'
                && get_plugin_setting('allow_in_groups', 'edifice') == 'yes') {
            elgg_extend_view('owner_block/extend', 'edifice/group_list');
            add_group_tool_option('categories', elgg_echo('edifice:groups:enable'), true);
        }
    }

// Register a plugin hook for icon display
    register_plugin_hook('entity:icon:url', 'object', 'category_icon_hook');

// Register categories for search
// Categories search view overloaded in search/object/category/entity.php
    register_entity_type('object', 'category');
}

// ADMIN SUBMENU
function edifice_pagesetup() {

    global $CONFIG;

    if (get_context() == 'admin' && isadminloggedin()) {
        add_submenu_item(elgg_echo('edifice:admin:submenu'), $CONFIG->wwwroot . 'mod/edifice/manage.php');
    }
}

//URL AND PAGE HANDLERS
function edifice_category_url($entity) {

    global $CONFIG;

    $title = elgg_get_friendly_title($entity->title);
    $context = get_context();
    if ($context !== 'groups')
        $context = 'site';
    return $CONFIG->url . "pg/category/view/{$context}/{$entity->guid}/$title/";
}

function category_url_handler($page) {

    global $CONFIG;

    switch ($page[0]) {
        case 'group' :
            if (isset($page[1])) {
                set_input('group_guid', $page[1]);
                include($CONFIG->pluginspath . "edifice/views/default/edifice/extensions/groups/manage_group.php");
            }
            break;

        case 'icon':
            if (isset($page[1])) {
                set_input('category_guid', $page[1]);
            }
            if (isset($page[2])) {
                set_input('size', $page[2]);
            }
            include($CONFIG->pluginspath . "edifice/graphics/edifice/icon.php");
            break;

        case 'view':
            if (isset($page[1])) {
                set_input('context', $page[1]);
            }
            if (isset($page[2])) {
                set_input('category_guid', $page[2]);
            }

            include($CONFIG->pluginspath . "edifice/views/default/edifice/view.php");
            break;
    }
}

// HANDLING CATEGORY ICONS
function category_icon_hook($hook, $entity_type, $returnvalue, $params) {

    global $CONFIG;
    if ((!$returnvalue) && ($hook == 'entity:icon:url') && ($params['entity'] instanceof ElggObject) && ($params['entity']->getSubtype() == 'category')) {

        $entity = $params['entity'];
        $size = $params['size'];
        $filehandler = new ElggFile();
        $filehandler->owner_guid = $entity->owner_guid;
        $filehandler->setFilename("category/" . $entity->guid . $size . ".jpg");

        $url = $CONFIG->url . "pg/category/icon/{$entity->guid}/{$size}/category.jpg";
        return $url;
    }
}

// ADDING CATEGORY TO A CONTENT ITEM ON SAVE
function edifice_establish_relationship($event, $object_type, $object) {

    if ($object instanceof ElggObject && in_array($object->getSubtype(), string_to_tag_array(get_plugin_setting('allowed_object_types', 'edifice')))) {

//Get edit/create form input
        $category_guid = get_input('relationship');

        if ($category_guid) {
//Remove existing relationships
            $relationships = get_entity_relationships($object->getGUID(), false);
            foreach ($relationships as $id => $relationship) {
                $relationship_reverse = get_entity($relationship['guid_two']);
                if ($relationship_reverse instanceof ElggObject && $relationship_reverse->getSubtype() == 'category') {
                    delete_relationship($relationship['id']);
                }
            }

//Establish new relationships
            $category = get_entity($category_guid);
            $check = true;
            while ($check == true) {
                add_entity_relationship($object->getGUID(), 'filed_in', $category->guid);
                $category = get_parent($category->guid);
                if (!$category) {
                    $check = false;
                }
            }
            $category_guid = '';
        }
    }

    return true;
}

// GROUP SUPPORT
function edifice_establish_group_relationship($event, $object_type, $object) {

    if ($object instanceof ElggEntity && get_plugin_setting('allow_groups', 'edifice') == 'yes') {
//Get edit/create form input
        $category_guid = get_input('relationship');

        if ($category_guid) {
            if (get_entity($category_guid)->container_guid == 1) {
//Remove existing relationships
                $relationships = get_entity_relationships($object->getGUID(), false);
                foreach ($relationships as $id => $relationship) {
                    $relationship_reverse = get_entity($relationship['guid_two']);
                    if ($relationship_reverse instanceof ElggEntity && $relationship_reverse->getSubtype() == 'category') {
                        delete_relationship($relationship['id']);
                    }
                }
//Re-establish category hierarchy on group move
                $children = get_children(get_item_categories($object->guid));
                foreach ($children as $child) {
                    if ($child->container_guid == $object->guid) {
                        $relationships = get_entity_relationships($child->guid, false);
                        foreach ($relationships as $relationship) {
                            $relationship_type = $relationship->relationship;
                            if ($relationship_type == 'child') {
                                delete_relationship($relationship->id);
                                add_entity_relationship($child->guid, 'child', $category_guid);

                            }
                        }
                    }
                }
                //Establish new relationships
                $category = get_entity($category_guid);
                $check = true;
                while ($check == true) {
                    add_entity_relationship($object->getGUID(), 'filed_in', $category->guid);
                    $category = get_parent($category->guid);
                    if (!$category) {
                        $check = false;
                    }
                }
                $category_guid = '';
            } else {
                system_message(elgg_echo('edifice:save:error:notsiteowned'));
            }
        }
    }

    return true;
}

register_elgg_event_handler('init', 'system', 'edifice_init');
register_elgg_event_handler('pagesetup', 'system', 'edifice_pagesetup');

register_elgg_event_handler('update', 'object', 'edifice_establish_relationship');
register_elgg_event_handler('create', 'object', 'edifice_establish_relationship');

register_elgg_event_handler('update', 'group', 'edifice_establish_group_relationship');
register_elgg_event_handler('create', 'group', 'edifice_establish_group_relationship');

include(dirname(__FILE__) . '/models/models.php');
?>