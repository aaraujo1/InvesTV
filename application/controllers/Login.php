<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		
		// if there isn't a referrer alrady set
		// add one to session for when login is successful
		if(!isset($_SESSION['referrer'])){
			// check for referrer set in login form
			$referrer = $this->input->post('referrer');
			if($referrer){
				$this->session->set_flashdata('referrer', $referrer);
			}else{
				// default referrer
				$this->session->set_flashdata('referrer', '/');
			}
		}
	}
	
	public function index(){
		$this->view->assign('page_title', 'Login');
		$this->view->display('login/index.tpl');
	}
	
	public function attemptLogin(){
		// get form values
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		// if both values are provided, attempt login
		if($username and $password){
			$this->auth->login($username, $password);
		}
		
		// if login successful, redirect to referer
		// else, show login form again
		if($this->auth->user()){
			if(isset($_SESSION['referrer'])){
				redirect($_SESSION['referrer']);
			}else{
				redirect('/');
			}
		}else{
			$this->view->assign('page_title', 'Login');
			$this->view->assign('error', 'Invalid username or password.');
			$this->view->display('login/index.tpl');
		}
		
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
		
		// validate
		
		// attempt registration
		//$errors = $this->auth->register($firstname, $lastname, $email, $username, $password, $repeatPassword);
		
		// do something if there are errors
		//print_r($errors);
		
		// redirect 
		
	}
	
	
}
