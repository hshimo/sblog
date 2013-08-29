<?php
namespace SblogApp\Logic;

use \SblogApp\Model\PostModel;

class IndexLogic extends AppLogic
{

    public function getPostList()
    {
        $post_num = 10; // TODO pager
        $post_model = new PostModel();
        $post_list = $post_model->getPostList($post_num);

        return $post_list;
    }

}