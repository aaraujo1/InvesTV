<?php

class Season extends CI_Model{
	
	public $Title, $Season, $totalSeasons, $Episodes;
	
	public $seasonRatingAverage;
	
	
	public function __construct($object = ''){
		
		if($object){
			$this->Title = $object->Title;
			$this->Season = $object->Season;
			$this->totalSeasons = $object->totalSeasons;
			
			/*--------------------------------*/
			/*---- FACTORY DESIGN PATTERN ----*/
			/*--------------------------------*/
			
			//array of episodes
			$this->Episodes = array();
			//loop and create season objects
			foreach($object->Episodes as $episodeObject){
				$episode = EpisodeFactory::create($episodeObject);
//				$episode = new Episode($episodeObject);
				array_push($this->Episodes, $episode);
			};
			
			$this->seasonRatingAverage = $this->getSeasonRating();
		}
		
		//if(empty($this->seasonRatingAverage
		
		
	}
	
	
	public function getSeasonRating(){
		
		$seasonRatingTotal = 0;
		
		if($this->Episodes){
			//loop through episodes
			foreach($this->Episodes as $e){
				//check is class is Episode or Upcoming Episode
				if(get_class($e) === "Episode"){
					$seasonRatingTotal += $e->imdbRating;
				}
			}
			return($seasonRatingTotal / count($this->Episodes));
		}
		
		return 0;
		
	}
	
}