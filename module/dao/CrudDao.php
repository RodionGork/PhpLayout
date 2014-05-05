<?php

namespace module\dao;

interface CrudDao {

    function read($id);
    
    function save($entity);
    
    function delete($id);
    
    function findIds($cond = null, $limit = null, $offset = null);
    
    function find($cond = null, $limit = null, $offset = null);
    
    function makeLookup($key = 'id', $cond = null);
    
    function findFirst($cond = null);
    
    function getCount($cond = null);
    
    function lastError();
}
