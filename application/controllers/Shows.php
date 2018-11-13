<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shows extends MY_Controller {

	
	/*public function index()
	{
		$this->load->view('shows/index2');
	}*/
	
	
	public function index()
	{
		
		//build an array to pass to our view
		
		
		//load model
		
		/*$this->load->model('Episode');
		$this->load->model('Season');
		$this->load->model('Show');*/
		
		
		$show = new Show();
		
		
		/*$this->load->view('template/header');
		$this->load->view('shows/index', $show);
		$this->load->view('template/footer');*/
		
		$this->load->view('shows/index2', $show);
	}
	
	public function detail($showID)
	{
		
		//build an array to pass to our view
		
		
		//load model
		
		/*$this->load->model('Episode');
		$this->load->model('Season');
		$this->load->model('Show');*/
		
		
		$show = new Show($showID);
		
		
		/*$this->load->view('template/header');
		$this->load->view('shows/index', $show);
		$this->load->view('template/footer');*/
		
		$this->load->view('shows/index2', $show);
	}
	
	
	public function add(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//use session for userID
		//CodeIgniter session ID
		//$userid = $_SESSION['user_id'];
		
		// show is now a standard PHP object
		//print_r($show);
		//echo '<script>alert("added");</script>';
		//die();
		
		// ******************
		// DO VALIDATION HERE
		// ******************
		
		// add to database using model
		$myShowList = new MyShowList();
		
		// set individual properties
		$myShowList->title = $showObject->Title;
		$myShowList->imdbID = $showObject->imdbID;
		$myShowList->poster = $showObject->Poster;
		$myShowList->episode = 0;
		$myShowList->totalEpisodes = $showObject->totalEpisodes;
		//add to table to store username
		//$pokemon->username = $_SESSION['username'];
		
		// or just store the whole object as json
		$myShowList->object = $showObject;
		
		$myShowList->save();
		
	}
	
	public function list(){
		$object = MyShowList::getList();
		
		// just return json
		echo json_encode($object);
	}
	
	/*public function edit($id){
		// This does not confirm. Yours should confirm.
		$myShowList = new MyShowList();
		$myShowList->load($id);
		$myShowList->delete();
	}*/
	
	public function remove($id){
		// This does not confirm. Yours should confirm.
		$myShowList = new MyShowList();
		$myShowList->load($id);
		$myShowList->delete();
	}
	
	/*public function update(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//use session for userID
		//CodeIgniter session ID
		//$userid = $_SESSION['user_id'];
		
		// show is now a standard PHP object
		//print_r($show);
		//echo '<script>alert("added");</script>';
		//die();
		
		// ******************
		// DO VALIDATION HERE
		// ******************
		
		// add to database using model
		$myShowList = new MyShowList();
		
		// set individual properties
		$myShowList->title = $showObject->title;
		$myShowList->imdbID = $showObject->imdbID;
		$myShowList->poster = $showObject->poster;
		$myShowList->episode = $showObject->episode;
		$myShowList->totalEpisodes = $showObject->totalEpisodes;
		//add to table to store username
		//$pokemon->username = $_SESSION['username'];
		
		// or just store the whole object as json
		$myShowList->object = $showObject;
		
		$myShowList->save($this->id, $this->episode);
		
	}*/
	
}
