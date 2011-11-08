<?php

$container_guid = page_owner();
$container = get_entity($container_guid);

if (!$container instanceof ElggGroup
        or isset($vars['groupedit'])
        or get_plugin_setting('allow_content_in_outside_categories', 'edifice') == 'yes') {
            $categories = elgg_get_entities_from_metadata(array(
                            'metadata_name' => 'level',
                            'metadata_value' => 1,
                            'type' => 'object',
                            'subtype' => 'category',
                            'limit' => 500));
        $container_guid = 1;
} else {
    $categories = get_children(get_item_categories($container_guid), $container_guid);
}

if (!empty($categories)) {
?>
    <script type="text/javascript">
        $(document).ready(function(){
            var edifice_current = $('#category_assignment'),
            edifice_to_inspect = $('#edifice_select');
            $('li.categoryitem', edifice_to_inspect).each(function(){
                $(this).find('a:first').attr('href', 'javascript:void(0)');
                $(this).find('a:first').click(function(){
                    $value = $(this).attr('value');
                    $('#relationship_guid').attr('value', $value);
                });
            });
            edifice_current.menu({
                content: edifice_current.next().html(),
                backLink: true,
                callerOnState: '',
                crumbDefaultText: '',
                flyOut: true
            });


        });

    </script>

	<!-- Choix d'une category D2T -->
    <div class="title"><h3><?php echo elgg_echo('edifice:assigncategory:title') ?></h3></div>
 
    <div id="edifice_sidebar_assign">
        <a tabindex="0" href="#edifice" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all" id="category_assignment"><span class="ui-icon ui-icon-triangle-1-s"></span><?php echo elgg_echo('edifice:assigncategory') ?></a>
        <div id="edifice_select" class="hidden">
        <?php
        $category_list = '';

        foreach ($categories as $category) {
            $category_list .= '<li class="categoryitem level1" value="' . $category->getGUID() . '"><a href="' . $category->getURL() . '" >' . elgg_view('profile/icon', array('entity' => $category, 'size' => 'topbar')) . $category->title . '</a>';
            if (!isset($vars['groupedit']) or $category->container_guid == 1) {
                $category_list .= list_children($category->guid, 1);
            } else {
                $category_list .= list_children($category->guid, 1, '', $container_guid);
            }
            $category_list .= '</li>';
        }

        echo '<ul>' . $category_list . '</ul>';
        ?>
    </div>
</div>
               
<?php echo elgg_view('input/hidden', array('internalname' => 'relationship', 'internalid' => 'selection_guid')); ?>
    <div id="selection_text" style="clear:both">
    <?php
        if ($vars['current_category'] !== NULL) {
			echo elgg_echo('edifice:group:current') . '<b>' . get_entity(get_item_categories($vars['entity']->guid))->title . '</b><br>';
	} else {
			echo elgg_echo('edifice:assigncategory:none') . '<br>';
    }
    ?></div>

<?php
    } elseif ($container_guid !== 1) {
         echo elgg_view('input/hidden', array('internalname' => 'relationship', 'internalid' => 'selection_guid', 'value' => get_item_categories($container_guid)));
         echo 'Current category: ' . get_entity(get_item_categories($container_guid))->title;
    } else {
        echo elgg_echo('edifice:actions:youcannotassign');
    }
?>
