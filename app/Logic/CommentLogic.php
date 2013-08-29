<?php
namespace SblogApp\Logic;

use \Sblog\Model\CommentModel;
//use \Respect\Validation\Validator as v;

class CommentLogic extends AppLogic
{

    public function getAll($id)
    {
        if (!$id) {
            throw new \Exception('no id');
        }

        $comment_model = new CommentModel();
        $comments = $comment_model->getAll($id);

        return $comments;
    }

    public function insertComment($params)
    {
        $comment_model = new CommentModel();
        $result = $comment_model->insertComment($params);
        return $result;
    }

    // FIXME use Respect\Validation. see Logic/UserLogic.php
    public function isCommentValidated($params)
    {
        $validated = true;
        if (empty($params['name'])) {
            // name is optional
            //$this->app->getSlim()->flash('error.name', 'name is empty.');
            //$validated = false;
        } else {
            // TODO check length
            $this->app->getSlim()->flash('comment.name', $params['name']);
        }
        if (empty($params['email'])) {
            // email is optional
            //$this->app->getSlim()->flash('error.name', 'email is empty.');
            //$validated = false;
        } else {
            // TODO check email
            $this->app->getSlim()->flash('comment.email', $params['email']);
        }
        if (empty($params['comment'])) {
            $this->app->getSlim()->flash('error.name', 'comment is empty.');
            $validated = false;
        } else {
            // TODO check length
            $this->app->getSlim()->flash('comment.comment', $params['comment']);
        }
        return $validated;
    }


}