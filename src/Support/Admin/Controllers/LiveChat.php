<?php 
namespace Support\Admin\Controllers;

class LiveChat extends \Admin\Controllers\BaseAuth
{
    public function index()
    {
    	$this->app->set('meta.title', 'Live Chat | Support');
    	
    	echo $this->theme->renderTheme('Support/Admin/Views::livechat/index.php');
    }
    
    public function onlineUsers()
    {
        echo $this->outputJson( $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Admin/Views::livechat/fragment_online_users.php') 
        ) ) );
    }
    
    public function onlineOperators()
    {
        echo $this->outputJson( $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Admin/Views::livechat/fragment_online_operators.php')
        ) ) );
    }

    public function goOnline()
    {
        $user = $this->getIdentity();
        
        try {
            \Support\Models\Operators::goOnline( $user );
            \Dsc\System::addMessage('You are now online');
        }
        catch (\Exception $e) {
            \Dsc\System::addMessage('There was an error marking you as online', 'error');
            \Dsc\System::addMessage($e->getMessage(), 'error');
        }        
        
        $this->app->reroute('/admin/support/live-chat');
    }

    public function goOffline()
    {
        $user = $this->getIdentity();
        
        try {
            \Support\Models\Operators::goOffline( $user );
            \Dsc\System::addMessage('You are now offline');
        }
        catch (\Exception $e) {
            \Dsc\System::addMessage('There was an error taking you offline', 'error');
            \Dsc\System::addMessage($e->getMessage(), 'error');            
        }
        
        $this->app->reroute('/admin/support/live-chat');        
    }    
    
    public function createSession()
    {
        $session_id = $this->app->get('PARAMS.session_id');
    
        try {
            $chat_session = (new \Support\Models\ChatSessions)->setState('filter.session_id', $session_id)->getItem();
            if (!empty($chat_session->id)) {
                throw new \Exception( 'There is already an open request for that visitor.' );
            }
            
            $user_session = (new \Dsc\Mongo\Collections\Sessions)->setState('filter.session', $session_id)->getItem(); 
            if (empty($user_session->id)) {
                throw new \Exception( 'Invalid Session' );
            }
            
            $chat_session = new \Support\Models\ChatSessions;
            
            $chat_session->user_id = $user_session->user_id;            
            $chat_session->session_id_user = $session_id;
            $chat_session->session_id_admin = $this->session->id();
            $chat_session->admin_id = new \MongoId( (string) $this->getIdentity()->id );
            $chat_session->admin_name = $this->getIdentity()->first_name;
            $chat_session->status = 'claimed';
            
            $message = 'Hello, is there anything I can help you with?'; // TODO Allow to be set by admin
            
            $chat_session->messages[] = (new \Support\Models\ChatMessages(array(
                'sender_type' => 'admin',
                'sender_name' => $chat_session->admin_name,
                'timestamp' => time(),
                'text' => $message,
            )))->cast();            
    
            $chat_session->save();
    
            \Dsc\System::addMessage('You created a new session');
        }
        catch (\Exception $e) {
            \Dsc\System::addMessage('There was an error creating that session.', 'error');
            \Dsc\System::addMessage($e->getMessage(), 'error');
        }
    
        $this->app->reroute('/admin/support/live-chat');
    }    
    
    public function claimSession()
    {
        $chat_session_id = $this->app->get('PARAMS.session_id');
        
        try {
            $chat_session = (new \Support\Models\ChatSessions)->setState('filter.id', $chat_session_id)->getItem();
            if (empty($chat_session->id)) {
                throw new \Exception( 'Invalid Session' );
            }
            
            $chat_session->session_id_admin = $this->session->id();
            $chat_session->admin_id = new \MongoId( (string) $this->getIdentity()->id );
            $chat_session->admin_name = $this->getIdentity()->first_name;
            $chat_session->status = 'claimed';
            
            $chat_session->save();

            \Dsc\System::addMessage('You claimed that session');
            
        }
        catch (\Exception $e) {
            \Dsc\System::addMessage('There was an error claiming that session.', 'error');
            \Dsc\System::addMessage($e->getMessage(), 'error');
        }
        

        try {
            $user = $this->getIdentity();
            \Support\Models\Operators::goOnline( $user );
            \Dsc\System::addMessage('You are now online');
        }
        catch (\Exception $e) {
            \Dsc\System::addMessage('There was an error marking you as online', 'error');
            \Dsc\System::addMessage($e->getMessage(), 'error');
        }
        
        $this->app->reroute('/admin/support/live-chat');
    }
    
    public function unclaimSession()
    {
        $chat_session_id = $this->app->get('PARAMS.session_id');
    
        try {
            $chat_session = (new \Support\Models\ChatSessions)->setState('filter.id', $chat_session_id)->getItem();
            if (empty($chat_session->id)) {
                throw new \Exception( 'Invalid Session' );
            }
    
            if ($chat_session->admin_id != (string) $this->getIdentity()->id) {
                throw new \Exception( 'You cannot leave this session because you are not in it!' );
            }
            
            $chat_session->session_id_admin = null;
            $chat_session->admin_id = null;
            $chat_session->admin_name = null;
            $chat_session->status = 'open-request';
    
            $chat_session->save();
    
            \Dsc\System::addMessage('You have left that session');
        }
        catch (\Exception $e) {
            \Dsc\System::addMessage('There was an error leaving that session.', 'error');
            \Dsc\System::addMessage($e->getMessage(), 'error');
        }
    
        $this->app->reroute('/admin/support/live-chat');
    }

    public function closeSession()
    {
        $chat_session_id = $this->app->get('PARAMS.session_id');
    
        try {
            $chat_session = (new \Support\Models\ChatSessions)->setState('filter.id', $chat_session_id)->getItem();
            if (empty($chat_session->id)) {
                throw new \Exception( 'Invalid Session' );
            }
    
            $chat_session->session_id_admin = $this->session->id();
            $chat_session->admin_id = new \MongoId( (string) $this->getIdentity()->id );
            $chat_session->admin_name = $this->getIdentity()->first_name;
            $chat_session->status = 'claimed';
    
            $chat_session->save();
    
            \Dsc\System::addMessage('You claimed that session');
        }
        catch (\Exception $e) {
            \Dsc\System::addMessage('There was an error claiming that session.', 'error');
            \Dsc\System::addMessage($e->getMessage(), 'error');
        }
    
        $this->app->reroute('/admin/support/live-chat');
    }

    public function unclaimedSessions()
    {
        echo $this->outputJson( $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Admin/Views::livechat/fragment_unclaimed_sessions.php')
        ) ) );        
    }
}