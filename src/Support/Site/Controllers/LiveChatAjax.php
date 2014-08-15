<?php 
namespace Support\Site\Controllers;

class LiveChatAjax extends LiveChat 
{
    public function beforeRoute()
    {
        // no matter what, only the support view's html gets returned
        $this->theme->setTheme('SystemTheme');
    } 
    
    public function init()
    {
        $settings = \Support\Models\Settings::fetch();
        if (!$settings->live_chat_enabled)
        {
            return null;
        }
        
        if ($this->session->get('support_close_tab') == 1) 
        {
            return null;
        }
        
        // are there no operators online?
        $operators = \Support\Models\Operators::fetchActive();
        if (empty($operators)) {
            return $this->outputJson( $this->getJsonResponse( array(
                'result' => $this->theme->renderView('Support/Site/Views::livechat/no_operators.php')
            ) ) );           
        }
        
        // is a chat session already started/requested?
        $this->app->set('chat_session', null);
        $chat_session = (new \Support\Models\ChatSessions)->setState('filter.user_session', $this->session->id())->getItem();
        if (!empty($chat_session->id)) 
        {
            $this->app->set('chat_session', $chat_session);
            $this->app->set('messages', $chat_session->messages);
        }
        
        // Display the tab
        return $this->outputJson( $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Site/Views::livechatajax/init.php') 
        ) ) );
    }
    
    public function close()
    {
        // close request if it exists
        $chat_session = (new \Support\Models\ChatSessions)->setState('filter.user_session', $this->session->id())->getItem();
        if (!empty($chat_session->id))
        {
            $chat_session->remove();
        }
                
        // no matter what, set a flag so the tab doesn't display during the session 
        $this->session->set('support_close_tab', 1);
    }
    
    public function createRequest()
    {
        // TODO If the user already has a chat session open, use that one
        
        $model = (new \Support\Models\ChatSessions)->set('status', 'open-request')->set('session_id_user', $this->session->id() );
        if ($this->getIdentity()->id) {
            $model->set('user_id', $this->getIdentity()->id);
        }
        
        $actor = \Activity\Models\Actors::fetch();
        $model->set('user_actor_id', $actor->id);
        
        $model->set('user_email', $this->input->get('email', null, 'string'));
        $model->set('user_name', $this->input->get('name', null, 'string'));
        
        try {
            $chat_session = $model->save();
            
            $this->app->set('chat_session', $chat_session);
            $this->app->set('messages', $chat_session->messages);
            
            return $this->outputJson( $this->getJsonResponse( array(
                'result' => $this->theme->renderView('Support/Site/Views::livechatajax/chat_session.php')
            ) ) );            
        }
        catch (\Exception $e) {
            // TODO Handle this
        }
    }
    
    public function addComment()
    {
        $chat_session = (new \Support\Models\ChatSessions)->setState('filter.user_session', $this->session->id())->getItem();
        if (empty($chat_session->id))
        {
            return;
        }
        
        try {
            $time = time();
            $message = trim( $this->input->get('comment', null, 'string') );
            
            if (!empty($message)) 
            {
                $chat_session = $chat_session->addMessage(new \Support\Models\ChatMessages(array(
                    'sender_type' => 'user',
                    'sender_name' => $chat_session->user_name,
                    'timestamp' => $time,
                    'text' => $message,
                )));
            }
            
            $this->app->set('chat_session', $chat_session);

            $last_checked = (int) $this->app->get('PARAMS.last_checked');
            $this->app->set('messages', $chat_session->messages($last_checked) );
            
            $response = $this->getJsonResponse( array(
                'result' => $this->theme->renderView('Support/Site/Views::livechatajax/chat_messages.php')
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
        
        $chat_session = (new \Support\Models\ChatSessions)->setState('filter.user_session', $this->session->id())->getItem();
        if (empty($chat_session->id))
        {
            return $this->outputJson( $this->getJsonResponse( array(
                'last_checked' => time()
            ) ) );
        }
        
        $new_last_checked = time();
        
        $this->app->set('messages', $chat_session->messages($last_checked) );
        
        $response = $this->getJsonResponse( array(
            'result' => $this->theme->renderView('Support/Site/Views::livechatajax/chat_messages.php')
        ) );

        $response->last_checked = $new_last_checked;
        return $this->outputJson($response);
    }
}