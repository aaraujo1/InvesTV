<?php
/*
 *This class implents iSort
 * It is part of the Strategy Pattern
 * It is meant to sort the ShowList alphabetically
 */

// The MultiAlphaSort sorts a multidimensional array alphabetically.
// SOURCE: PHP Advanced and Object-Oriented Programming: Visual QuickPro Guide (3rd Edition) (Visual QuickPro Guides)
class TitleSortStrategy implements iSort {
    
    // How to sort:
    private $_order;
    
    // Sort index:
    private $_index;
    
    // Constructor sets the sort index and order:
    function __construct($index, $order) {
        $this->_index = $index;
        $this->_order = $order;
    }
    
    // Function does the actual sorting:
    function sortArray(array $list) {

        // Change the algorithm to match the sort preference:
		//SOURCE: http://php.net/manual/en/function.uasort.php
		//SOURCE: http://php.net/manual/en/function.usort.php
        if ($this->_order == 'ascending') {
            usort($list, array($this, 'ascSort'));
        } else {
            usort($list, array($this, 'descSort'));
        }

        // Return the sorted list:
        return $list;
    
    }// End of sort() method.

    // Functions that compares two values:
    public function ascSort($x, $y) {
        return strcmp($x->{$this->_index}, $y->{$this->_index});		
    }
    function descSort($x, $y) {
        return strcmp($y->{$this->_index}, $x->{$this->_index});                
    }
	
} // End of TitleSortStrategy class.
