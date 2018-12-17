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
		
		/*---- For Show List ----*/
		
		$this->load->model('Episode');
		$this->load->model('UpcomingEpisode');
		
		$this->load->model('Season');
		$this->load->model('UpcomingSeason');
		
		$this->load->model('Show');
		$this->load->model('MyShowList');
		//$this->load->model('ShowList');
		
		//cannost use $this->load->model with singletons
		include_once(APPPATH.'models/ShowList.php');
		
		//cannost use $this->load->model with abstract classes
		include_once(APPPATH.'models/SeasonFactory.php');
		include_once(APPPATH.'models/EpisodeFactory.php');
		
		//cannost use $this->load->model with interface
		include_once(APPPATH.'interfaces/iSort.php');
		//$this->load->model('TitleSortStrategy');
		include_once(APPPATH.'models/TitleSortStrategy.php');
		include_once(APPPATH.'models/RatingSortStrategy.php');
		
		
		//sessions??
		//https://www.codeigniter.com/user_guide/libraries/loader.html
		//$this->load->driver('session');
		
		/*---- For Users ----*/
		$this->load->model('Auth');
		$this->load->model('User');

		
	}
}