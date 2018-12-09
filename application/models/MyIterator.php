<?php

class Calc extends CI_Model implements Iterator {
	
	private $iterationArray;
	
	/*---- ITERATOR DESIGN PATTERN ----*/
	//SOURCE: http://php.net/manual/en/class.iterator.php
	
	//For tracking iterations
	private $position = 0;
	
	
	public function __construct() {
        $this->position = 0;
    }
	
	public function setArray(Array $a){
		$this->iterationArray = a;
	}
	
	public function getArray(){
		return $this->iterationArray;
	}

	//Iterator method: return the position to first postion
    public function rewind() {
        var_dump(__METHOD__);
        $this->position = 0;
    }

	//Iterator method: return current value
    public function current() {
        var_dump(__METHOD__);
        return $this->iterationArray[$this->position];
    }

	//Iterator method: return current key
    public function key() {
        var_dump(__METHOD__);
        return $this->position;
    }

	//Iterator method: increment position
    public function next() {
        var_dump(__METHOD__);
        ++$this->position;
    }

	//Iterator method: return boolean if value is indexed at position
    public function valid() {
        var_dump(__METHOD__);
        return isset($this->iterationArray[$this->position]);
    }
	
}