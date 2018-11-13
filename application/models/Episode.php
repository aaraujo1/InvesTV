<?php

class Episode extends CI_Model{
	
	public $showTitle, $season, $title, $released, $episode, $rating;
	
	public $episodes;
	
	public function __construct($episode = ''){
		if(empty($this->episode)){
			//$this->showTitle = '';
			//$this->season = '';
			$this->title = '';
			$this->released = '';
			$this->episode = 0;
			$this->rating = 0.0;
		
			//$this->episodes = (object)[""];
			
			//$this->episodes = array();
		}
		//if title passed, load it
		if($episode){
			$this->load($episode);
		}
		
	}
	
	public function load($eNumber = ''){
		$file = './lost-season-1.json';
		
		$json = file_get_contents($file);
		$data = json_decode($json);
		
		//$this->showTitle = $data->Title;
		//$this->season = $data->Season;
		
		//$this->episodes = $data->Episodes;
		
		
		foreach($data->Episodes as $e)
		{
    		if($e->Episode == $eNumber){
        		$this->title = $e->Title;
				$this->released = $e->Released;
				$this->episode = $e->Episode;
				$this->rating = $e->imdbRating;
    		}
		}
		
		
		
		
	}
}