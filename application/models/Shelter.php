<?php 
class Shelter extends CI_Model{

	public function __construct(){
		$this->load->database();
	}
	public function shelter(){
		$sql="select * from shelter";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
}