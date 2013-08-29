<?php
namespace SblogApp\Controller;

use \SblogApp\Logic\UserLogic;

class User extends \Sblog\Controller\AppController
{

    public function login()
    {
        $slim = $this->app->getSlim();
        $user_id = $slim->request()->post('user_id');
        $password = $slim->request()->post('password');

        $user_logic = new UserLogic();
        $user_logic->setApp($this->app);
        $result = $user_logic->login($user_id, $password);
        $result['redirect_url'] = $user_logic->setRedirectUrl();

        return $result;
    }


}