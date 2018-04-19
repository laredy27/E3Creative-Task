<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Birthday_Model{
    
    /**
     * @var string Table name
     */
    private $table_name = "birthday";
    
    /**
     * @var string Select query return type, array or object
     */
    private $return_type = "array";
    
    /**
     * @var resource MySqli Connection
     */
    private $conn;
    
    function __construct( $db = array() ) {
        if( empty($db) ){
            throw new InvalidArgumentException( "Models require an array of database credentials", "401" );
        }
        extract( $db );
        $this->return_type = $return_as;
        $conn = new mysqli($host, $username, $password, $dbname, $port);
        if($conn->connect_errno){
            throw new mysqli_sql_exception( );
        }
        $this->conn = $conn;
        // Create the table
        $this->create_table();  
    }
    
    function __destruct() {
        if(is_object($this->conn) ){
            $this->conn->close(); //Free db connection
        }
    }
    
    private function create_table(){
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} ( "
                . "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,"
                . "birthday_date DATE NOT NULL"
                . ")ENGINE = InnoDB";
        $result = $this->conn->query($sql); // Execute table creation, assuming no errors occur
    }
    
    public function insert_birthday( $data ){
        extract($data);
        
        $sql = "INSERT INTO {$this->table_name} (birthday_date) "
                . "VALUES ('{$birthday}')";
        $result = $this->conn->query( $sql );
        return $result;
    }
    
    public function get_all_birthdays(){

        $sql = "SELECT "
                . "COUNT(birthday_date) as count, "
                . "DATE_FORMAT(birthday_date, '%D %M %Y') as formatted_date, "
                . "birthday_date "
             . "FROM {$this->table_name} "
             . "GROUP BY birthday_date "
             . "ORDER BY birthday_date DESC";
             //echo $sql;
        $result = $this->conn->query( $sql );
        $data = array();
        if( $result->num_rows > 0 ){
            while( $row = $result->fetch_assoc() ):
                $data[] = $row;
            endwhile;
            
            if( $this->return_type == "object" ):
                $data = (object) $data;
            endif;
        }
        
        return $data;
    }

}

