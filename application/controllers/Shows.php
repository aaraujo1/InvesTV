<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Shows extends MY_Controller {

	/*public function index()
	{
		
		$this->load->view('shows/index2');
	}*/
	
	//add show
	public function add(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//use session for userID
		//CodeIgniter session ID
		//$userid = $_SESSION['user_id'];
		
		
		//singleton instance
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		//add show 
		if ( $showList->addShow( $show ) ) {
			//if function results with a change

			//save to db
			$showList->save();
		}
		
		
	}
	
	//add show to watchingList
	public function addWatching(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//use session for userID
		//CodeIgniter session ID
		//$userid = $_SESSION['user_id'];
		
		//singleton instance
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		
		$showList->addWatching($show);
		
		//save to db
		$showList->save();
		
		
	}
	
	//remove show from watchingList
	public function removeWatching(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//use session for userID
		//CodeIgniter session ID
		//$userid = $_SESSION['user_id'];
		
		//singleton instance
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		//remove show from watching list
		$showList->removeWatching($show);
		
		//save to db
		$showList->save();
		
		
	}
	
	public function listShows($id){		
		//singleton instance
		$showList = ShowList::getInstance($id);
		
		// just return json
		echo json_encode($showList);
	}
	
	//delete show from showList
	public function delete(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		
		//singleton instance
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		//delete show
		$showList->delete($show);
		
		//save to db
		$showList->save();
	}
	
	//maark show as removed from showlist
	public function remove(){
		//get data from post request
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//singleton instance
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		//remove from list
		$showList->removeShow($show);
		
		//save to db
		$showList->save();
		
	}
	
	public function update(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//singleton instance
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		
		//update showList
		$showList->update($show);
		
		//save to db
		$showList->save();
		
	}
	
}
