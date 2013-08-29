<?php

namespace Miniblog\Lib;

class Session extends \Miniblog\Lib\Core
{

    public function __construct($app)
    {
        $this->setApp($app);
        $this->initialize();
    }

    public function initialize()
    {
        $app = $this->app;
        // Session
        $app->getSlim()->add(new \Slim\Middleware\SessionCookie(array(
            'expires' => '20 minutes',
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httponly' => false,
            'name' => 'slim_session',
            'secret' => SECRET_KEY,
            'cipher' => MCRYPT_RIJNDAEL_256,
            'cipher_mode' => MCRYPT_MODE_CBC
        )));
        // set $user
        $app->getSlim()->hook('slim.before.dispatch', function() use ($app) {
            $user = null;
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
            }
            $app->getSlim()->view()->setData('user', $user);
        });

    }

    public function auth()
    {
        $app = $this->app;
        $auth = function ($app) {
            return function () use ($app) {
                if (!isset($_SESSION['user'])) {
                    $_SESSION['redirect_url'] = $app->getSlim()->request()->getPathInfo();
                    $app->getSlim()->flash('errors.login', 'Login required');
                    $app->getSlim()->redirect('/login');
                }
            };
        };
        return $auth;
    }


}
