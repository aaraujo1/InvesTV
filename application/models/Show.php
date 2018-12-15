<?php

class Show extends CI_Model{
	
	/*public $id, $title, $imdbID, $poster, $totalEpisodes, $ratingsArray, $object;
	//in json object
	public $plot, $rating, $totalSeasons, $ratingFromSeasons;
	//objects
	//public $seasons;
	public $episodes;*/
	
	
	
	
	//private $object;
	
	//in json object
	//from omdbapi
	public $actors, $awards, $country, $director, $genre, $imdbID, $imdbRating, $imdbVotes, $language, $metascore, $plot, $poster, $rated, $ratings, $released, $response, $runtime, $seasons, $title, $type, $writer, $year;
	
	//created in js
	public $bestEpisode, $episodeListArray, $episodeRatingTotal, $episodeRatings, $ratingsArray, $totalEpisodes, $totalSeasons, $worstEpisode;
	
	//new properties
	public $currentEpisode, $currentSeason, $totalEpisodesWatched;
	
	public $flagRemove;

	
	public function __construct($object=""){
		if(empty($this->title)){
			$this->title = '';
			$this->plot = '';
			$this->poster = '';
			$this->rating = 0.0;
			$this->totalSeasons = 0;
			$this->currentEpisode = 0;
			$this->currentSeason = 0;
			$this->totalEpisodesWatched = 0;
			
			$this->flagRemove = false;
			$this->flagWatching = false;
			
			
			$this->seasons = array(new Season());
			//$this->episodes = array(new Episode());
			
			$this->imdbID = '';
		}
		//if title passed, load it
	
		
		if($object){
			foreach($object as $key => $val){
					$this->{lcfirst($key)} = $val;
				}
		}
		
		
	}
	
	public static function update($key, $value){
		//this should update a show's record
		$this->$key = $value;
		
		
	}
	
	//load
	public function load($showID = ''){
//		$file = './lost.json';
//		$json = file_get_contents($file);
//		$data = json_decode($json);
		
		$this->title = $data->title;
		$this->plot = $data->Plot;
		$this->poster = $data->Poster;
		$this->imdbRating = $data->imdbRating;
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