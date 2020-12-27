<?php
/**
 * View a wire post
 *
 * @uses $vars['entity'] ElggWire to show
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \ElggWire) {
    return;
}
$comment_enabled = elgg_get_plugin_setting('reply_as_comment', 'thewirepro', 'yes');

if ($entity->reply && $comment_enabled == 'yes') {
    return;
}

elgg_require_js('elgg/thewire');

// make compatible with posts created with original Curverider plugin
$thread_id = $entity->wire_thread;
if (!$thread_id) {
    $entity->wire_thread = $entity->guid;
}

$params = [
    'title' => false,
    'tags' => false,
    'access' => false,
    'icon_entity' => $entity->getOwnerEntity(),
    'class' => '',
];

if (elgg_extract('full_view', $vars)) {
    $params['body'] = thewirepro_filter($entity->description);
    $responses = elgg_view_comments($entity, (bool) elgg_extract('show_add_form', $vars, true), ['inline' => true]);

    if (!$responses) {
        return;
    }

    $params['show_summary'] = true;
    if ($comment_enabled == 'yes') {
        $params['responses'] = elgg_view_comments($entity, true, ['inline' => true]);
    }

    $params = $params + $vars;
    echo elgg_view('object/elements/full', $params);
} else {
    $params['content'] = thewirepro_filter($entity->description);
    if ($comment_enabled == 'yes') {
        $params['content'] .= elgg_view_comments($entity, true, ['inline' => true, 'limit' => 3]);
    }
    $params = $params + $vars;
    echo elgg_view('object/elements/summary', $params);

}

if (!$entity->reply) {
    return;
}

echo elgg_format_element('div', [
    'class' => 'thewire-parent hidden',
    'id' => "thewire-previous-{$entity->guid}",
]);
