<?php
namespace SblogApp\Controller;

//use \SblogApp\Model\UserModel;

class Admin extends \Sblog\Lib\Controller
{

    public function index()
    {
        $this->render('index/index', array(
            'date' => date('c')
        ));
    }

    public function hello($name)
    {

        $user = new UserModel();
        //$user = new \SblogApp\Model\User();


        //$user = new \Sblog\Lib\Model();
        $user->test();


        $this->render('index/hello', array(
            'name' => $name
        ));
    }
}