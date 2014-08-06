<?php
namespace Support\Site;

class Routes extends \Dsc\Routes\Group
{
    public function initialize()
    {
        $this->setDefaults( array(
            'namespace' => '\Support\Site\Controllers',
            'url_prefix' => '/support'
        ) );
        
        $this->add( '/live-chat', 'GET', array(
            'controller' => 'LiveChat',
            'action' => 'index'
        ) );        
        
        $this->add( '/live-chat/ajax/init [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'init'
        ) );
        
        $this->add( '/live-chat/ajax/request [ajax]', 'POST', array(
            'controller' => 'LiveChatAjax',
            'action' => 'createRequest'
        ) );

        $this->add( '/live-chat/ajax/close [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'close'
        ) );        
        
        $this->add( '/live-chat/ajax/comment [ajax]', 'POST', array(
            'controller' => 'LiveChatAjax',
            'action' => 'addComment'
        ) );
        
        $this->add( '/live-chat/ajax/comment/@last_checked [ajax]', 'POST', array(
            'controller' => 'LiveChatAjax',
            'action' => 'addComment'
        ) );        

        $this->add( '/live-chat/ajax/new-messages/@last_checked [ajax]', 'GET', array(
            'controller' => 'LiveChatAjax',
            'action' => 'newMessages'
        ) );        
    }
}