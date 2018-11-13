<?php

class Season extends CI_Model{
	
	public $showTitle, $season, $totalSeasons, $episodes, $numberOfEpisodes, $seasonRating, $object;
	
	
	public function __construct($season = ''){
		/*if(empty($this->episode)){
			$this->showTitle = '';
			$this->season = '';
			$this->totalSeason = '';
		
			$this->episodes = array(new Episode());
			
			$this->numberOfEpisodes = '';
			
			//$this->episodes = array();
		}
		//if title passed, load it
		if($season){
			$this->load($season);
			
		}*/
		if($this->object){
			$this->object = json_decode($this->object);
		}
		$this->showTitle = 
		$this->episodes = array();
		
		$this->load();
		
	}
	
	public function load($sNumber = ''){
		$file = './lost-season-1.json';
		
		$json = file_get_contents($file);
		$data = json_decode($json);
		
		$this->showTitle = $data->Title;
		$this->season = $data->Season;
		$this->totalSeasons = $data->totalSeasons;
		
		
		$this->numberOfEpisodes = count($data->Episodes);
		
		
		
		for ($i = 1; $i <= $this->numberOfEpisodes; $i++){
			array_push($this->episodes, new Episode($i));
		}
		
		
		
		/*foreach($data->Episodes as $e)
		{
    		if($e->Episode == $eNumber){
        		$this->title = $e->Title;
				$this->released = $e->Released;
				$this->episode = $e->Episode;
				$this->rating = $e->imdbRating;
    		}
		}  
		*/
		
		
		
	}
	
	public function getSeasonRating(){
		
		$seasonRatingTotal = 0;
		if($this->episodes){
			
			foreach($this->episodes as $e){
				$seasonRatingTotal += $e->rating;
			}
			
		}
		return($seasonRatingTotal / $this->numberOfEpisodes);
	}
	
}