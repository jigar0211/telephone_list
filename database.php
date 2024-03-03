<?php
define('HOSTNAME', 'localhost');
define('DATABASE', 'teleplone_list');
define('USERNAME', 'root');
define('PASSWORD', '');
error_reporting(E_ALL);
error_reporting(E_ERROR);
class Database
{
    private $conn;
    function __construct()
    {
        $dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DATABASE . ";";
        $db_user = USERNAME;
        $db_password = PASSWORD;
        try {
            $this->conn = new PDO($dsn, $db_user, $db_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function Insert($tablename, $values = array())
    {
        $sql = "INSERT INTO {$tablename} (`" . implode("`, `", array_keys($values)) . "`) VALUES (:" . implode(", :", array_keys($values)) . ")";
        $int_qry = $this->conn->prepare($sql);

        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($values)
            ),
            $values
        );

        if ($int_qry->execute($array)) {
            return true;
        } else {
            return false;
        }
    }

    public function Update($tablename, $values, $where)
    {
        $sql = "UPDATE {$tablename} SET ";

        $keys = array_keys($values);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}`=:{$key}";
        }
        $sql .= implode(", ", $sql_parts);
        $sql .= " WHERE ";
        $keys = array_keys($where);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}`=:{$key}";
        }
        $sql .= implode(" AND ", $sql_parts);

        $int_qry = $this->conn->prepare($sql);

        $mix_array = array_merge($values, $where);

        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($mix_array)
            ),
            $mix_array
        );

        if ($int_qry->execute($array)) {
            return true;
        } else {
            return false;
        }
    }

    public function Delete($tablename, $where)
    {
        $sql = "DELETE FROM {$tablename}";

        $sql .= " WHERE ";
        $keys = array_keys($where);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}`=:{$key}";
        }
        $sql .= implode(" AND ", $sql_parts);

        $int_qry = $this->conn->prepare($sql);
        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($where)
            ),
            $where
        );


        if ($int_qry->execute($array)) {
            return true;
        } else {
            return false;
        }
    }

    public function prepareWhere($where, $cond_type = "AND", $cond = "=")
    {
        $sql = '';
        $keys = array_keys($where);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}` {$cond} :{$key}";
        }
        $sql = implode(" {$cond_type} ", $sql_parts);

        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($where)
            ),
            $where
        );
        return [$sql, $array];
    }

    public function list($tablename, $where = null, $cond_type = "AND", $start = 0, $limit = 10)
    {
        $sql = "SELECT * FROM {$tablename}";
        $array = [];
        if (!is_null($where) && is_array($where)) {
            $sql .= " WHERE ";
            foreach ($where as $key => $cond) {
                $sql_parts[] = $cond[0];
                $array = array_merge($array, $cond[1]);
            }
            $sql .= implode(" {$cond_type} ", $sql_parts);
        }
        $sql .= " LIMIT {$start}, {$limit}";

        $int_qry = $this->conn->prepare($sql);
        $int_qry->execute($array);

        $data['rows'] = $int_qry->fetchAll(PDO::FETCH_OBJ);

        $count_sql = "SELECT COUNT(*) as count FROM {$tablename}";
        if (!empty($where)) {
            $count_sql .= " WHERE ";
            $count_sql .= implode(" {$cond_type} ", $sql_parts);
        }
        $count_qry = $this->conn->prepare($count_sql);
        $count_qry->execute($array);

        $data['total'] = $count_qry->fetch(PDO::FETCH_OBJ)->count;

        return $data;
    }

    public function GET($tablename, $where)
    {

        $sql = "SELECT * FROM {$tablename}";
        $sql .= " WHERE ";
        $keys = array_keys($where);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}`=:{$key}";
        }
        $sql .= implode(" AND ", $sql_parts);

        $int_qry = $this->conn->prepare($sql);
        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($where)
            ),
            $where
        );

        $int_qry->execute($array);

        return $int_qry->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetch($tablename, $id)
    {
        $sql = "SELECT * FROM {$tablename} WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function val($table, $column, $value)
    {
        $query = "SELECT * FROM $table WHERE $column = :value";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
