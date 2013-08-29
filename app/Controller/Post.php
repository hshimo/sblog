<?php
namespace SblogApp\Controller;

use \SblogApp\Logic\PostLogic;
use \SblogApp\Logic\CommentLogic;

class Post extends \Sblog\Controller\AppController
{

    public function index($id)
    {
        // get one blog post
        $post_logic = new PostLogic();
        $data['one_post'] = $post_logic->getRow($id);
        // get comments
        $comment_logic = new CommentLogic();
        $data['comments'] = $comment_logic->getAll($id);

        return $data;
    }

    // write comment to DB
    public function comment($id)
    {
        if (empty($id)) throw new \Exception('Error: no id.');

        $params = $this->app->getSlim()->request()->post();
        $comment_logic = new CommentLogic();
        $comment_logic->setApp($this->app);
        // validate post params
        if ( $comment_logic->isCommentValidated($params) == false) {
            return false;
        }
        $params['post_id'] = $id;
        // insert comment to DB
        $result = $comment_logic->insertComment($params);
        return $result;
    }


}