<?php 
class Shelter_Moder extends CI_Model{

	public function __construct(){
		$this->load->database();
	}
	public function shelter(){
		$sql="select * from shelter";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	public function hospital(){
		$sql="select * from hospital";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
}