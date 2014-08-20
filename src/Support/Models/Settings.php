<?php 
namespace Support\Models;

class Settings extends \Dsc\Mongo\Collections\Settings
{
    protected $__type = 'support.settings';

    public $last_sessions_cleanup = null;
    
    public $live_chat_enabled = false;
    
    public $live_chat_index = null;
    
    public $archive_threshold = 5;      // the minimum number of messages a session must have in order to be archived.  otherwise it is just deleted
}