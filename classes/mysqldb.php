<?PHP

class MySqlDB {

    //private $Servername ,$Username ,$Password ,$DBname ,$conn;
    private $conn;
    protected $error = array();
    protected $log = array();

    function __construct() {
        $this->connectDb();
        $this->conn->set_charset("utf8");
    }

    private function connectDb() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            $this->SetError(__METHOD__, $this->conn->connect_error);
        } else {
            $this->SetLog(__METHOD__, "Conected: " . DB_NAME);
        }
    }

    public function insert($table, $arr = array()) {

        $conn = $this->conn;

        $c = NULL;
        $sql = "INSERT INTO " . $table . "(";
        foreach ($arr as $k => $v) {
            $c .= ", " . $k;
        }
        $sql .= substr($c, 2) . ") VALUES (";
        $c = NULL;
        foreach ($arr as $v) {
            $c .= ", '" . $v . "'";
        }
        $sql .= substr($c, 2) . ")";
        if ($conn->query($sql) === TRUE) {
            $this->SetLog(__METHOD__, "New record created successfully");
            return $conn->insert_id;
        } else {
            $this->SetError(__METHOD__, $conn->error);
            echo $conn->error;
        }
    }

// END function Insert

    public function select($table, $arr = array(), $order = "id", $desc = false) {
        $conn = $this->conn;
        $out = array();
        $sql = "SELECT * FROM " . $table;
        if (count($arr)) {
            $sql .= " WHERE ";
        }
        $c = null;
        foreach ($arr as $k => $v) {
            $c .= " AND `" . $k . "` = '" . $v . "'";
        }
        $sql .= substr($c, 5);
        $sql .= " ORDER BY " . $order;
        if ($desc === true) {
            $sql .= " DESC";
        }
        $out = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $finfo = $result->fetch_fields();

            while ($row = $result->fetch_assoc()) {

                $out[] = $row;
            }
        } else {
            $this->SetLog(__METHOD__, "0 results");
        }
        return $out;
    }

// END function Select

    public function delete($table, $arr = array()) {
        $conn = $this->conn;
        $sql = "DELETE FROM $table";
        if (count($arr)) {
            $sql .= " WHERE ";
        }
        foreach ($arr as $k => $v) {
            $c .= " AND " . $k . " = '" . $v . "'";
        }
        $sql .= substr($c, 5);
        
        if ($conn->query($sql) === TRUE) {
            $this->SetLog(__METHOD__, "Record deleted successfully");
            return true;
        } else {

            $this->SetError(__METHOD__, $conn->error);
        }
    }

// END function Delete

    public function query($sql) {
        $conn = $this->conn;
        $out = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $finfo = $result->fetch_fields();
            while ($row = $result->fetch_assoc()) {
                $out[] = $row;
            }
        } else {
            $this->SetLog(__METHOD__, "0 results");
        }
        return $out;
    }

    public function updata($table, $arr1 = array(), $arr2 = array()) {

        $conn = $this->conn;
        $sql = "UPDATE " . $table . " SET ";
        $c = "";
        foreach ($arr1 as $k => $v) {
            $c .= " , `" . $k . "` = '" . $v . "'";
        }
        $sql .= substr($c, 3);
        $sql .= " WHERE ";
        $c = "";
        foreach ($arr2 as $k => $v) {
            $c .= " AND `" . $k . "` = '" . $v . "'";
        }
        $sql .= substr($c, 5);
//        echo $sql;
        if ($conn->query($sql) === TRUE) {
            $this->SetLog(__METHOD__, "Record updated successfully");
        } else {
            $this->SetError(__METHOD__, $conn->error);
        }
    }

// END function Update

    private function setLog($met, $log) {
        $date = date("d-m-Y H:i:s");
        $log[$date] = $met . ":" . $log;
    }

    private function setError($met, $err) {
        $date = date("d-m-Y H:i:s");
        $error[$date] = $met . ":" . $err;
    }

    function __destruct() {
        $conn = $this->conn->close();
    }
    
//END function __destruct
}

// class MySqlDB
?>