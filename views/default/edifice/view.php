<?php

require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/engine/start.php');

$category_guid = get_input('category_guid');
$category = get_entity($category_guid);

if (isadminloggedin () && get_context() !== 'groups') {
    add_submenu_item(elgg_echo('edifice:admin:submenu'), $CONFIG->wwwroot . 'mod/edifice/manage.php');
}
$container_guid = $category->container_guid;
$container = get_entity($container_guid);

$context = get_input('context');
if ($context == 'site') {
    $body = elgg_view_entity($category, 'full');
    $body = elgg_view_layout('two_column_left_sidebar', $area1, $body);

    page_draw(elgg_echo('edifice:admin:manager'), $body);
} else {
    set_page_owner($container_guid);
    set_context('groups');
    $body = elgg_view_entity($category, 'full');
    $body = elgg_view_layout('two_column_left_sidebar', $area1, $body);

    page_draw(elgg_echo('edifice:admin:manager'), $body);
}
?>
