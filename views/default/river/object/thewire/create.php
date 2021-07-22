<?php
/**
 * File river view.
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
    return;
}

$object = $item->getObjectEntity();
$vars['message'] = \TheWirePro\Bootstrap::thewirepro_filter($object->description). elgg_view_comments($object, true, ['inline' => true, 'limit' => 3]);;

$subject = $item->getSubjectEntity();
$subject_link = elgg_view('output/url', [
    'href' => $subject->getURL(),
    'text' => $subject->getDisplayName(),
    'class' => 'elgg-river-subject',
    'is_trusted' => true,
]);

$object_link = elgg_view('output/url', [
    'href' => elgg_generate_url('collection:object:thewire:owner', [
        'username' => $subject->username,
    ]),
    'text' => elgg_echo('thewire:wire'),
    'class' => 'elgg-river-object',
    'is_trusted' => true,
]);


$vars['summary'] = elgg_echo('river:object:thewire:create', [$subject_link, $object_link]);

echo elgg_view('river/elements/layout', $vars);
