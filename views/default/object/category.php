<?php
if (isset($vars['entity'])) {
    if ($vars['entity'] instanceof ElggObject && $vars['entity']->getSubtype() == 'category') {
        if (get_context() == "search") {
            if (get_input('search_viewtype') == "gallery") {
                echo elgg_view("category/gallery", $vars);
            } else {
                echo elgg_view("category/listing", $vars);
            }
        } else {
            $url = $vars['entity']->getURL();
?>

            <div class="contentWrapper">
                <div class="category_summary" style="background:<?php echo $vars['entity']->color;?>;">

                    <div class="category_iconWrapper">

            <?php
            echo elgg_view("profile/icon", array('entity' => $vars['entity'], 'size' => 'medium'));
            ?>

        </div>
        <h2><?php echo $vars['entity']->title; ?></h2></div>

    <div class="category_descriptionWrapper">

        <?php
            if (!isset($vars['full']) || (isset($vars['full']) && $vars['full'] != FALSE)) {
                echo elgg_view('output/longtext', array('value' => $vars['entity']->description));
        ?>
            </div>
            <div class="clearfloat"></div>

    <?php
                echo '<div class="category_filed_items">';

//$items = get_filed_items($vars['entity']->guid);
//foreach ($items as $item) {
//    set_context('search');
//    echo elgg_view_entity($item);
//}



                if (get_context() !== 'groups') {
                    if (get_plugin_setting('allow_groups', 'edifice') == 'yes') {
                        $context = get_context();
                        set_context('search');
                        $objects = get_filed_items_by_type($vars['entity']->guid, 'group', '');
                        echo '<div id="content_area_user_title"><h2 class="title">' . elgg_echo('item:group') . '</h2></div>';
                        foreach ($objects as $object) {

                            echo elgg_view_entity($object);
                        }
                        set_context($context);
                    }
                }

                $types = get_registered_entity_types('object');

                foreach ($types as $type) {
                    $context = get_context();
                    set_context('search');
                    $objects = get_filed_items_by_type($vars['entity']->guid, 'object', $type);
                    if (in_array($type, string_to_tag_array(get_plugin_setting('allowed_object_types', 'edifice')))) {
                        echo '<div id="content_area_user_title"><h2 class="title">' . elgg_echo('item:object:' . $type) . '</h2></div>';
                        foreach ($objects as $object) {
                            if (get_input('context') == 'site' or $object->container_guid == page_owner()) {
                                echo elgg_view_entity($object);
                            }
                        }
                        set_context($context);
                    }
                }

                echo '</div>';
            } else {
                $body = elgg_get_excerpt($vars['entity']->description, 500);
                if (elgg_substr($body, -3, 3) == '...') {
                    $body .= " <a href=\"{$vars['entity']->getURL()}\">" . elgg_echo('edifice:category:read_more') . '</a>';
                }

                $types = get_registered_entity_types('object');
                $counters = '';

                echo elgg_view('output/longtext', array('value' => $body));

                if (get_plugin_setting('allow_groups', 'edifice') == 'yes') {
                    $objects = get_filed_items_by_type($vars['entity']->guid, 'group', '');
                    $count = 0;
                    if (is_array($objects))
                        $count = count($objects);
                    if ($count > 0) {
                        $counters .= '<span class="type_counters" style="padding-right:10px">' . elgg_echo('item:group') . ': <b>' . $count . '</b></span> ';
                    }
                }

                foreach ($types as $type) {
                    $objects = get_filed_items_by_type($vars['entity']->guid, 'object', $type);
                    if (in_array($type, string_to_tag_array(get_plugin_setting('allowed_object_types', 'edifice')))) {
                        $count = 0;
                        if (is_array($objects))
                            $count = count($objects);
                        if ($count > 0) {
                            $counters .= '<span class="type_counters" style="padding-right:10px">' . elgg_echo('item:object:' . $type) . ': <b>' . $count . '</b></span> ';
                        }
                    }
                }



                echo '<p>' . $counters . '</p>';
                if (isadminloggedin ()) {
                    echo '<div class="subcategoryWrapper">';
                    echo '<div class="subcategory_header">Subcategories</div>';
                    echo '<div class="subcategory_list">' . list_children_for_admin($vars['entity']->guid, $vars['entity']->level, true,  1) . '</div>';

                    echo '<div class="subcategory_edit_button"><a href="manage.php?parent=' . $vars['entity']->guid . '&level=' . $vars['entity']->level . '">Edit subcategories</a></div></div>';
                } elseif (get_loggedin_user()->guid == $vars['entity']->owner_guid) {
                    echo '<div class="subcategoryWrapper">';
                    echo '<div class="subcategory_header">Subcategories</div>';
                    echo '<div class="subcategory_list">' . list_children($vars['entity']->guid, $vars['entity']->level, '', 1) . '</div>';

                    echo '<div class="subcategory_edit_button"><a href="?parent=' . $vars['entity']->guid . '&level=' . $vars['entity']->level . '">Edit subcategories</a></div></div>';
                }
            }
    ?>

            <div class="clearfloat"></div></div>




<?php
        }
    } else {

        $url = 'javascript:history.go(-1);';
        $owner = $vars['user'];
        $canedit = false;
    }
}
?>