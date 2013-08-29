<?php
namespace SblogApp\Logic;

use \SblogApp\Model\UserModel;
use \Respect\Validation\Validator as v;

class UserLogic extends AppLogic
{

    public function login($id, $pass)
    {
        $input = array('user_id' => $id, 'password' => $pass);
        $errors = $this->validateLogin($id, $pass);
        if (!empty($errors['errors'])) {
            return array_merge($errors, $input);
        }

        // get user data
        $user_model = new UserModel();
        $user_row = $user_model->getRow($id);
        if ($user_row === false) {
            $errors = array('errors' => array('login' => 'invalid user id or password'));
            return array_merge($errors, $input);
        }

        // check id & password
        if ($this->verifyPassword($pass, $user_row['pass']) === false) {
            $errors = array('errors' => array('login' => 'invalid user id or password'));
            return array_merge($errors, $input);
        }
        $_SESSION['user'] = $user_row;
        return $user_row;
    }

    // go back to original url
    public function setRedirectUrl()
    {
        $redirect_url = '/';
        $get_redirect = $this->app->getSlim()->request()->get('redirect');
        if ($get_redirect && $get_redirect != '/logout' && $get_redirect != '/login') {
            $_SESSION['redirect_url'] = $get_redirect;
        }

        if (isset($_SESSION['redirect_url'])) {
            $redirect_url = $_SESSION['redirect_url'];
        }
        return $redirect_url;
    }

    private function verifyPassword($pass, $hash)
    {
        return password_verify($pass, $hash);
    }

    private function hashPassword($pass)
    {
        return password_hash($pass, PASSWORD_BCRYPT);
    }

    // validate user id & password
    private function validateLogin($id, $pass)
    {
        $errors = array();

        if ( v::string()->notEmpty()->validate($id)== false ) {
            $errors['user_id'] = 'user id is empty.';
        } else {
            $v_user_id = v::alnum()->noWhitespace()->length(3,15);
            if ( $v_user_id->validate($id) == false ) {
                $errors['user_id'] = 'user id has to be 3-15 characters.';
            }
        }
        if ( v::string()->notEmpty()->validate($pass)== false ) {
            $errors['password'] = 'password is empty.';
        } else {
            $v_password = v::alnum()->noWhitespace()->length(4,12);
            if ( $v_password->validate($pass) == false ) {
                $errors['password'] = 'password has to be 4-12 characters.';
            }
        }
        $this->app->getSlim()->view()->setData('errors', $errors);
        return array('errors' => $errors);
    }


}