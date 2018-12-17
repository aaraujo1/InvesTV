<?php
/*
 * Class for an upcoming season
 * The prupose of this class is to recalculate the number of seasons in a show
 * An upcoming season should not be counted in a show's total
  *It can also help to determine if a show is returning or completed
 */
class UpcomingSeason extends CI_Model {

	//attributes from AJAX object
	public $Title, $Season, $totalSeasons, $Episodes;

	
	public
	function __construct( $object = '' ) {
		//created from AJAX object
		if ( $object ) {
			$this->Title = $object->Title;
			$this->Season = $object->Season;
			$this->totalSeasons = $object->totalSeasons;
			
			/*--------------------------------*/
			/*---- FACTORY DESIGN PATTERN ----*/
			/*--------------------------------*/
			
			//array of episodes
			$this->Episodes = array();
			//loop and create season objects
			foreach ( $object->Episodes as $episodeObject ) {
				//use factory to create object
				$episode = EpisodeFactory::create( $episodeObject );
				//add object to array
				array_push( $this->Episodes, $episode );
			};
		}
	}

	public
	function getSeasonRating() {

		$seasonRatingTotal = 0;
		if ( $this->episodes ) {

			foreach ( $this->episodes as $e ) {
				$seasonRatingTotal += $e->rating;
			}

		}
		return ( $seasonRatingTotal / $this->numberOfEpisodes );
	}

}