<?php

module('dao/CrudDao');

class MysqlDao implements CrudDao {
    
    private static $shared = null;
    
    private $table;
    private $entityClass;
    private $conn;
    
    function __construct($table, $entityClass = 'stdClass') {
        self::init();
        $this->table = self::$shared['prefix'] . $table;
        $this->entityClass = $entityClass;
        $this->conn = self::$shared['conn'];
    }
    
    function read($id) {
        $query = "select * from {$this->table} where id = $id";
        $res = $this->conn->query($query);
        
        if ($res === false || $res->num_rows < 1) {
            return false;
        }
        
        $res = $this->objectsArray($res);
        return $res[0];
    }
    
    function save($entity) {
        $a = (array) $entity;
        $names = implode(',', array_keys($a));
        $values = implode('","', array_values($a));
        $query = sprintf('replace into %s (%s) values ("%s")', $this->table, $names, $values);
        $res = $this->conn->query($query);
        if ($res === false) {
            return false;
        }
        if (isset($entity->id) && $entity->id !== null) {
            return $entity->id;
        }
        return $this->conn->insert_id;
    }
    
    function delete($id) {
        $query = "delete from {$this->table} where id = $id";
        return $this->conn->query($query);
    }
    
    function findIds($cond = null, $limit = null, $offset = null) {
        $query = "select id from {$this->table}";
        $query .= $this->clauses($cond, $limit, $offset);
        $res = $this->conn->query($query);
        
        return $this->singleFieldArray($res);
    }
    
    function find($cond = null, $limit = null, $offset = null) {
        $query = "select * from {$this->table}";
        $query .= $this->clauses($cond, $limit, $offset);
        $res = $this->conn->query($query);
        
        return $this->objectsArray($res);
    }
    
    function findFirst($cond = null) {
        $res = $this->find($cond, 1);
        if ($res === false || sizeof($res) < 1) {
            return false;
        }
        return $res[0];
    }
    
    private function clauses($cond, $limit, $offset) {
        if ($cond !== null) {
            $query = " where $cond";
        } else {
            $query = "";
        }
        if ($offset !== null) {
            $query .= " limit $offset, $limit";
        } else if ($limit !== null) {
            $query .= " limit $limit";
        }
        return $query;
    }
    
    protected function objectsArray($res) {
        if ($res === false) {
            return false;
        }
        
        $a = array();
        while (true) {
            $o = $res->fetch_object($this->entityClass);
            if ($o === null) {
                break;
            }
            array_push($a, $o);
        }
        
        return $a;
    }
    
    protected function singleFieldArray($res) {
        if ($res === false) {
            return false;
        }
        
        $f = array();
        while (true) {
            $row = $res->fetch_row();
            if ($row === null) {
                break;
            }
            array_push($f, $row[0]);
        }
        
        return $f;
    }
    
    protected static function init() {
        if (self::$shared !== null) {
            return;
        }
        
        global $ctx;
        $elems = $ctx->elems;
        $conn = new mysqli(
            "{$elems->conf->mysql['host']}:{$elems->conf->mysql['port']}",
            $elems->conf->mysql['username'],
            $elems->conf->mysql['password']);
        
        if ($conn->connect_error) {
            $elems->addError('Mysql connection error');
            return;
        }
        
        $conn->set_charset('utf8');
        
        $res = $conn->select_db($elems->conf->mysql['db']);
        
        if ($res === false) {
            $elems->addError('Mysql database error');
            return;
        }
        
        self::$shared = array('conn' => $conn, 'prefix' => $elems->conf->mysql['prefix']);
    }
    
    static function onModuleDestroy() {
        if (self::$shared === null) {
            return;
        }
        self::$shared['conn']->close();
        self::$shared = null;
    }
    
}

?>
