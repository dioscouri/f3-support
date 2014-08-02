<?php 
namespace Support\Admin\Controllers;

class Dashboard extends \Admin\Controllers\BaseAuth
{
    public function index()
    {
    	$this->app->set('meta.title', 'Support Dashboard');
    	
    	echo $this->theme->renderTheme('Support/Admin/Views::dashboard.php');
    }
}