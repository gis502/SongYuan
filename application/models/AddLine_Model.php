<?php 
class AddLine_model extends CI_Model{
	public function __construct()
	{
		$this->load->database();//连接数据库
	}

	public function linePoint(){
		$sql="select * from test where line='12'"; 
		$query=$this->db->query($sql);		
        $result=$query->result_array();
		return $result;
	}
	// public function linePoints(){
	// 	$sql="select * from t10kv_1 "; 
	// 	$query=$this->db->query($sql);		
 //        $result=$query->result_array();
	// 	return $result;
	// }
	// public function linesID(){
	// 	$sql="SELECT DISTINCT line FROM t10kv_1 "; 
	// 	$query=$this->db->query($sql);		
 //        $result=$query->result_array();
	// 	return $result;
	// }
	public function linePoints($table){
		$sql="select * from ".$table; 
		$query=$this->db->query($sql);		
        $result=$query->result_array();
		return $result;
	}
	public function linesID($table){
		$sql="SELECT DISTINCT line FROM ".$table; 
		$query=$this->db->query($sql);		
        $result=$query->result_array();
		return $result;
	}
}
?>