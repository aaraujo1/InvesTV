<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Our base model.
 * This allows us future flexibility of adding 
 * functionality to all of our models without
 * modifying each model.
 */
class MY_Model extends CI_Model{
	
	// get the current database instance from the current controller
	public static function db(){
		return get_instance()->db;	
	}
	
	public static function app(){
		return get_instance();
	}
	
	// allows us to magically call getters for 
	// private/protected attributes
	// when called, the attribute is passed in as $attr
	// http://php.net/manual/en/language.oop5.magic.php
	public function __get($attr){
		$getAttr = "get" . ucfirst($attr);
		
		if(method_exists($this, $attr)){ 
			return $this->$attr(); // calls $obj->attr();
		}else if(method_exists($this, $getAttr)){  
			return $this->$getAttr(); // calls $obj->getAttr();
		}else{
			return parent::__get($attr); // CodeIgnighter's built in code
		}
	}
}