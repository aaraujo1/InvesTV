<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Shows extends MY_Controller {

	public function index()
	{
		
		//build an array to pass to our view
		
		
		//load model
		
		/*$this->load->model('Episode');
		$this->load->model('Season');
		$this->load->model('Show');*/
		
		
		
		
		
		/*$this->load->view('template/header');
		$this->load->view('shows/index', $show);
		$this->load->view('template/footer');*/
		
		$this->load->view('shows/index2');
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
		/*$myShowList = new MyShowList();
		
		// set individual properties
		$myShowList->title = $showObject->Title;
		$myShowList->imdbID = $showObject->imdbID;
		$myShowList->poster = $showObject->Poster;
		$myShowList->episode = 0;
		$myShowList->totalEpisodes = $showObject->totalEpisodes;
		//add to table to store username
		//$pokemon->username = $_SESSION['username'];
		
		// or just store the whole object as json
		$myShowList->object = $showObject;*/
		
		//showList object
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		//convert json object to show object
		/*foreach($showObject as $key => $val){
			$show->{lcfirst($key)} = $val;
		}*/
					
		//add show object to showlist array
		//array_push($showList->showList, $show);
		
		//if adding show to showList returns true
		/*if($showList->addShow($show)){
		
			//save to db
			$showList->save();
		}*/
		
		if ( $showList->addShow( $show ) ) {
			//if function results with a change

			//save to db
			$showList->save();
		}
		
		
	}
	
	public function addWatching(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//use session for userID
		//CodeIgniter session ID
		//$userid = $_SESSION['user_id'];
		
		//showList object
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		
		$showList->addWatching($show);
		
		//save to db
		$showList->save();
		
		
	}
	
	public function removeWatching(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		//use session for userID
		//CodeIgniter session ID
		//$userid = $_SESSION['user_id'];
		
		//showList object
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		
		$showList->removeWatching($show);
		
		//save to db
		$showList->save();
		
		
	}
	
	public function listShows(){
//		$object = MyShowList::getList();
		//$object = ShowList::getList();
		
		$showList = ShowList::getInstance(1);
		
		
		// just return json
		echo json_encode($showList);
	}
	
	public function delete(){
		// if using angularJS $http post, use something like
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		
		// This does not confirm. Yours should confirm.
		$showList = ShowList::getInstance(1);
		
		//new show object
		$show = new Show($showObject);
		
		//delete show
		$showList->delete($show);
		
		//save to db
		$showList->save();
	}
	
	public function remove(){
		// This does not confirm. Yours should confirm.
		
		
		//$showList->load($id);
		
		$requestData = file_get_contents('php://input');
		$showObject = json_decode($requestData)->showData;
		
		$showList = ShowList::getInstance(1);
		
		$showList->removeShow($showObject);
		
		//save to db
		$showList->save();
		
	}
	
	public function update(){
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
		
		//showList object
		$showList = ShowList::getInstance(1);
		
		//find object in array
		/*foreach($showList->showList as $show){
			//match title
			if ($show->title === $showObject->title){
				//replace current episode with new one
				$show->currentEpisode = $showObject->currentEpisode;
			}
		}*/
		
		
		//$showList->showList = $showObject;
		
		
		// set individual properties
		/*$myShowList->title = $showObject->title;
		$myShowList->imdbID = $showObject->imdbID;
		$myShowList->poster = $showObject->poster;
		$myShowList->episode = $showObject->episode;
		$myShowList->totalEpisodes = $showObject->totalEpisodes;
		//add to table to store username
		//$pokemon->username = $_SESSION['username'];
		
		// or just store the whole object as json
		$myShowList->object = $showObject;*/
		
		/*$myShowList->load($showObject->id);
		
		$myShowList->save($showObject->id, $showObject->episode);*/
		
		//save to db
		$showList->update($showObject);
		
		//save to db
		$showList->save();
		
	}
	
}
