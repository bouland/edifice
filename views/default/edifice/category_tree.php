<?php
$page_owner = page_owner_entity();

if (!in_array(get_context(), string_to_tag_array(get_plugin_setting('sidebar_display', 'edifice')))) {

    if (!$page_owner instanceof ElggGroup) {
        $categories = elgg_get_entities_from_metadata(array(
                    'metadata_name' => 'level',
                    'metadata_value' => 1,
                    'type' => 'object',
                    'subtype' => 'category',
                    'limit' => 500));
        $container_guid = 1;
        $module_title = 'edifice:module:title:site';
    }
?>

<?php
    if (!empty($categories)) {
    	usort($categories,"cmp_categories");
?>


            <h3><?php echo elgg_echo($module_title); ?></h3>
            <div id="edifice_sidebar">
        <?php
        $category_list = '';

        foreach ($categories as $category) {
            //if ($category->container_guid == $container_guid or $container_guid == 1) {  //this display groups categories in site categories
            if ($category->container_guid == $container_guid or $category->container_guid == 1) {
                $category_list .= '<li class="closed categoryitem level1">' . elgg_view('profile/icon', array('entity' => $category, 'size' => 'topbar')) . '<a href="' . $category->getURL() . '">' . $category->title . ' <span class="category_count"> (' . get_filed_items_count($category->guid) . ')</span></a>';
                $category_list .= list_children($category->guid, 1, true, $container_guid);
                $category_list .= '</li>';
            }
        }

        echo '<ul id="category_sidebar_list">' . $category_list . '</ul>';
        ?>

			</div>

<?php
    }
}
?>


<script type="text/javascript">

    $(document).ready(function(){
       $('#category_sidebar_list').treeview({url:''});
    });

</script>
