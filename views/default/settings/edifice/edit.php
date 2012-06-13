<?php

global $CONFIG;

//CATEGORY SIDEBAR TREE
echo "Would you like to display Category Tree?<br>";
echo elgg_view('input/radio', array('value' => $vars['entity']->show_sidebar,
    'internalname' => 'params[show_sidebar]',
    'options' => array(
        'yes' => 'yes',
        'no' => 'no'
        )));

if (get_plugin_setting('show_sidebar', 'edifice') == 'yes') {
    echo "The category list sidebar extends the owner block view. If there are any specific contexts (e.g. admin), where you would like the sidebar to disappear, please list them here<br>";
    echo elgg_view('input/tags', array('value' => $vars['entity']->sidebar_display,
        'internalname' => 'params[sidebar_display]'));
    echo '<br>';
}


//SUPPORTED OBJECT SUBTYPES
$supported_subtypes = "blog, bookmarks, file, page_top, image, album, izap_videos";
if (!get_plugin_setting('allowed_object_types', 'edifice')) {
    set_plugin_setting('allowed_object_types', $supported_subtypes, 'edifice');
}
echo "Please list object subtypes you would like to categorize (additional modifications might be needed for some of the integrations). Available subtypes on your elgg site are: " . $supported_subtypes;
echo elgg_view('input/tags', array('value' => $vars['entity']->allowed_object_types,
    'internalname' => 'params[allowed_object_types]'));
echo '<br>';

//echo "Would you like to categorize users?<br>";
//echo elgg_view('input/radio', array('value' => $vars['entity']->allow_users,
//                                    'internalname' => 'params[allow_users]',
//                                    'options' => array(
//                                        'yes' => 'yes',
//                                        'no' => 'no'
//                                    )));
echo '<br>';
echo '<br>';

//GROUPS SUPPORT
echo "Would you like your groups to have categories?<br>";
echo elgg_view('input/radio', array('value' => $vars['entity']->allow_groups,
    'internalname' => 'params[allow_groups]',
    'options' => array(
        'yes' => 'yes',
        'no' => 'no'
        )));
echo '<br>';
echo "Would you like to allow group content to be filed in categories above the group's parent category?<br>";
echo elgg_view('input/radio', array('value' => $vars['entity']->allow_content_in_outside_categories,
    'internalname' => 'params[allow_content_in_outside_categories]',
    'options' => array(
        'yes' => 'yes',
        'no' => 'no'
        )));
echo '<br>';
if (get_plugin_setting('allow_groups', 'edifice') == 'yes') {
    echo "Would you like to allow categories inside the group?<br>";
    echo elgg_view('input/radio', array('value' => $vars['entity']->allow_in_groups,
        'internalname' => 'params[allow_in_groups]',
        'options' => array(
            'yes' => 'yes',
            'no' => 'no'
            )));
    echo '<br>';

    //if (get_plugin_setting('allow_in_groups', 'edifice') == 'yes') {
    //    echo "Would you like to allow group owners to create subcategories that will append sitewide categories (e.g. a public category created in a group will become available throughout the site)?<br>";
    //    echo elgg_view('input/radio', array('value' => $vars['entity']->allow_public_in_groups,
    //        'internalname' => 'params[allow_public_in_groups]',
    //        'options' => array(
    //            'yes' => 'yes',
    //            'no' => 'no'
    //            )));
    //}
}

set_plugin_setting('allow_public_in_groups', 'no', 'edifice');
set_plugin
?>