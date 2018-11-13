<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	
	public function index()
	{
		
		//build an array to pass to our view
		
		
		//load model
		/*
		$this->load->model('Episode');
		$this->load->model('Season');
		$this->load->model('Show');
		
		
		$show = new Show();*/
		//use our models like we did in our test pages
		//$data['usa'] = new Country('USA');
		
		//call method
		//$data['countries'] = Country::allCountries();
		
		//load view
		//$this->load->view('countries/index', $data);
		
		/*$this->load->view('template/header');
		$this->load->view('shows/index', $show);
		$this->load->view('template/footer');*/
		
		$this->load->view('shows/index2');
	}
	
	
	/*public function index()
	{
		
		//build an array to pass to our view
		
		
		//load model
		$this->load->model('Episode');
		
		//$episode = new Episode();
		//use our models like we did in our test pages
		//$data['usa'] = new Country('USA');
		
		//call method
		//$data['countries'] = Country::allCountries();
		
		//load view
		//$this->load->view('countries/index', $data);
		
		$this->load->view('template/header');
		$this->load->view('episodes/index');
	}*/
}
