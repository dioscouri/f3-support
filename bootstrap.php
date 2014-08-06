<?php
class SupportBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Support';
    
    protected function preSite()
    {
        parent::preSite();
    
        $settings = \Support\Models\Settings::fetch();
        
        if (class_exists('\Minify\Factory'))
        {
            \Minify\Factory::registerPath($this->dir . "/src/");
            
            $files = array();
            
            if ($settings->live_chat_enabled) 
            {
                $files[] = 'Support/Assets/js/poller.js';
                $files[] = 'Support/Assets/js/site.js';
            }
    
            foreach ($files as $file)
            {
                \Minify\Factory::js($file);
            }
            
            $files = array(
                'Support/Assets/css/site.css',
            );
            
            foreach ($files as $file)
            {
                \Minify\Factory::css($file);
            }            
        }
        
        \Support\Models\ChatSessions::throttledCleanup();
    }

    protected function preAdmin()
    {
        parent::preAdmin();
    
        if (class_exists('\Minify\Factory'))
        {
            \Minify\Factory::registerPath($this->dir . "/src/");
    
            $files = array(
                'Support/Assets/js/poller.js',
                'Support/Assets/js/admin.js',
            );
    
            foreach ($files as $file)
            {
                \Minify\Factory::js($file);
            }
            
            $files = array(
                'Support/Assets/css/admin.css',
            );
            
            foreach ($files as $file)
            {
                \Minify\Factory::css($file);
            }            
        }
        
        if ($op = \Support\Models\Operators::isOnline( $this->auth->getIdentity() )) 
        {
            $op->markActive();
        }
        
        \Dsc\System::instance()->getDispatcher()->addListener(\Support\Listeners\Users::instance());
        
        \Support\Models\ChatSessions::throttledCleanup();
    }    
}
$app = new SupportBootstrap();