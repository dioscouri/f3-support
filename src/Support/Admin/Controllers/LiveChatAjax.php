<?php 
namespace Support\Admin\Controllers;

class LiveChatAjax extends LiveChat 
{
    public function beforeRoute()
    {
        // no matter what, only the support view's html gets returned
        $this->theme->setTheme('SystemTheme');
    } 
    
    public function init()
    {
        $user = $this->getIdentity();
        if (empty($user->id)) 
        {
            return;
        }
        
        // Display the tabs
        return $this->outputJson( $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Admin/Views::livechatajax/init.php') 
        ) ) );
    }
    
    public function unclaimedSessions()
    {
        $user = $this->getIdentity();
        if (empty($user->id))
        {
            return;
        }
                
        $unclaimed = \Support\Models\ChatSessions::unclaimed();
        $is_online = \Support\Models\Operators::isOnline( $user );
        
        echo $this->outputJson( $this->getJsonResponse( array(
            'alert' => $is_online ? true : false,
            'count' => count($unclaimed),
            'result' => $this->theme->renderView('Support/Admin/Views::livechat/fragment_unclaimed_sessions.php')
        ) ) );
    }
    
    public function onlineUsers()
    {
        $user = $this->getIdentity();
        if (empty($user->id))
        {
            return;
        }
                
        echo $this->outputJson( $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Admin/Views::livechat/fragment_online_users.php')
        ) ) );
    }    
    
    public function onlineOperators()
    {
        $user = $this->getIdentity();
        if (empty($user->id))
        {
            return;
        }
                
        echo $this->outputJson( $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Admin/Views::livechat/fragment_online_operators.php')
        ) ) );
    }    
    
    public function addComment()
    {
        $chat_session_id = $this->app->get('PARAMS.session_id');
        
        $chat_session = (new \Support\Models\ChatSessions)->setState('filter.id', $chat_session_id)->getItem();
        if (empty($chat_session->id))
        {
            return;
        }
        
        try {
            $time = time();
            $message = $this->input->get('comment', null, 'string');
            $chat_session = $chat_session->addMessage(new \Support\Models\ChatMessages(array(
                'sender_type' => 'admin',
                'sender_name' => $this->getIdentity()->first_name,
                'timestamp' => $time,
                'text' => $message,
            )));
            
            $this->app->set('chat_session', $chat_session);

            $last_checked = (int) $this->app->get('PARAMS.last_checked');
            $this->app->set('messages', $chat_session->messages($last_checked) );
            
            $response = $this->getJsonResponse( array(
                'result' => $this->theme->renderView('Support/Admin/Views::livechatajax/chat_messages.php'),
                'current_url' => $chat_session->userSessionData()->path
            ) );
            
            $response->last_checked = $time;
            return $this->outputJson($response);
        }
        catch (\Exception $e) {
            // TODO Handle this
        } 
    }
    
    public function newMessages()
    {
        $last_checked = (int) $this->app->get('PARAMS.last_checked');
        $chat_session_id = $this->app->get('PARAMS.session_id');
        
        $chat_session = (new \Support\Models\ChatSessions)->setState('filter.id', $chat_session_id)->getItem();
        if (empty($chat_session->id))
        {
            return $this->outputJson( $this->getJsonResponse( array(
                'result' => $this->theme->renderView('Support/Admin/Views::livechatajax/chat_session_closed.php'),
                'last_checked' => time(),
                'stop_polling' => true
            ) ) );
        }
        
        $new_last_checked = time();
        
        $this->app->set('chat_session', $chat_session);
        $this->app->set('messages', $chat_session->messages($last_checked) );
        
        $response = $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Admin/Views::livechatajax/chat_messages.php'),
            'current_url' => $chat_session->userSessionData()->path
        ) );

        $response->last_checked = $new_last_checked;
        return $this->outputJson($response);
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
                throw new \Exception( 'You cannot leave that session because you are not in it!' );
            }
    
            $chat_session->session_id_admin = null;
            $chat_session->admin_id = null;
            $chat_session->admin_name = null;
            $chat_session->admin_email = null;
            $chat_session->status = 'open-request';
            
            $chat_session->messages[] = (new \Support\Models\ChatMessages(array(
                'sender_type' => 'system',
                'sender_name' => 'System Bot',
                'timestamp' => time(),
                'text' => $this->getIdentity()->first_name . ' has left this session.',
            )))->cast();            
    
            $chat_session->save();
            
            return $this->outputJson( $this->getJsonResponse( array(
                'message' => 'You have left that session'
            ) ) );            
        }
        catch (\Exception $e) {
            $message = 'There was an error leaving that session. ';
            $message .= $e->getMessage();
            
            return $this->outputJson( $this->getJsonResponse( array(
                'message' => $message
            ) ) );            
        }
    }
    
    public function closeSession()
    {
        $chat_session_id = $this->app->get('PARAMS.session_id');
    
        try {
            $chat_session = (new \Support\Models\ChatSessions)->setState('filter.id', $chat_session_id)->getItem();
            if (empty($chat_session->id)) {
                throw new \Exception( 'Invalid Session' );
            }
            
            if ($chat_session->admin_id != (string) $this->getIdentity()->id) {
                throw new \Exception( 'You cannot close that session because you are not in it!' );
            }

            $chat_session->messages[] = (new \Support\Models\ChatMessages(array(
                'sender_type' => 'system',
                'sender_name' => 'System Bot',
                'timestamp' => time(),
                'text' => 'This session has been closed by ' . $this->getIdentity()->first_name,
            )))->cast();            

            $chat_session->archive();
    
            $message = 'You closed that session';
            
            return $this->outputJson( $this->getJsonResponse( array(
                'message' => $message
            ) ) );            
        }
        catch (\Exception $e) {
            $message = 'There was an error closing that session. ';
            $message .= $e->getMessage();
            
            return $this->outputJson( $this->getJsonResponse( array(
                'message' => $message
            ) ) );            
        }
    }    
}