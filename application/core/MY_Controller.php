<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Our base controller.
 * This allows us future flexibility of adding 
 * functionality to all of our models without
 * modifying each model.
 */
class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->model('MyShowList');
		$this->load->model('Episode');
		$this->load->model('Season');
		$this->load->model('Show');
	}
}