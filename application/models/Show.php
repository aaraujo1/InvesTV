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
	//public $actors, $awards, $country, $director, $genre, $imdbID, $imdbRating, $imdbVotes, $language, $metascore, $plot, $poster, $rated, $ratings, $released, $response, $runtime, $seasons, $title, $type, $writer, $year;
	
	public $Genre, $imdbID, $imdbRating, $Plot, $Poster, $Released, $Runtime, $Seasons, $Title, $Type, $Year, $totalSeasons;
	
	//created in js
	public $bestEpisode, $episodeListArray, $episodeRatingTotal, $episodeRatings, $ratingsArray, $totalEpisodes, $worstEpisode;
	
	//new properties
	public $currentEpisode, $currentSeason, $totalEpisodesWatched, $flagRemove;

	
	public function __construct($object=""){
		if($object){
			//for everything
			/*foreach($object as $key => $val){
					$this->{lcfirst($key)} = $val;
				}*/
			
			//customising data stored 
//			$this->actors = $object->actors;
//			$this->awards = $object->awards;
//			$this->country = $object->country;
//			$this->director = $object->director;
			$this->Genre = $object->Genre;
			$this->imdbID = (float)$object->imdbID;
			$this->imdbRating = $object->imdbRating;
//			$this->imdbVotes = $object->imdbVotes;
//			$this->language = $object->language;
//			$this->metascore = $object->metascore;
			$this->Plot = $object->Plot;
			$this->Poster = $object->Poster;
//			$this->rated = $object->rated;
//			$this->ratings = $object->ratings;
			$this->Released = $object->Released;
//			$this->response = $object->response;
			$this->Runtime = $object->Runtime;
//			$this->Seasons = $object->Seasons; //use Season object
			$this->Title = $object->Title;
			$this->Type = $object->Type;
//			$this->writer = $object->writer;
			$this->Year = $object->Year;
			
			$this->bestEpisode = $object->bestEpisode;
			$this->episodeListArray = $object->episodeListArray;
			$this->episodeRatingTotal = $object->episodeRatingTotal;
			$this->episodeRatings = $object->episodeRatings;
			$this->ratingsArray = $object->ratingsArray;
			$this->totalEpisodes = $object->totalEpisodes;
			$this->totalSeasons = $object->totalSeasons;
			$this->worstEpisode = $object->worstEpisode;
			
			//if new show...
		if(empty($object->currentEpisode)){
			//these were never set, so set them
			$this->currentEpisode = 0;
			$this->currentSeason = 0;
			$this->totalEpisodesWatched = 0;
			$this->flagRemove = false;
		}else{
			$this->currentEpisode = $object->currentEpisode;
			$this->currentSeason = $object->currentSeason;
			$this->totalEpisodesWatched = $object->totalEpisodesWatched;
			$this->flagRemove = $object->flagRemove;
		}
			
			//array of season
			$this->Seasons = array();
			//loop and create season objects
			foreach($object->Seasons as $seasonObject){
				$season = SeasonFactory::create($seasonObject);
//				$season = new Season($seasonObject);
				array_push($this->Seasons, $season);
			};
			
			//get new season count after factory mwethod
			$this->totalSeasons = $this->getSeasonCount();
			
			
			//$this->Seasons = $object->Seasons;
			
		}
		
		
		
	}
	
	public static function update($key, $value){
		//this should update a show's record
		$this->$key = $value;
		
		
	}
	
	public function getSeasonCount(){
		
		$newSeasonCount = 0;
		
		//make sure it's not empty
		if($this->Seasons){
			//loop through seasons
			foreach($this->Seasons as $s){
				//check class type
				if(get_class($s) === "Season"){
					//make sure only Seasons, and not UpcomingSeasons are being counted
					$newSeasonCount++;
				}
			}
		}
		return $newSeasonCount;
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
	
}