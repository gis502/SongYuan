<?php 
class MoreIntensity_Model extends CI_Model{
	public function __construct()
	{
		$this->load->database();//连接数据库
	}
	public function getIntensity($IntensityValue){
		
		if($IntensityValue == 6){
			$sql = "SELECT BuildName,BuildLat,BuildLng,SixClass FROM bulidsituation";
		}elseif($IntensityValue == 7){
			$sql = "SELECT BuildName,BuildLat,BuildLng,SevenClass FROM bulidsituation";
		}elseif($IntensityValue == 8){
			$sql = "SELECT BuildName,BuildLat,BuildLng,EightClass FROM bulidsituation";
		}elseif($IntensityValue == 9){
			$sql = "SELECT BuildName,BuildLat,BuildLng,NineClass FROM bulidsituation";
		}elseif ($IntensityValue == 10) {
			$sql = "SELECT BuildName,BuildLat,BuildLng,TenClass FROM bulidsituation";
		}
		
		$result = $this->db->query($sql);
		//var_dump($result);
		return $result->result_array();
	}

}