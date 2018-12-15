<?php

class MyShowList extends MY_Model{
	public $id, $title, $imdbID, $poster, $episode, $totalEpisodes, $object;
	
	/*public $id, $showList;*/
	
	public function __construct(){
		if($this->object){
			// if this object is json from database, convert to object
			$this->object = json_decode($this->object);
		}
		
		/*if(empty($this->showList)){
			$this->id = '';
			$this->showList = array(new Show());
		}*/
		
		//if title passed, load it
		/*if($id){
			$this->load($id);
		}*/
	}
	
	public function __toString(){
		return $this->title;	
	}
	
	public function load($id){
		$row = $this->db->get_where('investv0', array('id' => $id))->row();
		$this->id = $row->id;
		$this->title = $row->title;
		$this->imdbID = $row->imdbID;
		$this->poster = $row->poster;
		$this->episode = $row->episode;
		$this->totalEpisodes = $row->totalEpisodes;
		$this->object = json_decode($row->object);
		//$this->object = $row->object;
	}
	
	
	//public function save(){
	public function save($id = '', $e = ''){
		// do some validation here
		
		if($this->id){
			// update
			//connect
			$db = self::db();
			
			// Check connection
			/*if ($db->connect_error) {
				die("Connection failed: " . $db->connect_error);
			} */
			
			$sql = "UPDATE investv0 SET episode=? WHERE id=?";
			
			if ($db->query($sql,[$e, $id]) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $db->error;
			}
			
			
			
			/*if ($db->query($sql,[$e, $id]) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $db->error;
			}*/
			
			/*$sql = "UPDATE investv SET episode=2 WHERE id=8";
			$db->query($sql);*/
			
			
			//$db->close();
		}else{
			// save
			$data = array(
				'title' => $this->title,
				'imdbID' => $this->imdbID,
				'poster' => $this->poster,
				'episode' => $this->episode,
				'totalEpisodes' => $this->totalEpisodes,
				'object' => json_encode($this->object));
			
			$this->db->insert('investv0', $data);
		}
		
	}
	
	public function delete(){
		if($this->id){
			// delete
			$this->db->delete('investv0', array('id' => $this->id));
		}
	}
	
	public static function getList(){
		$db = self::db();
		
		$sql = "SELECT * FROM investv0";
		
		$query = $db->query($sql);
		$result = $query->custom_result_object('Show');
		
		return $result;
	}
}