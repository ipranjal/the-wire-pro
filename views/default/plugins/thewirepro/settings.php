<?php
/**
 * The wire plugin settings
 */

$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('thewire:settings:rename'),
    'name' => 'params[the_wire_name]',

    'value' => $plugin->the_wire_name,
    'id' => 'the-wire-name',

]
);

echo elgg_view_field([
    '#type' => 'text',
    '#label' => elgg_echo('thewire:settings:wire_placeholder'),
    'name' => 'params[the_wire_placeholder]',
    'value' => $plugin->the_wire_placeholder,
    'id' => 'the-wire-placeholder',

]
);

echo elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('thewire:settings:limit'),
    'name' => 'params[limit]',
    'value' => (int) $plugin->limit,
    'id' => 'thewire-limit',
    'options_values' => [
        0 => elgg_echo('thewire:settings:limit:none'),
        140 => '140',
        250 => '250',
    ],
]
);
echo elgg_view_field([
    '#type' => 'select',
    '#label' => elgg_echo('thewire:settings:reply_as_comment'),
    'name' => 'params[reply_as_comment]',
    'options_values' => [
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no'),
    ],
    'value' => $plugin->reply_as_comment,
    'id' => 'reply-as-comment',

]
);

echo elgg_view_field([
    '#type' => 'plaintext',
    '#label' => elgg_echo('thewire:settings:embed_whitelist'),
    'name' => 'params[embed_whitelist]',
    'value' => $plugin->embed_whitelist,
    'id' => 'the-wire-whitelist',

]
);
