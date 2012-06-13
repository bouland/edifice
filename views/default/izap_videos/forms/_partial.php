<?php
/**
 * iZAP izap_videos
 *
 * @package Elgg videotizer, by iZAP Web Solutions.
 * @license GNU Public License version 3
 * @Contact iZAP Team "<support@izap.in>"
 * @Founder Tarun Jangra "<tarun@izap.in>"
 * @link http://www.izap.in/
 * @version 3.8b
 */
global $IZAPSETTINGS;
$remove_access_id = FALSE;
// get page owner
$page_owner = page_owner_entity();

// get entity
$video = $vars['entity'];

// get the add options
$options = izapGetVideoOptions_izap_videos();

// get the selected option
$selectedOption = get_input('option', '');
if (empty($selectedOption) || !in_array($selectedOption, $options)) {
    $selectedOption = $options[0];
}

// get values from session if any
if (isset($_SESSION['izapVideos']) && !empty($_SESSION['izapVideos'])) {
    $izapLoadedValues = izapArrayToObject_izap_videos($_SESSION['izapVideos']);
}
$izapLoadedValues->access_id = NULL;

if (empty($video)) {  // if it is new video
    $tabs = elgg_view('izap_videos/forms/elements/tabs', array('options' => $options, 'selected' => $selectedOption));
    if (in_array($selectedOption, $options)) {
        $modular_form = elgg_view('izap_videos/forms/elements/' . $selectedOption, array('loaded_data' => $izapLoadedValues));
    }
} else {  // if we are editing video
    $izapLoadedValues = $video->getAttributes();
}

if ($page_owner instanceof ElggGroup) {
    if (!empty($page_owner->group_acl)) {
        $izapLoadedValues->access_id = $page_owner->group_acl;
    }
}
if (is_null($izapLoadedValues->access_id)) {
    $izapLoadedValues->access_id = ACCESS_DEFAULT;
}

if ($video->converted == 'no' && $video->videotype == 'uploaded') {
    $remove_access_id = TRUE;
}

$izapLoadedValues->container_guid = page_owner();
?>
<div class="contentWrapper">
<?php echo $tabs; ?>

    <form action="<?php echo $vars['url'] ?>action/izapAddEdit" method="POST" enctype="multipart/form-data" id="video_form" >

<?php echo $modular_form; ?>

        <p>
            <label for="video_optional_image">
<?php echo video_echo('addEditForm:videoImage') ?>
            </label><br />
<?php
echo elgg_view('input/file', array(
    'internalname' => 'izap[videoImage]',
    'value' => $izapLoadedValues->videoImage,
    'internalid' => 'video_optional_image',
));
?>
        </p>

        <p>
            <label for="video_title">
<?php echo video_echo('addEditForm:title') ?>
            </label>
<?php
echo elgg_view('input/text', array(
    'internalname' => 'izap[title]',
    'value' => $izapLoadedValues->title,
    'internalid' => 'video_title',
));
?>
        </p>

        <p>
            <label for="video_description">
<?php echo video_echo('addEditForm:description') ?>
            </label>
<?php
echo elgg_view('input/longtext', array(
    'internalname' => 'izap[description]',
    'value' => $izapLoadedValues->description,
    'internalid' => 'video_description',
));
?>
        </p>

        <p>
            <label for="video_tags">
<?php echo video_echo('addEditForm:tags') ?>
            </label>
<?php
echo elgg_view('input/tags', array(
    'internalname' => 'izap[tags]',
    'value' => $izapLoadedValues->tags,
    'internalid' => 'video_tags',
));
?>
        </p>

        <p>
<?php
// EDIFICE CATEGORIES INPUT
if (isset($vars['entity'])) {
    $current_category = get_item_categories($vars['entity']->guid);
} else {
    $current_category = NULL;
}
if (in_array('izap_videos', string_to_tag_array(get_plugin_setting('allowed_object_types', 'edifice')))) {
    echo elgg_view('edifice/forms/assign', array('current_category' => $current_category));
}
?>
        </p>
        <p>
            <label for="video_access">
<?php echo video_echo('addEditForm:access_id') ?>
            </label>
<?php
echo elgg_view('input/' . (($remove_access_id) ? 'hidden' : 'access'), array(
    'internalname' => 'izap[access_id]',
    'value' => $izapLoadedValues->access_id,
    'internalid' => 'video_access',
));
?>
        </p>

<?php
echo elgg_View('categories', array('entity' => $video));
echo elgg_view('input/securitytoken');
echo elgg_view('input/hidden', array(
    'internalname' => 'izap[container_guid]',
    'value' => $izapLoadedValues->container_guid,
));
echo elgg_view('input/hidden', array(
    'internalname' => 'izap[guid]',
    'value' => $izapLoadedValues->guid,
));
?>
        <div id="submit_button">
<?php
echo elgg_view('input/submit', array('value' => video_echo('addEditForm:save')));
?>
        </div>
        <div id="progress_button" style="display: none;">
<?php echo video_echo('please_wait'); ?><img src="<?php echo $vars['url'] ?>mod/izap_videos/_graphics/form_submit.gif" />
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#video_form').submit(function() {
            $('#submit_button').hide();
            $('#progress_button').show();
        });
    });
</script>
<?php
// unset the session when from is loaded
unset($_SESSION['izapVideos']);
?>