<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Model {
	
	// static variable to hold the logged in user for this session
	private static $loggedin_user = false;
	
	public function __construct(){
		parent::__construct();
		
		if(isset($_SESSION['auth_username'])){
			static::$loggedin_user = new User($_SESSION['auth_username']);
		}
	}
	
	public function login($username, $password){
		
		$user = new User();
		
		// attempt to load user
		// make sure a user was found
		if(!$user->load($username)){
			return false;
		}
		
		// make sure password matches
		if(!$user->verifyPassword($password)){
			return false;
		}
		
		// user is authenticated
		// store in session
		static::$loggedin_user = $user;
		$_SESSION['auth_username'] = $username;
	}
	
	public function logout(){
		static::$loggedin_user = false;
		unset($_SESSION['auth_username']);
	}
	
	public function register($firstname, $lastname, $email, $username, $password, $password2){
		$errors = array();
		
		// sanitize inputs
		$firstname = trim($firstname);
		$lastname = trim($lastname);
		$email = trim($email);
		$username = trim($username);
		
		// make sure username is unique
		if(strlen($username) < 4){
			$errors[] = "Username needs to be atleast 4 characters.";
		} else if(User::usernameExists($username)){
			$errors[] = "Username already exists.";
		}
		
		// make sure email is unique
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errors[] = "Invalid email address.";
		} else if(User::emailExists($email)){
			$errors[] = "Email already exists.";
		}
		
		// make sure password meets requirements
		if($password !== $password2){
			$errors[] = "Passwords do not match.";
		}
		
		if(strlen($password) < 8){
			$errors[] = "Password must be at least 8 characters ";
		}
		
		if (!preg_match("#[0-9]+#", $password)) {
			$errors[] = "Password must include at least one number.";
		}

		if (!preg_match("#[a-zA-Z]+#", $password)) {
			$errors[] = "Password must include at least one letter.";
		}     

		
		// if no errors, create the user
		if(empty($errors)){
			// create user
			$user = new User();
			$user->firstname = $firstname;
			$user->lastname = $lastname;
			$user->username = $username;
			$user->email = $email;
			$user->setPassword($password);

			// save user
			if($user->save()){
				return true;
			}else{
				$errors[] = "Error saving new user.";
			}
		}
	
		return $errors;
	}
	
	public function user(){
		return static::$loggedin_user;
	}
	
	
}