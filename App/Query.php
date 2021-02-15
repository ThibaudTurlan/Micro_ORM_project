<?php

namespace App;

use App\ConnectionFactory;


/**
 * Class Query
 * @package App
 */
class Query
{
    /**
     * @var
     */
    private $sqltable;
    private $fields = '*';
    private $where = null;
    private $args = []; //condition
    private $sql = '';

    private $pdo;


    /**
     * @param $table
     * @return Query
     */
    static function table($table)
    {
        $query = new Query;
        $query->sqltable = $table;
        
        $pdo = ConnectionFactory::getConnection();
        $create = $pdo->prepare("CREATE TABLE IF NOT EXISTS `$table` (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, test INT)");
        $create->execute();

        var_dump("je rentre dans querry");
        
        return $query;
    }

    /**
     * @param $col
     * @param $operator
     * @param $val
     * @return string|null
     */
    public function where($col = null, $operator = null, $val = null, $params = null)
    {
        if ($this->where == null) {
            $this->where = "WHERE " . $col . " " . $operator . " " . $val;
        } elseif ($params){
            $this->where = "WHERE $params";
        } else {
            $this->where = $this->where . "AND " . $col . " " . $operator . " " . $val;
        }

        $this->args[] = $val;
        // return $this;
        var_dump($this->where);
        return $this->where;
    }

    /**
     * @param array|null $fields
     * @return array
     */
    public function get(array $fields = null)
    {
        if ($fields){
            $this->fields = implode(',', $fields);
            $this->sql = "SELECT $this->fields FROM $this->sqltable $this->where";
        } else {
            $this->sql = "SELECT $this->fields FROM $this->sqltable $this->where";
        }

        $pdo = ConnectionFactory::getConnection();
        $stmt = $pdo->prepare($this->sql);
        $stmt->execute();
        

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array|null $fields
     * @return array
     */
    public function select(array $fields = null)
    {
        $this->fields = implode(',', $fields);

        return $this->get($fields);
        // return $this;
    }


    /**
     * @param array $args
     * @return string
     */
    public function insert(array $args = null, array $fields = null, $table = null)
    {
        if($fields){
            $values = "'" . implode("','", $args) . "'";
            $fields = "`" . implode("`,`", $fields) . "`";
            var_dump($values);
            var_dump($fields);
            $this->sql = "INSERT INTO $table ($fields) VALUES ($values)";
            // $this->sql = "INSERT INTO `article` (`titre`, `descr`) VALUES (1, 'abcd')";
            var_dump($this->sql);
        } else {       
            // FIXME la fonction insert fois l'éllément 
            $values = implode(', ', $args);
            $this->sql = "INSERT INTO $this->sqltable VALUES($values)";
            var_dump($this->sql);
        }   

        $pdo = ConnectionFactory::getConnection();
        $req = $pdo->prepare($this->sql);
        $req->execute();

        return $pdo->lastInsertId();
    }

    /**
     * @param array|null $args
     * @return bool
     */
    public function delete($args = null)
    {
        $col = $args[0];
        $operator = $args[1];
        $fields = $args[2];
        var_dump("delete enter");

        $this->where($col, $operator, $fields);
        $this->sql = "DELETE FROM $this->sqltable $this->where";
        var_dump($this->sql);
        $pdo = ConnectionFactory::getConnection();
        $req = $pdo->prepare($this->sql);
        $req->execute();

        if(!$req){
            die("erreur impossible de delete");
        } 

        return true;
    }
    

    // public function where(array $conditionArray){
    //     $args = "";
    //     for($i=0; $i < count($conditionArray); $i++){
    //         $args .= $conditionArray[$i][0] . " " . $conditionArray[$i][1] . " " . $conditionArray[$i][2];

    //         if($i != count($conditionArray) - 1){
    //             if(isset($conditionArray[$i][3])){
    //                 $args .= " " . $conditionArray[$i][3] . " ";
    //             } else {
    //                 $conditionArray .= " AND ";
    //             }
    //         }
    //     }

    //     $this->args = $args;
    //     return $this;
    // }

}
