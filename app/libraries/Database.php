<?php
  /*
   * PDO Database Class
   * Connect to database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */
  class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $port = DB_PORT;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
      // Set DSN
      
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname .';port=' . $this->port;
      // $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname .';port=3307';
      $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      // Create PDO instance
      try{
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
      } catch(PDOException $e){
        $this->error = $e->getMessage();
        //echo $this->error;
        file_put_contents("DBError.txt",$this->error);
      }
    }

    // Prepare statement with query
    public function query($sql){
      $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null){
      if(is_null($type)){
        switch(true){
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default:
            $type = PDO::PARAM_STR;
        }
      }

      $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute(){
      return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // Get result set as array of assoc
    public function resultSetAssoc(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get result set as array of fetch
    public function resultSetFetch(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get single record as object
    public function singleObj(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get single record as Array
    public function single(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get row count
    public function rowCount(){
      return $this->stmt->rowCount();
    }
    // Get last ID insert
    public function lastinsertedId(){
      return $this->dbh->lastInsertId();
    }
    
    // Insert
    public function insertQuery($table,$data){
      $i=0;
      $set = implode(',', array_keys($data));
      $setValues =  implode(",:",array_keys($data));
      $insert = "INSERT INTO ".$table." (".$set.") VALUES (:".$setValues.")";
      $this->query($insert);
      foreach($data as $item => $value){
        $this->bind($item,$value); 
      }
      if($this->execute()){
        return true;
      }else{
        return false;
      }
      
    }
    
    public function updateQuery($table,$data,$where){
      $set = implode(',', array_keys($data));
      $setValues =  implode(",:",array_keys($data));
      $i=1;
      $total = count($data);
      $makeUpdate = '';
      foreach(array_keys($data) as $item){
        if($i==$total){
          $makeUpdate .= $item."=:".$item;
        }else{
          $makeUpdate .= $item."=:".$item.",";
        }
        $i++;
      }
      $update = "UPDATE ".$table." SET ".$makeUpdate." WHERE ".$where;
      $this->query($update);
      
      foreach($data as $item => $value){
        $this->bind($item,$value);
        
      }
      //$this->bind($where,$whereVal);
      if($this->execute()){
        return true;
      }else{
        return false;
      }
      
    }
  }