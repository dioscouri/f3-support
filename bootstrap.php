<?php
class SupportBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Support';
}
$app = new SupportBootstrap();