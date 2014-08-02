<?php 
namespace Support\Admin\Controllers;

class Settings extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\Settings;
	
	protected $layout_link = 'Support/Admin/Views::settings/default.php';
	protected $settings_route = '/admin/support/settings';
    
    protected function getModel()
    {
        $model = new \Support\Models\Settings;
        return $model;
    }
}