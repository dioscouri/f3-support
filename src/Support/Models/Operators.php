<?php 
namespace Support\Models;

class Operators extends \Users\Models\Users
{
    protected $__collection_name = 'support.operators';
    protected $__type = 'support.operators';
    
    public $is_online = true;
    public $last_activity = null;
    public $open_sessions = 0;
    
    protected function fetchConditions()
    {
        parent::fetchConditions();
        
        $filter_active_after = $this->getState('filter.active_after');
        if (strlen($filter_active_after))
        {
            $this->setCondition( '$and', array( 'last_activity' => array ( '$gt' => $filter_active_after ) ), 'append' );
        }
        
        return $this;
    }
    
    public static function goOnline( \Users\Models\Users $user )
    {
        $op = (new static)->setState('filter.id', $user->id)->getItem();
        if (empty($op->id)) 
        {
            $op = (new static($user))->set('last_activity', time())->store();
        }
        
        return $op;
    }
    
    public static function goOffline( \Users\Models\Users $user )
    {
        $op = (new static)->setState('filter.id', $user->id)->getItem();
        if (!empty($op->id)) 
        {
            $op->remove();
            
            return true;
        }
        
        return null;
    }    
    
    /**
     * Marks this operator as active 
     * 
     * @return \Support\Models\Operators
     */
    public function markActive()
    {
        $this->last_activity = time();
        $this->store();
        
        return $this;
    }
    
    /**
     * Is this operator online
     *
     * @param \Users\Models\Users $user
     */
    public static function isOnline( \Users\Models\Users $user )
    {
        $op = (new static)->setState('filter.id', $user->id)->getItem();
        if (!empty($op->id))
        {
            return $op;
        }
    
        return false;
    }    
    
    /**
     * Is this operator active
     * 
     * @param \Users\Models\Users $user
     */
    public static function isActive( \Users\Models\Users $user )
    {
        $op = (new static)->setState('filter.id', $user->id)->getItem();
        if (!empty($op->id) && $op->last_activity >= (time() - 300))
        {
            return $op;
        }
        
        return false;
    }
    
    /**
     *
     * @param string $after
     * @param string $before
     * @return unknown
     */
    public static function fetchActive( $after=null, $before=null )
    {
        if (is_null($after))
        {
            $last_active = 5; // TODO fetch from a setting  // 5 minutes ago
            $after = time() - ($last_active * 60);
        }
    
        $items = (new static)->setState('filter.active_after', $after)->getitems();
    
        return $items;
    }    
}