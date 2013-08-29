<?php
/**
 *
 *
 * // query() sample
 * $stmt = $this->db->query($sql, $param);
 * $result = $stmt->fetch(\PDO::FETCH_ASSOC);
 *
 */

namespace SblogApp\Model;

class CommentModel extends AppModel
{
    private $table = 'comments';

    public function insertComment($params)
    {
        if (empty($params)) {
            throw new \Exception('Error: param empty.');
        }

        if (empty($params['user_id'])) $params['user_id'] = 0;
        $data = array(
            'post_id'       => $params['post_id'],
            'author'        => $params['name'],
            'author_email'  => $params['email'],
            'date'          => date('Y-m-d H:i:s'),
            'content'       => $params['comment'],
            'parent'        => 0,
            'user_id'       => $params['user_id']
        );
        $result = $this->db->insert($this->table, $data);

        return $result;
    }


    public function getAll($id)
    {
        if (empty($id)) {
            throw new \Exception('Error: no id.');
        }
        $limit = 10; // TODO
        $sql = "SELECT * FROM " . $this->table . " WHERE post_id = ? LIMIT 10";
        $param = array($id);
        $result = $this->db->getAll($sql, $param);

        return $result;
    }



}