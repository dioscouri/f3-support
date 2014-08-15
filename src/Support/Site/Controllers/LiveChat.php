<?php 
namespace Support\Site\Controllers;

class LiveChat extends \Dsc\Controller 
{
    public function index()
    {
        $this->app->set('meta.title', 'Live Chat | Support');
        
        $this->session->set('support_close_tab', 0);
        
        echo $this->theme->render('Support/Site/Views::livechat/index.php');
    }
}