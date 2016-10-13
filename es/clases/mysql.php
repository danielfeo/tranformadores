<?php

class MySQL{
    private $database;
    private $server;
    private $user;
    private $pass;
    private $resultado;
    private $estado;

    public function __construct($conection){
        $this->user = $conection['user'];
        $this->pass = $conection['password'];
        $this->server = $conection['server'];
        $this->database = $conection['database'];
    }

    public function getRows(){
        $rows = array();
        if($this->estado){
            if(mysqli_num_rows($this->resultado) > 0){
                while ($registro = mysqli_fetch_array($this->resultado))
                    array_push($rows, $registro);
                mysqli_free_result ($this->resultado);
                return $rows;
            }else{
                return $this->estado;
            }
        }else{
            return false;
        }
    }

    public function runQuery($query){
        $mysqli = mysqli_connect($this->server, $this->user, $this->pass, $this->database);
        mysqli_set_charset($mysqli, 'utf8');
        if($this->resultado = mysqli_query($mysqli, $query))
        {
            $this->estado = true;
        } else {
            echo mysqli_error($mysqli);
            $this->estado = false;
        }
        
        mysqli_close($mysqli);
        return $this;
    }

    public function runSP($nombre, $valores){        
        $query = 'CALL '.$nombre.' (';
        foreach($valores as &$valor)
            $query.= '´'.$valor.'´,';

        $query = substr($query, 0, (strlen($query)-1)).')';
        return $this->runQuery($query);
    }
}