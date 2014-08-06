<?php
namespace Support\Listeners;

class Users extends \Dsc\Singleton 
{
    public function afterUserLogout( $event )
    {
        $identity = $event->getArgument('identity');
        
        try {
            \Support\Models\Operators::goOffline( $identity );
        }
        catch (\Exception $e) {
            // TODO log this
        }
                
    }
}