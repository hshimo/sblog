<?php
/**
 *
 *
 */
namespace SblogApp\Model;

class PostModel extends AppModel
{
    public $table = 'posts';

    public function getRow($id)
    {
        if (!$id) {
            throw new \Exception('Error: no id.');
        }
        // TODO pager
        $sql = "SELECT * FROM posts WHERE id = ? AND status = 'publish' LIMIT 1";
        $param = array($id);
        $result = $this->db->getRow($sql, $param);

        return $result;
    }

    public function getPostList($limit = 10)
    {
        // TODO pager
        $sql = "SELECT * FROM posts WHERE status = 'publish' LIMIT 10";
        $param = array($limit);
        $result = $this->db->getAll($sql, $param);

        return $result;
    }

    public function insert($params)
    {
        if (empty($params)) {
            throw new \Exception('Error: param empty.');
        }
        $user_id = $_SESSION['user']['id'];
        if (!isset($user_id) or empty($user_id)) {
            throw new \Exception('Error: no user_id');
        }

        $now = date('Y-m-d H:i:s');
        $data = array(
            'user_id'       => $user_id,
            'post_date'     => $now,
            'content'       => $params['content'],
            'title'         => $params['title'],
            'category_id'   => 1, // TODO choose category
            'status'        => 'publish',
            'comment_status' => 'open',
            'modified'      => $now
        );
        $result = $this->db->insert($this->table, $data);



        return $result;
    }

    // Logical delete
    public function delete($id)
    {
        if (empty($id)) {
            throw new \Exception('Error: param empty.');
        }
        $data = array(
            'id'             => $id,
            'status'         => 'delete',
            'comment_status' => 'closed',
            'modified'       => date('Y-m-d H:i:s')
        );
        $key = 'id';
        $result = $this->db->update($this->table, $data, $key);

        return $result;
    }

    // Edit: update
    public function update($request, $id)
    {
        $data = array(
            'id'             => $id,
            'content'        => $request['content'],
            'title'          => $request['title'],
            'modified'       => date('Y-m-d H:i:s')
        );
        $key = 'id';
        $result = $this->db->update($this->table, $data, $key);

        return $result;
    }




}