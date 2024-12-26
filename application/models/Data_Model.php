<?php 

class Data_Model extends CI_Model{
public function __construct(){
 $this->load->database();//、连接数据库
 $this->load->model('ImportExcel');
}
//查询建筑数据
public function addBuildPoint_M($type){
  if($type=="syjzw"){
  $sql="select * from all_buliding ";//所有建筑物
  }
  elseif ($type=="szyg") {
      $sql="select * from all_buliding";//受灾预估
  }
  elseif ($type=="gyjz") {
      $sql="select * from industry_buliding";//工业建筑
  }
  elseif ($type=="myjz") {
     $sql="select * from civil_bulidling ";//民用建筑
  }
  elseif ($type=="ggjzw") {
      $sql="select * from public_buliding ";//公共建筑物
  } 
  elseif ($type=="gsxtjz") {
      $sql="select * from waterss_buliding ";//供水系统建筑
  }
  elseif ($type=="grxtjz") {
      $sql="select * from heatingss_buliding ";//供热系统建筑
  }
  elseif ($type=="gdxtjz") {
      $sql="select * from electricss_buliding ";//供电系统建筑
  }
  elseif ($type=="bdzmc") {
      $sql="select * from substation_name ";//变电站名称
  }
  elseif ($type=="trqjqz") {
      $sql="select * from naturalgas_station ";//天然气加气站
  }
  elseif ($type=="trqmz") {
      $sql="select * from naturalgasgate_statio ";//天然气门站
  }
  elseif ($type=="cszhy") {
      $sql="select * from secondarydisaster_source ";//次生灾害源
  }
  elseif ($type=="xfjz") {
      $sql="select * from fire_building ";//消防建筑
  }
  elseif ($type=="yhqgyz") {
      $sql="select * from liquefiedgasss ";//液化气供应站
  }
  elseif ($type=="txjz") {
      $sql="select * from communicationbs ";//通信基站缺
  }
  elseif ($type=="qljz") {
      $sql="select * from bridge_buliding ";//通信基站缺
  }
$query=$this->db->query($sql);
$result=$query->result_array();
//var_dump($result);
$data=array();
foreach ($result as $key => $value) {
  $_data=array();
  foreach ($value as $index => $item) {
    if($item==null){
      $item="";
    }
   $_data[$index]=$item;
  }
 
  array_push($data,$_data);
}
 return $data;
}
//数据管理
public function dataManage(){
  $page =   $_GET ['page'];
  $limit = $_GET ['limit'];
  $sql="select * from all_buliding order by ID desc limit ".($page-1)*$limit.','."$limit";//所有建筑物
  // var_dump($sql);
  $this->db->limit(10); 
  $query=$this->db->query($sql);
  $result=$query->result_array();
  $data=array();
foreach ($result as $key => $value) {
  $_data=array();
  foreach ($value as $index => $item) {
    if($item==null){
      $item="";
    }
   $_data[$index]=$item;
  }
 
  array_push($data,$_data);
}
 return $data;
} 
public function getTableLength(){
 $rows = $this->db->count_all('all_buliding');
 return $rows;
}

public function SwitchType($propertyType){
  switch($propertyType){
    case "工业建筑":return "industry_buliding";
    case "民用建筑":return "civil_bulidling";
    case "公共建筑":return "public_buliding";
    case "供水系统":return "waterss_buliding";
    case "供热系统":return "heatingss_buliding";
    case "天然气加气站":return "naturalgas_station";
    case "天然气门站":return "naturalgasgate_statio";
    case "次生灾害源":return "secondarydisaster_source";
    case "消防建筑":return "fire_building";
    case "液化气供应站":;return "liquefiedgasss";
    case "通信基站":return "communicationbs";
    case "桥梁建筑":return "bridge_buliding";
}
}
public function delData($buildingNumber,$propertyType){
  $Dbname=$this->SwitchType($propertyType);
  $sql = "delete from all_buliding where buildingNumber=".'"'.$buildingNumber.'"';
  $query  = $this->db->query($sql);
  $sql = "delete from ".$Dbname." where buildingNumber=".'"'.$buildingNumber.'"';
  $query1  = $this->db->query($sql);
  $query=$query&&$query1;
  return $query;
}
public function dataDelete($ID){
  $sql = "delete from all_buliding where ID=".$ID;
  $query  = $this->db->query($sql);
  return $query;
}
// public function dataUpdate($ID,$field,$value){
//   $value = "'".$value."'";
//   $sql="update all_buliding set ".$field."=".$value." where ID=".$ID;
//   $query  = $this->db->query($sql);
//   return $query;
// }
public function DataUpdata($buildingNumber,$propertyTyp,$field,$value){
  $Dbname=$this->SwitchType($propertyType);
  $value = "'".$value."'";
  $buildingNumber = "'".$buildingNumber."'";
  $sql="update all_buliding set ".$field."=".$value." where buildingNumber=".$buildingNumber;
  $query  = $this->db->query($sql);
  $sql="update ".$Dbname." set ".$field."=".$value." where buildingNumber=".$buildingNumber;
  $query1  = $this->db->query($sql);
  $query=$query&&$query1;
  return $query;
}
//搜索建筑物模糊查询
public function searchBuild_M($information)
{
	
	$sql="select * from all_buliding where buildingName like '%".$information."%'";
	$query=$this->db->query($sql);
	$result=$query->result_array();
	$data=array();
foreach ($result as $key => $value) {
  $_data=array();
  foreach ($value as $index => $item) {
    if($item==null)
      $item="";
   $_data[$index]=$item;
  }
 
  array_push($data,$_data);
}
 return $data;

} 
//精确搜索建筑
public function exactSearchBulid_M($city,$popeOrCounty,$streetOrTown,$ToOrHuOrviOrCo,$buildingNumber,$buildingName){
    $sql1="select * from all_buliding where popeOrCounty='".$popeOrCounty."' and streetOrTown='".$streetOrTown."' and ToOrHuOrviOrCo='".$ToOrHuOrviOrCo."' and (buildingNumber='".$buildingNumber."'or buildingName='".$buildingName."')";
    $query=$this->db->query($sql1);
    //$query = $this->db->last_query(); 这是CI框架用来打印sql的方法
    $result=$query->result_array(); 
    return $result; 

}
//查询街道和乡镇
public function countrySearch_M($information){
$sql="select distinct streetOrTown from all_buliding where popeOrCounty='".$information."'";
$query=$this->db->query($sql);
  $result=$query->result_array();
  $data=array();
foreach ($result as $key => $value) {
  $_data=array();
  foreach ($value as $index => $item) {
    if($item==null)
      $item="";
   $_data[$index]=$item;
  }
 
  array_push($data,$_data);
}
 return $data; 
}
//information是辖区information2是街道
public function streetSearch_M($information,$information2){
$sql="select distinct ToOrHuOrviOrCo  from all_buliding where popeOrCounty='".$information."'and streetOrTown='".$information2."'";
$query=$this->db->query($sql);
  $result=$query->result_array();
  $data=array();
foreach ($result as $key => $value) {
  $_data=array();
  foreach ($value as $index => $item) {
    if($item==null)
      $item="";
   $_data[$index]=$item;
  }
 
  array_push($data,$_data);
}
 return $data; 
}
/*public function insertData_C(){

  $sql="select * from test";
  $query=$this->db->query($sql);
  $result=$query->result_array();
 // return $result;
  foreach($result as $key=>$row){
     $y=$row['baidu_Y'];
     $x=$row['baidu_X'];
     $id=$row['ID'];
    $sql="update bridge set baidu_X='".$x."',baidu_Y='".$y."' where ID='".$id."'";
    // $sql="insert into bridge(baidu_X,baidu_Y) value ('".$x."','".$y."')";
    $this->db->query($sql);
  }
}*/
  public function historyMod(){
    $sql="select * from history where MAG >= 6 order by EQTTIME";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    $res = [[
      'date' => array_column($result,'EQTTIME'),
      'magnitude' => array_column($result,'MAG'),
      'depth' => array_column($result,'DEPTH')],$result];
    return $res; 
  }
  //将数据插到基本表中
  public function insertToTable($type,$data){
    //baidu_X,Y为空时，经纬度转换百度XY
    if($data[3]==null || $data[4]==null){
      $coords="$data[1],$data[2]";
      $data1=$this->ImportExcel->convert($coords);
      $sql="INSERT INTO all_buliding (buildingNumber,X,Y,baidu_X,baidu_Y,propertyType,buildingName,nameOfHous,admiPosition,height,floor,floorArea,constructionAge,structureTypeOne,structureTypeTwo,earthquakeFortification,siteType,foundationType,baseType,exteriorAndInterior,underDisadvantage,scatAndNotWhole,britWithoutDelay,partAndUneven,simpButNotRedu,remarks,statusEvaluation,sixDegrEarthDam,sevenDegrEarthDam,eightDegrEarthDam,nineDegrEarthDam,tenDegrEarthDam,predictOutcomes,popeOrCounty,city,streetOrTown,ToOrHuOrviOrCo,no)VALUES('$data[0]','$data[1]','$data[2]','$data1[baidu_X]','$data1[baidu_Y]','$type','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]','$data[21]','$data[22]','$data[23]','$data[24]','$data[25]','$data[26]','$data[27]','$data[28]','$data[29]','$data[30]','$data[31]','$data[32]','$data[33]','$data[34]','$data[35]','$data[36]','$data[37]')";
    }else{
      $sql="INSERT INTO all_buliding (buildingNumber,X,Y,baidu_X,baidu_Y,propertyType,buildingName,nameOfHous,admiPosition,height,floor,floorArea,constructionAge,structureTypeOne,structureTypeTwo,earthquakeFortification,siteType,foundationType,baseType,exteriorAndInterior,underDisadvantage,scatAndNotWhole,britWithoutDelay,partAndUneven,simpButNotRedu,remarks,statusEvaluation,sixDegrEarthDam,sevenDegrEarthDam,eightDegrEarthDam,nineDegrEarthDam,tenDegrEarthDam,predictOutcomes,popeOrCounty,city,streetOrTown,ToOrHuOrviOrCo,no)VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$type','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]','$data[21]','$data[22]','$data[23]','$data[24]','$data[25]','$data[26]','$data[27]','$data[28]','$data[29]','$data[30]','$data[31]','$data[32]','$data[33]','$data[34]','$data[35]','$data[36]','$data[37]')";
    }
    $this->db->query($sql);
  }
  //根据建筑类别插入到具体的建筑表
  public function insertBuildingTable($table,$type,$data){
    if($data[3]==null || $data[4]==null){
      $coords="$data[1],$data[2]";
      $data1=$this->ImportExcel->convert($coords);
      $sql="INSERT INTO $table (buildingNumber,X,Y,baidu_X,baidu_Y,propertyType,buildingName,nameOfHous,admiPosition,height,floor,floorArea,constructionAge,structureTypeOne,structureTypeTwo,earthquakeFortification,siteType,foundationType,baseType,exteriorAndInterior,underDisadvantage,scatAndNotWhole,britWithoutDelay,partAndUneven,simpButNotRedu,remarks,statusEvaluation,sixDegrEarthDam,sevenDegrEarthDam,eightDegrEarthDam,nineDegrEarthDam,tenDegrEarthDam,predictOutcomes,popeOrCounty,city,streetOrTown,ToOrHuOrviOrCo,no)VALUES('$data[0]','$data[1]','$data[2]','$data1[baidu_X]','$data1[baidu_Y]','$type','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]','$data[21]','$data[22]','$data[23]','$data[24]','$data[25]','$data[26]','$data[27]','$data[28]','$data[29]','$data[30]','$data[31]','$data[32]','$data[33]','$data[34]','$data[35]','$data[36]','$data[37]')";
    }else{
      $sql="INSERT INTO $table (buildingNumber,X,Y,baidu_X,baidu_Y,propertyType,buildingName,nameOfHous,admiPosition,height,floor,floorArea,constructionAge,structureTypeOne,structureTypeTwo,earthquakeFortification,siteType,foundationType,baseType,exteriorAndInterior,underDisadvantage,scatAndNotWhole,britWithoutDelay,partAndUneven,simpButNotRedu,remarks,statusEvaluation,sixDegrEarthDam,sevenDegrEarthDam,eightDegrEarthDam,nineDegrEarthDam,tenDegrEarthDam,predictOutcomes,popeOrCounty,city,streetOrTown,ToOrHuOrviOrCo,no)VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$type','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]','$data[19]','$data[20]','$data[21]','$data[22]','$data[23]','$data[24]','$data[25]','$data[26]','$data[27]','$data[28]','$data[29]','$data[30]','$data[31]','$data[32]','$data[33]','$data[34]','$data[35]','$data[36]','$data[37]')";
    }
    if(isset($sql)){
      $this->db->query($sql);
    }   
  }
}
