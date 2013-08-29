<?php
namespace SblogApp\Logic\Admin;

use \SblogApp\Model\PostModel;
use \Respect\Validation\Validator as v;

class PostLogic extends \SblogApp\Logic\AppLogic
{

    public function newpost($request)
    {
        $errors = $this->validateNewPost($request);
        if (!empty($errors['errors'])) {
            return $errors;
        }



        // insert post data
        $post_model = new PostModel();
        $result = $post_model->insert($request);
        if (!$result) {
            return array('errors' => array('newpost' => 'DB insert error'));
        }
        return array();
    }

    // validate title & content
    private function validateNewPost($request)
    {
        $errors = array();

        $title   = isset($request['title']) ? $request['title'] : '';
        $content = isset($request['content']) ? $request['content'] : '';

        // Title
        if ( v::string()->notEmpty()->validate($title) == false ) {
            $errors['title'] = 'Title is empty.';
        } else {
            $v_title = v::alnum()->length(1,80);
            if ( $v_title->validate($title) == false ) {
                $errors['title'] = 'Title has to be 1-80 characters.';
            }
        }
        // Content
        if ( v::string()->notEmpty()->validate($content) == false ) {
            $errors['content'] = 'Blog content is empty.';
        } else {
            $v_content = v::alnum()->length(1,2000);
            if ( $v_content->validate($content) == false ) {
                $errors['content'] = 'Blog content has to be 1-2000 characters.';
            }
        }
        $this->app->getSlim()->view()->setData('errors', $errors);
        return array('errors' => $errors);
    }

    // Blog post list
    public function getPostList()
    {
        $post_num = 10;
        $post_model = new PostModel();
        $post_list = $post_model->getPostList($post_num);

        return $post_list;
    }

    // Delete a post
    public function deletePost($id)
    {
        $errors = $this->validateDeletePost($id);
        if (!empty($errors['errors'])) {
            return $errors;
        }

        // Delete post data
        $post_model = new PostModel();
        $result = $post_model->delete($id);
        if (!$result) {
            return array('errors' => array('newpost' => 'DB delete error'));
        }
        return array();
    }

    // validate
    private function validateDeletePost($id)
    {
        $errors = array();
        if (!isset($id) or empty($id)) {
            $errors['id'] = 'No id is specified.';
        }
        $id = (int) $id;

        // Delete post_id
        if ( v::numeric()->notEmpty()->validate($id) == false ) {
            $errors['id'] = 'id is not numeric';
        }
        $this->app->getSlim()->view()->setData('errors', $errors);
        return array('errors' => $errors);
    }


    // Edit a post
    public function editPost($request, $id)
    {
        $errors = array();
        if (!isset($id) or empty($id)) {
            $errors['errors']['id'] = 'No id is specified.';
        }
        $errors = $this->validateNewPost($request);
        if (!empty($errors['errors'])) {
            return $errors;
        }

        // Edit post data
        $post_model = new PostModel();
        $result = $post_model->update($request, $id);
        if (!$result) {
            return array('errors' => array('editpost' => 'DB update error'));
        }
        return array();
    }


}