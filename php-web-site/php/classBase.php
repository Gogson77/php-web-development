<?php
class Baza{
    private $server="localhost";
    private $username="root";
    private $password="";
    private $database="gordan_kranjcic_newsapp";
    private $db;

    public function connect(){
        $this->db=@mysqli_connect($this->server, $this->username, $this->password, $this->database);
        if(!$this->db)
            return false;
        $this->query("SET NAMES UTF8");
        return $this->db;
    }

    public function query($sql){
        return mysqli_query($this->db, $sql);
    }

    public function num_rows($rez){
        return mysqli_num_rows($rez);
    }

    public function fetch_object($rez){
        return mysqli_fetch_object($rez);
    }

    public function fetch_assoc($rez){
        return mysqli_fetch_assoc($rez);
    }

    public function affected_rows(){
        return mysqli_affected_rows($this->db);
    }
    
    public function insert_id(){
        return mysqli_insert_id($this->db);
    }

    public function error(){
        return mysqli_error($this->db);
    }
}
?>