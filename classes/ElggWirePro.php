<?php
/**
 * ElggWire Class
 *
 * @property string $method      The method used to create the wire post (site, sms, api)
 * @property bool   $reply       Whether this wire post was a reply to another post
 * @property int    $wire_thread The identifier of the thread for this wire post
 */
class ElggWirePro extends ElggWire
{

    /**
     * {@inheritDoc}
     * @see ElggObject::canComment()
     */
    public function canComment($user_guid = 0, $default = null)
    {
        $comment_enabled = elgg_get_plugin_setting('reply_as_comment', 'thewirepro', 'yes');

        if ($comment_enabled == 'yes') {
            return true;
        } else {
            return false;
        }
    }

}
