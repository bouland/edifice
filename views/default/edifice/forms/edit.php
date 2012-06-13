<form action="<?php echo $vars['url']; ?>action/category/save" method="post" enctype="multipart/form-data">

    <?php
    if (!$vars['entity']) {
        $vars['entity']->title = '';
        $vars['entity']->description = '';
        $vars['entity']->guid = NULL;
        
    }
    if (!$vars['parent']) {
        $vars['parent']->guid = NULL;
    }

    if (!$vars['level']) {
        $vars['level'] = 0;
    }

    if (!$vars['color']) {
        $vars['color'] = '#E33729';//E33729
    }

    if (!$vars['container_guid']) {
        $vars['container_guid'] = 1;
    }

    echo '<div id="formWrapper">';
    echo elgg_view('input/securitytoken');
    echo '<label>' . elgg_echo('edifice:admin:title') . '</label>' . elgg_view('input/text', array('value' => $vars['entity']->title,
        'internalname' => 'title'));

    echo '<label>' . elgg_echo('edifice:admin:description') . '</label>' . elgg_view('input/longtext', array('value' => $vars['entity']->description,
        'internalname' => 'description'));
    if (get_entity($vars['container_guid']) instanceof ElggGroup && get_plugin_setting('allow_public_in_groups', 'edifice') == 'no') {
        $access_array = get_access_array();
        foreach ($access_array as $access_collection_value) {
            $access_collection = get_access_collection($access_collection_value);
            if ($access_collection->owner_guid == $vars['container_guid']) $access = $access_collection->id;
        }
        echo elgg_view('input/hidden', array('value' => $access, 'internalname' => 'access'));
    } else {
        echo '<p><label>' . elgg_echo('edifice:admin:access') . '</label>' . elgg_view('input/access', array('internalname' => 'access', 'value' => $vars['entity']->access_id)) . '</p>';
    }
    echo '<p><label>' . elgg_echo('edifice:admin:icon') . '</label>' . elgg_view('input/file', array('class' => 'input-text', 'internalname' => 'categoryicon')) . '</p>';
	echo '<p><label>' . elgg_echo('edifice:admin:color') . '</label>' . elgg_view('input/color', array('internalname' => 'color', 'value' => $vars['color'])) . '</p>';
    echo elgg_view('input/hidden', array('value' => $vars['entity']->guid, 'internalname' => 'category_guid'));
    echo elgg_view('input/hidden', array('value' => $vars['parent']->guid, 'internalname' => 'parent_guid'));
    echo elgg_view('input/hidden', array('value' => $vars['level'], 'internalname' => 'level'));
    echo elgg_view('input/hidden', array('value' => $vars['container_guid'], 'internalname' => 'container_guid'));
	echo elgg_view('input/hidden', array('value' => $vars['owner_guid'], 'internalname' => 'owner_guid'));
    echo elgg_view('input/submit', array('value' => 'save', 'internalname' => 'save'));
    echo '<a href="javascript:void(0)" class="cancel_button">Cancel</a>';
    echo '</div>';
    ?>
</form>
