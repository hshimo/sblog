<?php
namespace SblogApp\Model;

class UserModel extends AppModel
{
    public $table = 'users';

    public function getRow($id)
    {
        if (!$id) {
            throw new \Exception('no user id.');
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE login = ? AND status = 1 LIMIT 1';
        $param = array($id);
        $result = $this->db->getRow($sql, $param);

        return $result;
    }
}