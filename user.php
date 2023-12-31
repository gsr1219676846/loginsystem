<?php
/*
user.php
- Defines the User class, primarily used for handling database operations related to user data.
- Key functionalities:
  1. Establishes a connection to the MySQL database using provided credentials.
  2. Contains methods for retrieving (`getRows`) and inserting (`insert`) data in the 'users' table.
  3. The `getRows` method allows fetching user data based on specified conditions like select, where, order by, limit, etc., and can return data in various formats (all, count, single).
  4. The `insert` method is used to add new user data into the database. It automatically sets created and modified timestamps and supports insertion of different data types.
  5. Error handling is implemented in database connection and query execution to ensure robustness.
- This class is central to the user management aspect of the extension, facilitating the storage, retrieval, and manipulation of user information within the database.
*/
?>




<?php
/*
 * User Class
 * This class is used for database related (connect, fetch, and insert) operations
 *
 */
class User{
    private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "usbw";
    private $dbName     = "steven_db";
    private $userTbl    = "users";
 
    public function __construct(){
        if(!isset($this->db)){
            //Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
 
    /*
     * Returns rows from the database based on the conditions

     */
    public function getRows($conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$this->userTbl;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
 
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by'];
        }
 
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit'];
        }
 
        $result = $this->db->query($sql);
 
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                default:
                    $data = '';
            }
        }else{
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
            }
        }
        return !empty($data)?$data:false;
    }
 
    /*
     * Insert data into the database

     */
    public function insert($data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            if(!array_key_exists('created',$data)){
                $data['created'] = date("Y-m-d H:i:s");
            }
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $columns .= $pre.$key;
                $values  .= $pre."'".$val."'";
                $i++;
            }
            $query = "INSERT INTO ".$this->userTbl." (".$columns.") VALUES (".$values.")";
            $insert = $this->db->query($query);
            return $insert?$this->db->insert_id:false;
        }else{
            return false;
        }
    }
}