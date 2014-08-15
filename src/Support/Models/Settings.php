<?php 
namespace Support\Models;

class Settings extends \Dsc\Mongo\Collections\Settings
{
    protected $__type = 'support.settings';

    public $last_sessions_cleanup = null;
    
    public $live_chat_enabled = false;
    
    public $live_chat_index = null;
}