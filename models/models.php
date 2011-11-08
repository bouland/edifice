<?php

//Shortcut functions

function get_children($category_guid, $container_guid = NULL) {

    $objects = elgg_get_entities_from_relationship(array(
                'relationship' => 'child',
                'relationship_guid' => $category_guid,
                'inverse_relationship' => true,
                'types' => 'object',
                'subtypes' => 'category'));
                
    if ($container_guid) {
        foreach ($objects as $object) {
            if ($object->container_guid == $container_guid) {
                $result[] = $object;
            }
        }
    } else {
        $result = $objects;
    }

    return $result;
}

function get_parent($subcategory_guid) {

    $objects = elgg_get_entities_from_relationship(array(
                'relationship' => 'child',
                'relationship_guid' => $subcategory_guid,
                'inverse_relationship' => false,
                'types' => 'object',
                'subtypes' => 'category'));

    return $objects[0];
}

function get_filed_items($category_guid) {

    $objects = elgg_get_entities_from_relationship(array(
                'relationship' => 'filed_in',
                'relationship_guid' => $category_guid,
                'inverse_relationship' => true));

    return $objects;
}

function get_filed_items_by_type($category_guid, $types, $subtypes) {

    $objects = elgg_get_entities_from_relationship(array(
                'relationship' => 'filed_in',
                'relationship_guid' => $category_guid,
                'inverse_relationship' => true,
                'types' => $types,
                'subtypes' => $subtypes,
                'limit' => 500));

    return $objects;
}

function get_filed_items_count($category_guid, $admin = false) {
    global $CONFIG;

    $category = get_entity($category_guid);
    $container_guid = $category->container_guid;

    if (empty($container_guid))
        $container_guid = 1;

    $objects = elgg_get_entities_from_relationship(array(
                'relationship' => 'filed_in',
                'relationship_guid' => $category_guid,
                'inverse_relationship' => true));

    $count = 0;
    foreach ($objects as $object) {
        if (get_input('context') == 'site'
                or get_context() == 'category'
                or $object->container_guid == $container_guid
                or $container_guid == 1
                or $admin == true) {
            $count++;
        }
    }

    return $count;
}

function list_children($category_guid, $level, $count = NULL, $container_guid = 1) {
    global $CONFIG;
    $category = get_entity($category_guid);
    $level = $level + 1;
    if ($category instanceof ElggObject && $category->getSubtype() == 'category') {

        $subcategories = get_children($category->guid, '');

        if (!empty($subcategories)) {
            $subcategory_list = '';
            foreach ($subcategories as $subcategory) {
                if ($count) {
                    $count_text = ' (' . get_filed_items_count($subcategory->guid) . ')';
                } else {
                    $count_text = '';
                }
                //if ($container_guid == $subcategory->container_guid or $container_guid == 1) {
                if ($subcategory->container_guid == $container_guid) {
                    $subcategory_list .= '<li class="closed categoryitem level' . $level . '" value="' . $subcategory->getGUID() . '"><a href="' . $subcategory->getURL() . '">' . elgg_view('profile/icon', array('entity' => $subcategory, 'size' => 'topbar')) . $subcategory->title . $count_text . '</a>';
                    $subcategory_list .= list_children($subcategory->guid, $level + 1, $count, $container_guid);
                    $subcategory_list .= '</li>';
                }
            }
            if ($subcategory_list) {
                $subcategory_list = '<ul>' . $subcategory_list . '</ul>';
            }
        }
    }

    return $subcategory_list;
}

function list_children_for_admin($category_guid, $level, $count = NULL, $container_guid = 1) {
    global $CONFIG;
    $category = get_entity($category_guid);
    $level = $level + 1;
    if ($category instanceof ElggObject && $category->getSubtype() == 'category') {

        $subcategories = get_children($category->guid);

        if (!empty($subcategories)) {
            $subcategory_list = '';
            foreach ($subcategories as $subcategory) {
                if ($count) {
                    $count_text = ' (' . get_filed_items_count($subcategory->guid, true) . ')';
                } else {
                    $count_text = '';
                }
                //if ($container_guid == $subcategory->container_guid or $container_guid == 1) {
                    $subcategory_list .= '<li class="closed categoryitem level' . $level . '" value="' . $subcategory->getGUID() . '"><a href="' . $subcategory->getURL() . '">' . elgg_view('profile/icon', array('entity' => $subcategory, 'size' => 'topbar')) . $subcategory->title . $count_text . '</a>';
                    $subcategory_list .= list_children_for_admin($subcategory->guid, $level + 1, $count, $container_guid);
                    $subcategory_list .= '</li>';
            }
            if ($subcategory_list) {
                $subcategory_list = '<ul>' . $subcategory_list . '</ul>';
            }
        }
    }

    return $subcategory_list;
}

function get_item_categories($item_guid) {
    $categories = elgg_get_entities_from_relationship(array(
                'relationship' => 'filed_in',
                'relationship_guid' => $item_guid,
                'inverse_relationship' => false));
    $level = 0;

    foreach ($categories as $category) {
        if ((int) $category->level > $level) {
            $level = (int) $category->level;
            $result = $category;
        }
    }

    return $result->guid;
}

function delete_all_categories() {
    $objects = get_entities('object', 'category');
    foreach ($objects as $object) {
        $object->delete();
    }
    return true;
}

function count_categories() {

    $count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'category', 'count' => true));

    if ($count < get_plugin_setting('count_init', 'edifice')) {
        return true;
    } else {
        return false;
    }

}
function cmp_categories($c1, $c2)
{
	$n1 = get_filed_items_count($c1->guid);
	$n2 = get_filed_items_count($c2->guid);
    if ($n1 == $n2) {
        return 0;
    }
    return ($n2 < $n1) ? -1 : 1;
}

?>