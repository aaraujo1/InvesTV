<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		
		// if there isn't a referrer alrady set
		// add one to session for when login is successful
//		if(!isset($_SESSION['referrer'])){
//			// check for referrer set in login form
//			$referrer = $this->input->post('referrer');
//			if($referrer){
//				$this->session->set_flashdata('referrer', $referrer);
//			}else{
//				// default referrer
//				$this->session->set_flashdata('referrer', '/');
//			}
//		}
	}
	
	/*public function index(){
		$this->view->assign('page_title', 'Login');
		$this->view->display('login/index.tpl');
	}*/
	
	public function attemptLogin(){
		
		$requestData = file_get_contents('php://input');
		$requestObject = json_decode($requestData);
		
		
		
		//$this->load->model('User');
		
		//$user = new User($requestObject->username);
		
		/*$user->firstname = $requestObject->firstName;
		$user->lastname = $requestObject->lastName;
		$user->email = $requestObject->email;*/
		//$user->username = $requestObject->username;
		//$user->password = $requestObject->password;
		
		return $requestObject;
		
	}
	
	public function logout(){
		$this->auth->logout();
		
		redirect('/');
	}
	
	public function newUserForm(){
		// show new user form
		
	}
	
	public function registerNewUser(){
		// get form values
		$requestData = file_get_contents('php://input');
		$userObject = json_decode($requestData);
		// validate
		
		// add to database using model
		$user = new User();
		
		// set individual properties
		$user->firstName = $userObject->firstName;
		$user->lastName = $userObject->lastName;
		$user->email = $userObject->email;
		$user->username = $userObject->username;
		$user->password = $userObject->password;
		$user->repeat_password = $userObject->repeat_password;
		
		$user->save();
		
		// attempt registration
		//$errors = $this->auth->register($firstname, $lastname, $email, $username, $password, $repeatPassword);
		
		// do something if there are errors
		//print_r($errors);
		
		// redirect 
		
	}
	
	//a garbage function for me to get user information 
	public function getUser(){
		// get form values
		/*$requestData = file_get_contents('php://input');
		$userObject = json_decode($requestData);*/
		
		$user = new User('aaraujo1');
		
		echo json_encode($user);
	}
	
	
}
