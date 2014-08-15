<?php 
namespace Support\Models;

class ChatSessionsArchive extends \Dsc\Mongo\Collections\Nodes
{
    protected $__collection_name = 'support.chat_sessions_archive';
    protected $__type = 'support.chat_sessions_archive';

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
    
    public static function fetchForUser( $user_id )
    {
        $sessions = (new static)->setState('filter.user_id', $admin_id)->getItems();
    
        return $sessions;
    }
    
    public static function fetchForAdmin( $admin_id )
    {
        $sessions = (new static)->setState('filter.admin_id', $admin_id)->getItems();
    
        return $sessions;
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