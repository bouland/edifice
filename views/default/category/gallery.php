<?php

$icon = elgg_view(
                "profile/icon", array(
            'entity' => $vars['entity'],
            'size' => 'small',
                )
);
$info = "<p><a href=\"{$vars['entity']->getURL()}\">{$vars['entity']->title}</a></p>";

//display
echo "<div class=\"blog_gallery\">";
echo "<div class=\"blog_gallery_icon\">" . $icon . "</div>";
echo "<div class=\"blog_gallery_content\">" . $info . "</div>";
echo "</div>";
?>
