<?php
namespace Sblog\Lib;

class Core
{
    public $app;
    public $slim;

    //public function __construct(\Slim\Slim $slim)
    //{
    //    $this->slim = $slim;
    //}
    //public function __construct(\Miniblog\Application $app)
    //{
    //    $this->app = $app;
    //}

    public function getSlim()
    {
        if (!$this->slim) {
            die('$this->slim in not set at Core');
        }
        return $this->slim;
    }

    public function setSlim(\Slim\Slim $slim)
    {
        if (!$this->slim) {
            $this->slim = $slim;
        }
        return $this->slim;
    }

    public function getApp()
    {
        if (!$this->app) {
            die('$this->app in not set at Core');
        }
        return $this->app;
    }

    public function setApp($app)
    {
        $this->app = $app;
    }



}