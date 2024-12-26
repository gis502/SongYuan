<?php 
class Home_model extends CI_Model{
	public function __construct()
	{
		$this->load->database();//连接数据库
	}

	public function News(){
		$sql="select * from news";
		$query=$this->db->query($sql);		
        $result=$query->result_array();
		return $result;
	}
	public function Detail($id){
		$sql="select * from news where id=$id";
		$query=$this->db->query($sql);	
        $result=$query->result_array();
		return $result;
			var_dump($result);
	}
}