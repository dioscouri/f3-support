<?php 
namespace Support\Site\Controllers;

class LiveChat extends \Dsc\Controller 
{
    public function index()
    {
        $this->theme->setTheme('SystemTheme');
            
        // are there no operators online?
        $operators = \Support\Models\Operators::fetchActive();
        if (empty($operators)) {
            echo $this->theme->render('Support/Site/Views::livechat/no_operators.php');
            return;           
        }
        
        // TODO is a chat session already started/requested?
        
        // Just display the form
        echo $this->theme->render('Support/Site/Views::livechat/index.php');
    }
}