<?php

class Show extends CI_Model{
	public $id, $title, $imdbID, $poster, $episode, $totalEpisodes, $ratingsArray, $object;
	//in json object
	public $plot, $rating, $totalSeasons, $ratingFromSeasons;
	//objects
	//public $seasons;
	public $episodes;
	
	
	
	//$vulns = $data->CVE_Items;
	
	/*if (file_exists($file)) {
    echo "The file $file exists";
	} else {
    echo "The file $file does not exist";
	}
	foreach ($vulns as $vuln) {
    $cveid = $vuln->cve->CVE_data_meta->ID;
    echo $cveid; echo '<br>';
	}*/

	
	public function __construct($showID = ''){
		if(empty($this->title)){
			$this->title = '';
			$this->plot = '';
			$this->poster = '';
			$this->rating = 0.0;
			$this->totalSeasons = 0;
			
			
			
			$this->seasons = array(new Season());
			$this->episodes = array(new Episode());
			
			$this->imdbID = '';
		}
		//if title passed, load it
		if($showID){
			$this->load($showID);
		}
		//$this->load();
		
		if($this->object){
			$this->object = json_decode($this->object);
			$this->plot = $this->object->Plot;
			$this->rating = $this->object->imdbRating;
			$this->totalSeasons = $this->object->totalSeasons;
			$this->ratingFromSeasons = $this->object->episodeRatings;
			$this->ratingsArray = $this->object->ratingsArray;
			
			$this->season = $this->object->Seasons;
		}
		
		
		
	}
	
	//load
	public function load($showID = ''){
//		$file = './lost.json';
//		$json = file_get_contents($file);
//		$data = json_decode($json);
		
		$this->title = $data->Title;
		$this->plot = $data->Plot;
		$this->poster = $data->Poster;
		$this->rating = $data->imdbRating;
		$this->totalSeasons = $data->totalSeasons;
		
		//load all seasons based on totalSeasons
		$this->seasons = array(new Season());
		
		$this->imdbID = $data->imdbID;
		
		$this->object = json_decode($data->object);
	}
	
	public function getShowRating(){
		
		$showRatingTotal = 0;
		if($this->seasons){
			
			foreach($this->seasons as $s){
				$showRatingTotal += $s->getSeasonRating();
			}
			
		}
		return($showRatingTotal / $this->totalSeasons);
	}
	
	//public function save(){
	public function save($id = '', $e = ''){
		// do some validation here
		
		if($this->id){
			// update
			
			//connect
			
			$db = self::db();
			
			// Check connection
			if ($db->connect_error) {
				die("Connection failed: " . $db->connect_error);
			} 
			
			$sql = "UPDATE investv SET episode=? WHERE id=?";
			
			if ($db->query($sql,[$e, $id]) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $db->error;
			}
			
			$db->close();
			
		}else{
			// save
			$data = array(
				'title' => $this->title,
				'imdbID' => $this->imdbID,
				'poster' => $this->poster,
				'episode' => $this->episode,
				'total' => $this->totalEpisodes,
				'object' => json_encode($this->object));
			
			$this->db->insert('investv', $data);
		}
		
	}
	
	public function delete(){
		if($this->id){
			// delete
			$this->db->delete('investv', array('title' => $this->title));
		}
	}
	
	public static function getList(){
		$db = self::db();
		
		$sql = "SELECT * FROM investv";
		
		$query = $db->query($sql);
		$result = $query->custom_result_object('Show');
		
		return $result;
	}
}