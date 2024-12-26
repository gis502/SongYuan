<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data extends CI_Controller{

public function __construct(){
    parent::__construct();
    $this->load->model('Data_Model');
    $this->load->model('ImportExcel');
}
//导入数据
public function EdataAdd(){
  $inputFileName = $_FILES["file"]["name"];
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br/>";
    return 0;
  }
else
  {
    
    $inputFileName  = iconv('utf-8', 'gb2312', $inputFileName);
    move_uploaded_file($_FILES["file"]["tmp_name"], "" . $inputFileName);
    $inputFileName=iconv("gb2312","UTF-8", $inputFileName);
    include 'public/phpE/PHPExcel.php';
    date_default_timezone_set('PRC');
    // 读取excel文件
    try {
    rename(iconv('UTF-8','GBK',$inputFileName), iconv('UTF-8','GBK',"aa.xlsx"));      
    $inputFileName = "aa.xlsx";
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
    } catch(Exception $e) {
    die('加载文件发生错误："'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }
    //return $this->ImportExcel->EdataAdd_M($objPHPExcel);  
    $result= $this->ImportExcel->EdataAdd_m($objPHPExcel);
    echo json_encode($result);
  }

}
//添加建筑
public function addBuildPoint_C(){
$type1=$_POST['type'];//建筑物类型
$data['item']=$this->Data_Model->addBuildPoint_M($type1);
//var_dump($data['item']);
//echo "8888888".$type1;
echo  json_encode($data['item'],JSON_UNESCAPED_UNICODE);

}
//数据管理
public function dataManage(){
  $data['item']=$this->Data_Model->dataManage();
  $count = $this->Data_Model->getTableLength();
	$raw = array('code' => 0, 'msg' => '','count' => $count,'data' => $data['item']);

	$json_data = json_encode($raw);

  echo  $json_data;
}
//删除数据(表格)
public function delData(){
  $buildingNumber=$_POST['buildingNumber'];
  $propertyType=$_POST['propertyType'];
  $result = $this->Data_Model->delData($buildingNumber,$propertyType);
  return $result;
}
//删除数据
public function dataDelete(){
  $ID=$_POST['ID'];
  $result = $this->Data_Model->dataDelete($ID);
  return $result;
}
 //更新数据(表格)
public function DataUpdata(){
  $buildingNumber=$_POST['buildingNumber'];
  $propertyType=$_POST['propertyType'];
  $field=$_POST['field'];
  $value=$_POST['value'];
  $result = $this->Data_Model->DataUpdata($buildingNumber,$propertyType,$field,$value);
  return $result;
}
//更新数据
// public function dataUpdate(){
//   $ID=$_POST['ID'];
//   $field=$_POST['field'];
//   $value=$_POST['value'];
//   $result = $this->Data_Model->dataUpdate($ID,$field,$value);
//   return $result;
// }
//模糊查询
public function search_C(){

 header("Content-type:text/html;charset=utf-8");
  $information=$_POST['name'];
  $data['item']=$this->Data_Model->searchBuild_M($information);
  echo  json_encode($data['item'],JSON_UNESCAPED_UNICODE);

}
//根据区县查询街道乡镇
public function countrySearch_C(){

 header("Content-type:text/html;charset=utf-8");
  $information=$_POST['county'];
  $data['item']=$this->Data_Model->countrySearch_M($information);
  echo  json_encode($data['item'],JSON_UNESCAPED_UNICODE);

}
//根据区县街道乡镇查询小区
public function streetSearch_C(){
 $information=$_POST['county'];
  $information2=$_POST['street'];
   $data['item']=$this->Data_Model->streetSearch_M($information,$information2);
  echo  json_encode($data['item'],JSON_UNESCAPED_UNICODE);

}
   //截图
    public function screenshot(){
        define('UPLOAD_DIRA', 'public/screen_images/A/');//定义变量
        define('UPLOAD_DIRB', 'public/screen_images/B/');//定义变量
        define('UPLOAD_DIRC', 'public/screen_images/C/');//定义变量
        define('UPLOAD_DIRD', 'public/screen_images/D/');//定义变量
        define('UPLOAD_DIRE', 'public/screen_images/E/');//定义变量

        $img = $_POST['img'];
        $name = $_POST['shuxin'];//从前台获取的截图类型

        date_default_timezone_set('PRC');

        $addtime=date("YmdHi",time()); //获得当前时间 命名图片名称

        $base_img=str_replace('data:image/jpg;base64,', '', $img);
        // //设置文件路径和文件前缀名称
        // $path='public/images/autoExport/synthesisImg/simpleexport/';
        // $prefix='simpleexport_';

        $data = base64_decode($base_img);

       
    if ($name=='A') {
             $file = UPLOAD_DIRA .$addtime. '.jpg';//烈度图唯一名字
          }elseif ($name=='B') {
            $file = UPLOAD_DIRB .$addtime. '.jpg';//加点建筑物分布唯一名字
          }elseif($name=='C'){
          $file = UPLOAD_DIRC .$addtime. '.jpg';//饼状图唯一名字
          }elseif($name=='D'){
          $file = UPLOAD_DIRD .$addtime. '.jpg';//柱状图唯一名字
          }else{
            $file = UPLOAD_DIRE .$addtime. '.jpg';//手动截图
          }
        $ifp=fopen($file,"wb");
        fwrite($ifp,$data);

        fclose($ifp);


        echo json_encode($file);

    }
    //建筑物精确查询
    public function exact_search_C(){
     $city=$_POST['city'];
     $popeOrCounty=$_POST['popeOrCounty'];
     $streetOrTown=$_POST['streetOrTown'];
     $ToOrHuOrviOrCo=$_POST['ToOrHuOrviOrCo'];
     $buildingNumber=$_POST['buildingNumber'];
     $buildingName=$_POST['buildingName'];
     $data['item']=$this->Data_Model->exactSearchBulid_M($city,$popeOrCounty,$streetOrTown,$ToOrHuOrviOrCo,$buildingNumber,$buildingName);
     echo  json_encode($data['item'],JSON_UNESCAPED_UNICODE);

    } 
    /*
    这个方法是是给前台传不同损坏下的相应图片路径，现在分为5种
    得到图片信息，传入要获取的图片类型
      返回对应的文件
    */
     public function getImages($info){
      define('UPLOAD_DIR', 'public/images/situationPicture/');//定义变量D:/wamp/www/newsy/
       //$info= 'untouched';
      $images= array();
          if ($info=='untouched') {//良好
               // $dir='D:/wamp/www/newsy/public/images/situationPicture/untouched/';
             $dir=UPLOAD_DIR .'untouched/';
              
               $images=readIMG($dir,$info);
          }
          else if ($info=="slightDamage") {//轻微破坏
           $dir=UPLOAD_DIR.'slightDamage/';
               $images=readIMG($dir,$info);
          }
          else if ($info=="moderateDamage") {//中等破坏
           $dir=UPLOAD_DIR.'moderateDamage/';
               $images=readIMG($dir,$info);
          }
          else if ($info=="seriousDamage") {//严重破坏
           $dir=UPLOAD_DIR.'seriousDamage/';
               $images=readIMG($dir,$info);
          }
          else if ($info=="collapsed") {//毁坏
           $dir=UPLOAD_DIR.'collapsed/';
               $images=readIMG($dir,$info);
          }else if($info=="buildingPictures"){
            $dir = "public/images/situationPicture/buildingPictures/";
            $images =readIMG($dir,$info);
          }
          else { //良好
            $dir=UPLOAD_DIR.'untouched/';
            $info=untouched;
               $images=readFile($dir,$info);
          }
       echo  json_encode($images,JSON_UNESCAPED_UNICODE);
    }
    public function historyCon(){
      header("Content-type:text/html;charset=utf-8");
      $data['item']=$this->Data_Model->historyMod();
      echo  json_encode($data['item'],JSON_UNESCAPED_UNICODE);
    }
  /*删除图片
  wz修改*/
  public function saveIMG(){
        $fd= $_POST["param1"];
        foreach ($fd as $key => $value) {
          if(file_exists($value)){//存在该文件
            if(unlink($value)){
              echo "Success";
            }
            else{
              echo "Failed";
            }
          }
        }
    }
    public function ajaxSaveIMG($imgType){
      define('UPLOAD_DIR', 'public/images/situationPicture/');//定义变量
      if (isset($_POST['upload'])) {
        // $getFile=$_POST['upfile'];
      if ($imgType=='untouched') {
          $upload_path=UPLOAD_DIR .'untouched/';
      }
      elseif($imgType=='slightDamage'){
          $upload_path=UPLOAD_DIR .'slightDamage/';
      }
      elseif($imgType=='moderateDamage'){
          $upload_path=UPLOAD_DIR .'moderateDamage/';
      }
      elseif($imgType=='seriousDamage'){
         $upload_path=UPLOAD_DIR .'seriousDamage/';
      }
      elseif($imgType=='collapsed'){
          $upload_path=UPLOAD_DIR .'collapsed/';
      }
      else{ $upload_path=UPLOAD_DIR .'untouched/';}
      //$upload_path='D:/wamp/www/baidu/image/';
     // var_dump($_FILES['upfile']['tmp_name']);
      //var_dump('up_tmp/'.time());
      //var_dump($_POST['upload'])
      //var_dump($_FILES);
        $file = $_FILES['upfile'];
        $name = $file['name'];
        $type = strtolower(substr($name,strrpos($name,'.')+1)); 
      if(move_uploaded_file($file['tmp_name'], $upload_path.time().'.'.$type)){
        echo "Success!";
      }
      else{
          echo "Failed!";
        }//$_FILES['upfile']['tmp_name']
      //header('location: test.php');
     // echo 'true';
      }
      // echo "false";
    }

    public function ajaxSavePicture($buildingNumber){
      define('UPLOAD_DIR', 'public/images/situationPicture/buildingPictures/');//定义变量
      $file = $_FILES['uploadPicture'];
      $name = $file['name'];    
      $type = strtolower(substr($name,strrpos($name,'.')+1)); 
      if(isset($_POST['uploadPicture'])){
        $filestr = $this->readPicture();
        $files = explode(',', $filestr);
        //如果已存在该建筑照片 则删除原来的
        for($i=0;$i<count($files);$i++){
          $files_ext = substr($files[$i], strrpos($files[$i], '.'));
          if(strcmp(basename($files[$i],$files_ext),$buildingNumber)==0){
            unlink("public/images/situationPicture/buildingPictures/".$files[$i]);
          }
        }
        if(move_uploaded_file($file['tmp_name'],UPLOAD_DIR.$buildingNumber.'.'.$type)){
           echo "Success";
        }else{
          echo "Failed";
        }
      }
   }

   public function readPicture(){
      $dir="public/images/situationPicture/buildingPictures/";
      $file=scandir($dir);
      $str = implode(",", $file);
      echo $str;
      return $str;
   }


}

  function readIMG($dir,$info){
     // $dir="D:/wamp/www/newsy/public/images/situationPicture/untouched/";
    $path='public/images/situationPicture/';
       if (is_dir($dir)) {
             $i=0;
             $images= array();
          if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
              
                  $fileTy=filetype($dir . $file) ;
                    // echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
                    if ($fileTy=='file') {
                      $images[$i]=$path.$info.'/'.$file;
                      $i++;
                    } 
              }   
              closedir($dh);
            }
        }
      return $images; 
    }
