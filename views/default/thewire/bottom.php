<?php

$entity = elgg_extract('entity', $vars);
$comment_enabled = elgg_get_plugin_setting('reply_as_comment', 'thewirepro', 'yes');

if (!$entity instanceof \ElggWire) {
    return;
}
if ($comment_enabled == 'yes') {

    // $metadata .= elgg_view_menu('social', [
    //     'entity' => elgg_extract('entity', $vars),
    //     'handler' => elgg_extract('handler', $vars),
    //     'class' => 'elgg-menu-hz',
    // ]);
    echo '<ul class="elgg-list elgg-river-comments">';

    $contents = elgg_get_entities([
        'type' => 'object',
        'subtype' => 'thewire',
        'metadata_name_value_pairs' => [
            'name' => 'wire_thread',
            'value' => $entity->wire_thread,
        ],
        'limit' => max(20, elgg_get_config('default_limit')),
        'preload_owners' => true,
    ]);
    if ($contents) {
        foreach ($contents as $content) {
            if ($content->guid != $entity->guid) {
                $ovars['time'] = $content->time_created;
                $user = $content->getOwnerEntity();
                $icon = elgg_view_entity_icon($user, 'tiny', array('use_link' => false, 'use_hover' => false));

                $url = elgg_view('output/url', array(
                    'href' => '#',
                    'text' => $icon,
                    'link_class' => 'elgg-lightbox',
                ));
                echo '<li class="elgg-item elgg-item-object elgg-item-object-comment"><div  class="elgg-image-block  clearfix">
            <div class="elgg-image">' . $url . '</div>
            <div class="elgg-body">
            <div tyle="font-size:0.6rem" class="elgg-listing-summary-subtitle elgg-subtext">
            <a href="/profile/' . $user->username . '">' . $user->name . '</a> replied
            <span class="elgg-listing-time">
            &nbsp;&nbsp;<span class="elgg-icon elgg-icon-history fas fa-history">&nbsp;&nbsp;</span>' . elgg_view('output/friendlytime', $ovars) . '</span>
            </div>
            <div class="class="elgg-listing-summary-content elgg-content"">' .
                thewire_filter($content->description)
                    . '</div>

             </div>
            </div></li>';

                //var_dump($entity->getOwnerEntity());
            }
        }
    }
    $entity = elgg_extract('entity', $vars);

    if (elgg_is_logged_in()) {

        //elgg_push_entity_breadcrumbs($post, true);
        $form = '<li class="elgg-level">' .
        elgg_view_form('thewire/add', [
            'class' => 'thewire-form',
            'prevent_double_submit' => true,
        ], [
            'post' => $entity,
        ]);
        $form .= elgg_view('input/urlshortener');
        echo $form . '</li>';
    }
    echo '</ul>';
}

//var_dump($content);
