<?php 
namespace Support\Models;

class ChatMessages extends \Dsc\Models
{
    public $sender_type = null;     // string: admin/user/system
    public $sender_name = null;     // string: for display
    public $timestamp = null;       // time();
    public $text = null;         // text    
}