<?php
/**
 * Translation file
 *
 * Note: don't change the return array to short notation because Transifex can't handle those during `tx push -s`
 */
$plugin = elgg_get_plugin_from_id('thewirepro');
$name = $plugin->the_wire_name;
$placeholder = $plugin->the_wire_placeholder;
if (!$name) {
    $name = 'wire';
}
if (!$placeholder) {
    $placeholder = "What's happening?";
}

return array(

    /**
     * Menu items and titles
     */
    'thewire' => ucfirst($name),

    'item:object:thewire' => ucfirst($name) . " post",
    'collection:object:thewire' => ucfirst($name) . ' posts',
    'collection:object:thewire:all' => "All " . $name . " posts",
    'collection:object:thewire:owner' => "%s's " . $name . " posts",
    'collection:object:thewire:friends' => "Friends's " . $name . " posts",

    'thewire:replying' => "Replying to %s (@%s) who wrote",
    'thewire:thread' => "Thread",
    'thewire:charleft' => "characters remaining",
    'thewire:tags' => ucfirst($name) . " posts tagged with '%s'",
    'thewire:noposts' => "No " . $name . " posts yet",

    'thewire:by' => ucfirst($name) . ' post by %s',
    'thewire:previous:help' => "View previous post",
    'thewire:hide:help' => "Hide previous post",

    'thewire:form:body:placeholder' => $placeholder,

    /**
     * The wire river
     */
    'river:object:thewire:create' => "%s posted to %s",
    'thewire:wire' => $name,

    /**
     * Wire widget
     */

    'widgets:thewire:description' => 'Display your latest ' . $name . ' posts',
    'thewire:num' => 'Number of posts to display',
    'thewire:moreposts' => 'More ' . $name . ' posts',

    /**
     * Status messages
     */
    'thewire:posted' => "Your message was successfully posted to " . $name . ".",
    'thewire:deleted' => $name . " post was successfully deleted.",
    'thewire:blank' => "Sorry, you need to enter some text before we can post this.",
    'thewire:notsaved' => "Sorry. We could not save this " . $name . " post.",
    'thewire:notdeleted' => "Sorry. We could not delete this " . $name . "post.",

    /**
     * Notifications
     */
    'thewire:notify:summary' => 'New ' . $name . ' post: %s',
    'thewire:notify:subject' => "New " . $name . " post from %s",
    'thewire:notify:reply' => '%s responded to %s on ' . $name . ':',
    'thewire:notify:post' => '%s posted on ' . $name . ':',
    'thewire:notify:footer' => "View and reply:\n%s",

    /**
     * Settings
     */
    'thewire:settings:limit' => "Maximum number of characters for wire messages:",
    'thewire:settings:reply_as_comment' => "Show reply's as comment?",
    'thewire:settings:rename' => "What should the wire be called ?",
    'thewire:settings:wire_placeholder' => "What should be displayed in placeholder ? [Replace's 'What's happening?']",
    'thewire:settings:embed_whitelist' => "Write the list of comma seprated list of whitelisted domain for post embed for example to enable www.youtube.com just write 'youtube'. Example [youtube,twitter,facebook]. Keep this empty to enable embed on all domains",

    'thewire:settings:limit:none' => "No limit",
);
