<?php
/*
 * Class for an upcoming episode
 * The prupose of this class is to recalculate the number of episdoes in a season
 * An upcoming episode should not be counted in a show's total
 */
class UpcomingEpisode extends CI_Model{
	
	//attributes from AJAX object
	public $Title, $Released, $Episode, $imdbRating, $imdbID;
	
	public function __construct($object = ''){
		//created from AJAX object
		if($object){
			$this->Title = $object->Title;
			$this->Released = $object->Released;
			$this->Episode = $object->Episode;
			$this->imdbRating = $object->imdbRating;
			$this->imdbID = $object->imdbID;
		}
		
	}
	
	
}