<?php

include 'vendor/autoload.php';

/**
 * The wire pro
 *
 * Forked from core the wire
 *
 */

use Elgg\Collections\Collection;

/**
 * The Wire initialization
 *
 * @return void
 */
function thewirepro_init()
{

    // remove edit and access and add thread, reply, view previous
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'thewirepro_setup_entity_menu_items');
    elgg_register_plugin_hook_handler('register', 'menu:social', 'thewirepro_setup_social_menu_items');

    // Extend system CSS with our own styles, which are defined in the thewire/css view
    elgg_extend_view('elgg.css', 'thewirepro/css');
    elgg_extend_view('object/elements/summary', 'thewirepro/bottom');

}

function thewirepro_setup_entity_menu_items(\Elgg\Hook $hook)
{

    $entity = $hook->getEntityParam();
    if (!$entity instanceof \ElggWire) {
        return;
    }

    $menu = $hook->getValue();
    $menu->remove('edit');
    $comment_enabled = elgg_get_plugin_setting('reply_as_comment', 'thewirepro', 'yes');

    if ($comment_enabled != 'yes') {
        if (elgg_is_logged_in()) {
            $menu->add(ElggMenuItem::factory([
                'name' => 'reply',
                'icon' => 'reply',
                'text' => elgg_echo('reply'),
                'href' => elgg_generate_entity_url($entity, 'reply'),
            ]));
        }

        $menu->add(ElggMenuItem::factory([
            'name' => 'thread',
            'icon' => 'comments-o',
            'text' => elgg_echo('thewire:thread'),
            'href' => elgg_generate_url('collection:object:thewire:thread', [
                'guid' => $entity->wire_thread,
            ]),
        ]));
    }

    return $menu;
}

/**
 * Replace urls, hash tags, and @'s by links
 *
 * @param string $text The text of a post
 *
 * @return string
 */
function thewirepro_filter($text)
{
    $text = ' ' . $text;

    // email addresses
    $text = preg_replace(
        '/(^|[^\w])([\w\-\.]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})/i',
        '$1<a href="mailto:$2@$3">$2@$3</a>',
        $text);

    // links
    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $match);

    //print_r($match[0]);
    foreach ($match[0] as $link) {
        $provider = explode('.', explode('/', $link)[2])[1];
        if ($provider == 'com') {
            $provider = explode('.', explode('/', $link)[2])[0];
        }
        $plugin = elgg_get_plugin_from_id('thewirepro');

        //$embed = new \Embed\Embed();
        if (!$plugin->embed_whitelist) {
            $info = \Embed\Embed::create($link);
            $text = $text . '<br><br>' . $info->code;
        } else {

            if (in_array($provider, explode(',', $plugin->embed_whitelist))) {
                $info = \Embed\Embed::create($link);
                $text = $text . '<br><br>' . $info->code;
            }

        }

    }

    $text = parse_urls($text);

    //emoji
    $text = stringToEmoji($text);

    // usernames
    $text = preg_replace(
        '/(^|[^\w])@([\p{L}\p{Nd}._]+)/u',
        '$1<a href="' . elgg_get_site_url() . 'thewire/owner/$2">@$2</a>',
        $text);

    // hashtags
    $text = preg_replace(
        '/(^|[^\w])#(\w*[^\s\d!-\/:-@]+\w*)/',
        '$1<a href="' . elgg_get_site_url() . 'thewire/tag/$2">#$2</a>',
        $text);

    return trim($text);
}

/**
 * Sets up the entity menu for thewire
 *
 * Adds reply, thread, and view previous links. Removes edit and access.
 *
 * @param \Elgg\Hook $hook 'register', 'menu:entity'
 *
 * @return void|Collection
 */
function thewirepro_setup_social_menu_items(\Elgg\Hook $hook)
{

    $entity = $hook->getEntityParam();
    if (!$entity instanceof \ElggWire) {
        return;
    }

    $menu = $hook->getValue();
    $comment_enabled = elgg_get_plugin_setting('reply_as_comment', 'thewirepro', 'yes');

    if ($comment_enabled == 'yes') {

        $menu->add(ElggMenuItem::factory([
            'name' => 'thread',
            'icon' => 'comments-o',
            'text' => elgg_echo('thewire:thread'),
            'href' => elgg_generate_url('collection:object:thewire:thread', [
                'guid' => $entity->wire_thread,
            ]),
        ]));
    }

    return $menu;
}

function stringToEmoji($text)
{
    $emojis = [
        '8-D' => '😁',
        '8D' => '😁',
        ':-D' => '😁',
        '=-3' => '😁',
        '=-D' => '😁',
        '=3' => '😁',
        '=D' => '😁',
        'B^D' => '😁',
        'X-D' => '😁',
        'XD' => '😁',
        'x-D' => '😁',
        'xD' => '😁',
        ':-))' => '😃',
        '8)' => '😄',
        ':)' => '😄',
        '<3' => '❤️',
        ':-)' => '😄',
        ':3' => '😄',
        ':D' => '😄',
        ':]' => '😄',
        ':^)' => '😄',
        ':c)' => '😄',
        ':o)' => '😄',
        ':}' => '😄',
        ':っ)' => '😄',
        '=)' => '😄',
        '=]' => '😄',
        '0:)' => '😇',
        '0:-)' => '😇',
        '0:-3' => '😇',
        '0:3' => '😇',
        '0;^)' => '😇',
        'O:-)' => '😇',
        '3:)' => '😈',
        '3:-)' => '😈',
        '}:)' => '😈',
        '}:-)' => '😈',
        '*)' => '😉',
        '*-)' => '😉',
        ':-,' => '😉',
        ';)' => '😉',
        ';-)' => '😉',
        ';-]' => '😉',
        ';D' => '😉',
        ';]' => '😉',
        ';^)' => '😉',
        ':-|' => '😐',
        ':|' => '😐',
        ':(' => '😒',
        ':-(' => '😒',
        ':-<' => '😒',
        ':-[' => '😒',
        ':-c' => '😒',
        ':<' => '😒',
        ':[' => '😒',
        ':c' => '😒',
        ':{' => '😒',
        ':っC' => '😒',
        '%)' => '😖',
        '%-)' => '😖',
        ':-P' => '😜',
        ':-b' => '😜',
        ':-p' => '😜',
        ':-Þ' => '😜',
        ':-þ' => '😜',
        ':P' => '😜',
        ':b' => '😜',
        ':p' => '😜',
        ':Þ' => '😜',
        ':þ' => '😜',
        ';(' => '😜',
        '=p' => '😜',
        'X-P' => '😜',
        'XP' => '😜',
        'd:' => '😜',
        'x-p' => '😜',
        'xp' => '😜',
        ':-||' => '😠',
        ':@' => '😠',
        ':-.' => '😡',
        ':L' => '😡',
        ':S' => '😡',
        ':\\' => '😡',
        '=L' => '😡',
        '=\\' => '😡',
        ':\'(' => '😢',
        ':\'-(' => '😢',
        '^5' => '😤',
        '^<_<' => '😤',
        '|-O' => '😫',
        '|;-)' => '😫',
        ':###..' => '😰',
        ':-###..' => '😰',
        'D8' => '😱',
        'D:' => '😱',
        'D:<' => '😱',
        'D;' => '😱',
        'D=' => '😱',
        'DX' => '😱',
        'v.v' => '😱',
        '8-0' => '😲',
        ':-O' => '😲',
        ':-o' => '😲',
        ':O' => '😲',
        ':o' => '😲',
        'O-O' => '😲',
        'O_O' => '😲',
        'O_o' => '😲',
        'o-o' => '😲',
        'o_O' => '😲',
        'o_o' => '😲',
        ':$' => '😳',
        '#-)' => '😵',
        ':#' => '😶',
        ':&' => '😶',
        ':-#' => '😶',
        ':-&' => '😶',
        ':-X' => '😶',
        ':X' => '😶',
        ':-J' => '😼',
        ':*' => '😽',
        ':^*' => '😽',
        'ಠ_ಠ' => '🙅',
        ':>' => '😄',
        '>.<' => '😡',
        '>:(' => '😠',
        '>:)' => '😈',
        '>:-)' => '😈',
        '>:O' => '😲',
        '>:P' => '😜',
        '>:[' => '😒',
        '>;)' => '😈',
        '>_>^' => '😤',
    ];
    foreach ($emojis as $key => $value) {
        $text = preg_replace('/' . preg_quote($key) . '/', $value, $text);
    }

    return $text;
}

return function () {
    elgg_register_event_handler('init', 'system', 'thewirepro_init');
};
