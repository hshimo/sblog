<?php
/**
 * Very lightweight wrapper around PDO
*
* This expects configuration keys in the Slim application object:
*
*    dsn              DSN for PDO connection. Use @ as a placeholder for
*                     dbname (i.e., "mysql:host=localhost;dbname=@")
*    db_user          username for DB access (if needed)
*    db_password      password for DB access (if needed)
*    pdo_fetch_style  optional return style for PDO records. Default is
*                     PDO::FETCH_OBJ.
*/
//namespace Slimx;
namespace Sblog\Lib;

class DB
{
    private $pdo;
    // fetch mode: FETCH_ASSOC,FETCH_NUM,FETCH_BOTH,FETCH_OBJ
    //private $pdoFetchStyle = \PDO::FETCH_OBJ;
    private $pdoFetchStyle = \PDO::FETCH_ASSOC;

    /**
     * Constructor. This sets up the PDO object.
     *
     * @param object $app Slim application object
     * @param string $dbname database name to connect to (optional)
     */
    public function __construct($config, $dbname=null)
    {
        if ($this->pdo) {
            return $this->pdo;
        }

        //if ($dbname) {
        //    $dsn = str_replace('@', $dbname, $dsn);
        //}
        if (isset($config['pdo_fetch_style'])) {
            $this->pdoFetchStyle = $config['pdo_fetch_style'];
        }
        try {
            $pdo_options = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
            $this->pdo = new \PDO(
                $config['dsn'],
                $config['db_user'],
                $config['db_password'],
                $pdo_options
            );

        } catch (\PDOException $e) {
            print 'PDO connection error: ' . $e->getMessage();
            //if(isset($pdo->errorInfo())) print_r($pdo->errorInfo());
            die();
        }
    }

    /**
     * Return the PDO object, for direct manipulation if necessary
     *
     * @return PDO object
     */
    public function pdo()
    {
        return $this->pdo;
    }

    /**
     * Execute an SQL query. Generally used for updates/inserts, as the
     * read/readSet methods below are more convenient for results; it
     * returns a PDOStatement object.
     *
     * @param string $query
     * @param mixed $params Parameter array or single string
     * @return PDOStatement object
     */
    public function query($query, $params=null)
    {
        if ($params && !is_array($params)) $params = array($params);
        $sth = $this->pdo->prepare($query);
        $sth->execute($params);
        return $sth;
    }

    /**
     * Return a single-record result from an SQL query. This will always
     * return a string for a single-column result; otherwise it will return
     * an array or object based on pdoFetchStyle.
     *
     * @param string $query
     * @param mixed $params Parameter array or single string
     * @return mixed|array returned records (or false)
     */
    public function getRow($query, $params=null)
    {
        $sth = $this->query($query, $params);
        if (!$sth) return false;
        if ($sth->columnCount() > 1) {
            return $sth->fetch($this->pdoFetchStyle);
        }
        return $sth->fetchColumn();
    }

    /**
     * Return a multiple-record result from an SQL query. This will always
     * return an array for a single-column result; otherwise it will return
     * a value based on pdoFetchStyle.
     *
     * @param string $query
     * @param mixed $params Parameter array or single string
     * @return object|array returned records (or false)
     */
    //public function readSet($query, $params=null)
    public function getAll($query, $params=null)
    {
        $sth = $this->query($query, $params);
        if (!$sth) return false;
        if ($sth->columnCount() > 1) {
            return $sth->fetchAll($this->pdoFetchStyle);
        }
        return $sth->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Return a hash (associative array) from an SQL query that returns two
     * columns -- the first column will be the key, and the second will be the
     * value. Throws a LengthException if the column count returned is not 2.
     *
     * @param string $query
     * @param mixed $params Parameter array or single string
     * @return array returned records (or false)
     * @throws LengthException
     */
    public function readHash($query, $params=null)
    {
        $sth = $this->query($query, $params);
        if (!$sth) return false;
        if ($sth->columnCount() != 2) {
            throw new \LengthException('DB::readHash() expects 2 columns returned from query');
        }
        return $sth->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    /**
     * Save a record to a table. This will call insert() or update() as appropriate.
     *
     * @param string $table table name
     * @param array|object $data column names and values
     * @param string $key column name of primary key (default "id")
     * @return PDOStatement object
     */
    public function save($table, $data, $key='id')
    {
        $data = (array)$data;
        if (!isset($data[$key])) {
            throw \InvalidArgumentException("DB::save() called with data missing primary key ($key)");
        }
        if ($this->read("SELECT $key FROM $table WHERE $key = ?", array($data[$key]))) {
            $this->update($table, $data, $key);
        }
        else {
            $this->insert($table, $data);
        }
    }

    /**
     * Insert a record into a table
     *
     * @param string $table table name
     * @param array|object $data column names and values
     * @return PDOStatement object
     */
    public function insert($table, $data)
    {
        $data = (array)$data;
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->query($query, array_values($data));
    }

    /**
     * Update a record in a table
     *
     * @param string $table table name
     * @param array|object $data column names and values
     * @param string $key column name of primary key (default "id")
     * @return PDOStatement object
     */
    public function update($table, $data, $key='id')
    {
        $data = (array)$data;
        if (!isset($data[$key])) {
            throw \InvalidArgumentException("DB::update() called with data missing primary key ($key)");
        }
        $set = array();
        foreach (array_keys($data) as $col) {
            $set[] = "$col = ?";
        }
        $setq = implode(', ', $set);
        $query = "UPDATE $table SET $setq WHERE $key = ?";
        $params = array_values($data);
        $params[] = $data[$key];
        return $this->query($query, $params);
    }

    /**
     * Delete a record in a table
     *
     * @param string $table table name
     * @param mixed $id key value to delete
     * @param string $key column name of primary key (default "id")
     * @return PDOStatement object
     */
    public function delete($table, $id, $key='id')
    {
        $query = "DELETE FROM $table WHERE $key = ?";
        return $this->query($query, $id);
    }

    /**
     * Read one or more records from a table
     *
     * This returns all columns in one or more rows. It can be called in one
     * of two ways:
     *
     *    $db->get('mytable', 2, 'id');
     *    $db->get('mytable', 'id >= 100 AND id <= 200');
     *
     * In the first form, the third parameter defaults to 'id', so the above
     * could simply be:
     *
     *    $db->get('mytable', 2);
     *
     * Note that the first form *only* works with key values that are numeric;
     * if the second parameter is a string, it is assumed to be a condition.
     * Conditions are passed directly to SQL, without parameter escaping; if
     * you need escaping, use the query() function.
     *
     * @param string $table table name
     * @param mixed $where key value or WHERE clause
     * @param string $key column name of primary key (default "id")
     * @return PDOStatement object
     */
    public function get($table, $where, $key='id')
    {
        $query = "SELECT * FROM $table WHERE ";
        if (is_string($where)) {
            $query .= $where;
            $params = null;
            return $this->readSet($query);
        }
        $query .= "$key = ?";
        return $this->read($query, $where);
    }
}