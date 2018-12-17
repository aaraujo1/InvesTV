<?php 
// This page implements the Strategy pattern.

// The Sort interface defines the sort() method:
interface iSort {
    function sortArray(array $list);
}