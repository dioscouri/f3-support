<?php
namespace Support\Admin;

class Listener extends \Dsc\Singleton
{

    public function onSystemRebuildMenu($event)
    {
        if ($model = $event->getArgument('model'))
        {
            $root = $event->getArgument('root');
            $app = clone $model;
            
            $app->insert(array(
                'type' => 'admin.nav',
                'priority' => 30,
                'title' => 'Support',
                'icon' => 'fa fa-support',
                'is_root' => false,
                'tree' => $root,
                'base' => '/admin/support'
            ));
            
            $children = array(
                array(
                    'title' => 'Dashboard',
                    'route' => './admin/support',
                    'icon' => 'fa fa-support'
                ),
                array(
                    'title' => 'Live Chat',
                    'route' => './admin/support/live-chat',
                    'icon' => 'fa fa-rocket'
                ),                
                array(
                    'title' => 'Settings',
                    'route' => './admin/support/settings',
                    'icon' => 'fa fa-cogs'
                )
            );
            
            $app->addChildren($children, $root);
            
            \Dsc\System::instance()->addMessage('Support added its admin menu items.');
        }
    }
}