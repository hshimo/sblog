<?php
namespace SblogApp\Controller;

use \SblogApp\Logic\IndexLogic;

class Index
{

    // TOP page: show post list
    public function index()
    {
        // get latest blog post
        $index_logic = new IndexLogic();
        $post_list = $index_logic->getPostList();

        return $post_list;
    }

}
