<?php
$context = get_context();
set_context('category');
$categories = elgg_get_entities_from_metadata(array('metadata_name' => 'level', 'metadata_value' => 1, 'type' => 'object', 'subtype' => 'category', 'limit' => 500));

if (!empty($categories)) {
?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#hierarchybreadcrumb').menu({
                content: $('#hierarchybreadcrumb').next().html(),
                backLink: true,
                callerOnState: '',
                crumbDefaultText: '',
                flyOut: true
            });

        });

    </script>
    <div id="edifice_topbar" style="float:left; margin-top:-3px;">
        <a tabindex="0" href="#edifice" class="pagelinks" id="hierarchybreadcrumb"><?php echo elgg_echo('edifice:categories') ?></a>
        <div id="edifice" class="hidden">
        <?php
        $category_list = '';

        foreach ($categories as $category) {
            $category_list .= '<li class="categoryitem level1"><a href="' . $category->getURL() . '">' . elgg_view('profile/icon', array('entity' => $category, 'size' => 'topbar')) . $category->title . ' (' . get_filed_items_count($category->guid) . ')</a>';
            $category_list .= list_children($category->guid, 1, true, 1);
            $category_list .= '</li>';
        }

        echo '<ul>' . $category_list . '</ul>';
        ?>
    </div>
</div>
<?php }
set_context($context);
?>
