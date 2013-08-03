<?php

class ProtoContext {

    function __get($name) {
        $methodName = 'get' . ucfirst($name);
        if (!method_exists($this, $methodName)) {
            throw new Exception("No property '$name' in Context!");
        }
        $res = $this->$methodName();
        if (is_object($res)) {
            $res->ctx = $this;
        }
        $this->$name = $res;
        return $res;
    }
    
    protected function getElems() {
        return Elems::$elems;
    }
    
    protected function getUtil() {
        module('sys/Util');
        return new Util();
    }

}

?>

