<?php
namespace SblogApp\Logic;

use \SblogApp\Model\PostModel;
use \Sblog\Model\CommentModel;

class PostLogic extends AppLogic
{

    public function getRow($id)
    {
        if (!$id) {
            return $array();
        }

        $post_model = new PostModel();
        $one_post = $post_model->getRow($id);

        return $one_post;
    }



}