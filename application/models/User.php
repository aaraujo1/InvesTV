<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Model {
	public $id = 0;
	public $firstname = '';
	public $lastname = '';
	public $username = '';
	public $email = '';
	
	

	public $password = ''; // make sure this database field is varchar(255)
	
	public $showList = [];
		
	public function __construct($username = '')
	{
		// Call the CI_Model constructor
		parent::__construct();
	
		if($username){
			$this->load($username);
		}
	}
	
	public function __toString(){
		return $this->firstname . ' ' . $this->lastname;	
	}
	
	public function load($username = ''){
		// query built using CI's query builder
		$query = $this->db->from('InvestTvUsers')
						->where('username', $username)
						->limit(1)
						->get();
						
		//	make sure query ran successfully
		if ($query->num_rows() === 1) {
			$row = $query->row(); // we only want the first record
			
			// Set all of this classes attributes from database record
			$this->id = $row->id;
			$this->firstname = $row->firstname;
			$this->lastname = $row->lastname;
			$this->email = $row->email;
			$this->username = $row->username;
			$this->password = $row->password;
				
			return true;
		}else{
			// did not find any matching users
			return false;	
		}
	}
	
	// will insert or update record depending if it exists already
	public function save(){
		// get data ready for database
		$data = array('firstname' => $this->firstName,
					'lastname' => $this->lastName,
					'email' => $this->email,
					'username' => $this->username,
					'password' => $this->password);
		
		echo 'saving';
		$this->db->insert('InvesTvUsers', $data);
		echo 'saved';
		// if it has an ID, it already exists, so we will update
//		if($this->id){
//			return $this->db->where('id', $this->id)
//							->update('InvestTvUsers', $data);		
//		// else, it doesn't exist, so create a new one	
//		}else{
//			/*if($this->db->insert('InvestTvUsers', $data)){
//			
//				// since we are creating a new city, we will want to know the ID that was generated
//				$this->id = $this->db->insert_id('id');
//				return true;
//			}*/
//			$this->db->insert('InvestTvUsers', $data);
//			
//		}
//		
//		return false;
//		
	}
	
	public function setPassword($password){
		// store encrypted password
		// http://php.net/manual/en/function.password-hash.php
		$this->password = password_hash($password, PASSWORD_DEFAULT);
	}
	
	public function verifyPassword($password){
		// compare current hashed password with supplied password
		if(password_verify($password, $this->password)){
			// check if the password needs to be re-hashed
			// http://php.net/manual/en/function.password-needs-rehash.php
			if (password_needs_rehash($this->password, PASSWORD_DEFAULT)) {
				 // If so, create a new hash, and replace the old one
				 $this->setPassword($password);
				 $this->save();
			}
			
			// password matches
			return true;
		}
		
		return false;
	}
	
	public static function usernameExists($username){
		$query = static::db()->from('InvestTvUsers')
						->where('username', $username)
						->get();
						
		// return true if a record was returned
		return $query->num_rows() > 0;
	}
	
	public static function emailExists($email){
		$query = static::db()->from('InvestTvUsers')
						->where('email', $email)
						->get();
						
		// return true if a record was returned
		return $query->num_rows() > 0;
	}
	
	
}



/* SAMPLE SQL for user table 


CREATE TABLE IF NOT EXISTS `WorldUsers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


ALTER TABLE `WorldUsers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);


*/