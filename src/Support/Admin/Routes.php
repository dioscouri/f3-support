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
    }
}