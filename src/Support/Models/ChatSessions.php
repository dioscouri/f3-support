<?php 
namespace Support\Models;

class ChatSessions extends \Dsc\Mongo\Collections\Nodes
{
    protected $__collection_name = 'support.chat_sessions';
    protected $__type = 'support.chat_sessions';

    public $status;                 // open-request, claimed
    
    public $session_id_user = null; // primary key for identifying the chat session -- is the visitor's session_id
    public $user_id = null;         // if present, the visitor's user_id
    public $admin_id = null;        // the admin's user_id
    public $session_id_admin = null;    // the admin's session_id

    public $user_actor_id = null;   // the f3-activity actor_id for this chat session
    
    public $user_email = null;
    public $user_name = null;
    public $admin_name = null;
        
    public $messages = array();
    
    protected function fetchConditions()
    {
        parent::fetchConditions();
        
        $filter_user_session = $this->getState('filter.user_session');
        if (strlen($filter_user_session))
        {
            $this->setCondition( 'session_id_user', $filter_user_session );
        }
        
        $filter_admin_session = $this->getState('filter.admin_session');
        if (strlen($filter_admin_session))
        {
            $this->setCondition( 'session_id_admin', $filter_admin_session );
        }
        
        $filter_user_id = $this->getState('filter.user_id');
        if (strlen($filter_user_id))
        {
            $this->setCondition( 'user_id', $filter_user_id );
        }
                
        $filter_admin_id = $this->getState('filter.admin_id');
        if (strlen($filter_admin_id))
        {
            $this->setCondition( 'admin_id', $filter_admin_id );
        }

        $filter_status = $this->getState('filter.status');
        if (strlen($filter_status))
        {
            $this->setCondition( 'status', $filter_status );
        }
        
        return $this;
    }
    
    protected function beforeCreate()
    {
        if (empty($this->messages)) 
        {
            if (!is_array($this->messages)) {
                $this->messages = array();
            }
            
            // TODO Allow admins to set this
            $system_message = 'Hello, thanks for starting a support session.  One of our operators will be with you momentarily.  Feel free to continue browsing through our site while you wait.';
            
            $this->messages[] = (new \Support\Models\ChatMessages(array(
                'sender_type' => 'system',
                'sender_name' => 'System Bot',
                'timestamp' => time(),
                'text' => $system_message,
            )))->cast(); 
        }
        
        $exists = static::collection()->findOne(array(
            'session_id_user' => $this->session_id_user
        ));
        
        if (isset($exists['_id'])) {
            $this->setError('Only one session per user');
        }
        
        return parent::beforeCreate();        
    }
    
    protected function beforeSave()
    {
        return parent::beforeSave();
    }
    
    public function addMessage( \Support\Models\ChatMessages $message ) 
    {
        if (!is_array($this->messages)) {
            $this->messages = array();
        }
        
        $this->messages[] = $message->cast();        
                
        return $this->store();
    }
    
    public function messages( $after=null ) 
    {
        if (empty($after)) 
        {
            return $this->messages;
        }
        
        $agg = static::collection()->aggregate(array(
            array(
                '$match' => array(
                    '_id' => $this->_id
                )
            ),
            array(
                '$project' => array(
                    'messages' => 1
                )
            ),            
            array(
                '$unwind' => '$messages'
            ),
            array(
                '$match' => array(
                    'messages.timestamp' => array( '$gt' => $after )
                )
            ),
            array(
                '$sort' => array( 'messages.timestamp' => 1 )
            ),
            array(
                '$project' => array(
                    'sender_type' => '$messages.sender_type',
                    'sender_name' => '$messages.sender_name',
                    'timestamp' => '$messages.timestamp',
                    'text' => '$messages.text'
                )
            ),            
        ));

        $items = array();
        if (!empty($agg['ok']) && !empty($agg['result']))
        {
            $items = $agg['result'];
        }
        
        return $items;        
    }
    
    public static function unclaimed()
    {
        $unclaimed = (new static)->setState('filter.status', 'open-request')->getItems();
        
        return $unclaimed;
    }
    
    public static function fetchForSession( $session_id, $site='site' ) 
    {
        if ($site == 'admin') {
            $session = (new static)->setState('filter.admin_session', $session_id)->getItem();
        } else {
            $session = (new static)->setState('filter.user_session', $session_id)->getItem();
        }
        
        if (!empty($session->id)) 
        {
            return $session;
        }
        
        $session = new static;
        
        return $session;
    }

    public static function fetchForAdmin( $admin_id )
    {
        $sessions = (new static)->setState('filter.admin_id', $admin_id)->getItems();
    
        return $sessions;
    }
    
    public static function cleanup($max=null)
    {
        if (empty($max))
        {
            $max = 300; // 5 minutes
        }

        /*
        static::collection()->remove(array(
            'metadata.last_modified.time' => array(
                '$lt' => time() - $max
            )
        ), array(
            'w' => 0
        ));
        */
        
        $active_session_ids = \Dsc\Mongo\Collections\Sessions::collection()->distinct("session_id", array(
            'timestamp' => array( '$gt' => time() - $max ),
            'site_id' => 'site'
        ));

        if (empty($active_session_ids)) 
        {
            $conditions = array();
        }
        else 
        {
            $conditions = array(
                'session_id_user' => array( '$nin' => $active_session_ids )                
            );
        }
        
        static::collection()->remove( $conditions, array(
            'w' => 0
        ));        
    
        return true;
    }
    
    public static function throttledCleanup()
    {
        $settings = \Support\Models\Settings::fetch();
        if (empty($settings->last_sessions_cleanup) || $settings->last_sessions_cleanup < (time() - 900))
        {
            $settings->last_sessions_cleanup = time();
    
            if (empty($settings->id)) {
                $settings->save();
            } else {
                $settings->store();
            }
    
            return static::cleanup();
        }
    
        return null;
    }    
    
    /**
     * Gets the associated user object
     *
     * @return unknown
     */
    public function user()
    {
        $user = (new \Users\Models\Users)->load(array('_id'=>$this->user_id));
    
        return $user;
    }    
}