<?php
namespace Support\Admin;

class Routes extends \Dsc\Routes\Group
{
    public function initialize()
    {
        $this->setDefaults( array(
            'namespace' => '\Support\Admin\Controllers',
            'url_prefix' => '/admin/support' 
        ) );
        
        $this->addSettingsRoutes();
        
        $this->add( '', 'GET', array(
            'controller' => 'Dashboard',
            'action' => 'index'
        ) );
        
        $this->add( '/live-chat', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'index'
        ) );
        
        $this->add( '/live-chat/online', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'goOnline'
        ) );

        $this->add( '/live-chat/offline', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'goOffline'
        ) );

        $this->add( '/live-chat/create/@session_id', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'createSession'
        ) );        
        
        $this->add( '/live-chat/claim/@session_id', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'claimSession'
        ) );

        $this->add( '/live-chat/unclaim/@session_id', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'unclaimSession'
        ) );        
        
        $this->add( '/live-chat/close/@session_id', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'closeSession'
        ) );

        $this->add( '/live-chat/ajax/unclaim/@session_id [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'unclaimSession'
        ) );
        
        $this->add( '/live-chat/ajax/close/@session_id [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'closeSession'
        ) );        

        $this->add( '/live-chat/online-users [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'onlineUsers'
        ) );
        
        $this->add( '/live-chat/online-operators [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'onlineOperators'
        ) );
        
        $this->add( '/live-chat/unclaimed-sessions [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'unclaimedSessions'
        ) );        

        $this->add( '/live-chat/ajax/init [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'init'
        ) );        
        
        $this->add( '/live-chat/ajax/comment/@session_id/@last_checked [ajax]', 'POST', array(
            'controller' => 'LiveChatAjax',
            'action' => 'addComment'
        ) );
        
        $this->add( '/live-chat/ajax/new-messages/@session_id/@last_checked [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'newMessages'
        ) );        
    }
}