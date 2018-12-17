<?php 
// This page defines an SeasonFactory class which uses the Factory pattern.

/* The SeasonFactory class.
 * The class contains no attributes.
 * The class contains one method: create().
 */
abstract class SeasonFactory {
	
	/*--------------------------------*/
	/*---- FACTORY DESIGN PATTERN ----*/
	/*--------------------------------*/
    
    // Static method that creates objects:
    static function create($seasonObject) {
        
        // Determine the object type based upon the parameters received.
        switch ($seasonObject->Episodes[0]->Released) {
            case 'N/A':
                return new UpcomingSeason($seasonObject);
                break;
			default:
                return new Season($seasonObject);
                break;
		
        } // End of switch.
         
//		return new Season($seasonObject);
    } // End of create() method.

} // End of SeasonFactory class.