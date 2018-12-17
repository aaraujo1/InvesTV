<?php 
// This page defines an EpisodeFactory class which uses the Factory pattern.

/* The EpisodeFactory class.
 * The class contains no attributes.
 * The class contains one method: create().
 */
abstract class EpisodeFactory {
    
	/*--------------------------------*/
	/*---- FACTORY DESIGN PATTERN ----*/
	/*--------------------------------*/
	
    // Static method that creates objects:
    static function create($episodeObject) {
        
        // Determine the object type based upon the parameters received.
        switch ($episodeObject->Released) {
            case 'N/A':
                return new UpcomingEpisode($episodeObject);
                break;
			default:
                return new Episode($episodeObject);
                break;
        } // End of switch.
         
//		return new Episode($episodeObject);
    } // End of create() method.

} // End of EpisodeFactory class.