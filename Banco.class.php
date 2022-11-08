<?php
    
class Banco{
    private $host;
    private $usuario;
    private $senha;
    private $banco;

    private $dbh;  
    private $error;
    private $stmt;

  
    public function __construct($arDadosBanco ){
        

        $this->host = $arDadosBanco['db_host'];
        $this->usuario = $arDadosBanco['db_user'];
        $this->senha = $arDadosBanco['db_pass'];
        $this->banco = $arDadosBanco['db_nome'];

        //set DNS
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->banco;


        //opcoes
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

        );

        try{
            $this->dbh = new PDO($dsn, $this->usuario, $this->senha, $options);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
        }

       
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {  
              switch (true) {  
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



    public function fetchAll(){
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function execute(){
        return $this->stmt->execute();
    }
    public function lastError(){
        return $this->stmt->errorInfo();
    }
  
    public function beginTransaction(){  
      return $this->dbh->beginTransaction();  
    }  
  
    public function endTransaction(){  
      return $this->dbh->commit();  
    }  
  
    public function cancelTransaction(){  
      return $this->dbh->rollBack();  
    }  
  
    public function lastInsertId(){  
      return $this->dbh->lastInsertId();  
    }  

}

?>
