<?php

require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/engine/start.php');

$page_owner=get_input('group_guid');
set_context('groups');
set_page_owner($page_owner);

$body .= elgg_view('edifice/manager');
$body = elgg_view_layout('two_column_left_sidebar', '', $body);

page_draw(elgg_echo('edifice:admin:manager'), $body);

?>
