<?php 

class ImportExcel extends CI_Model{
public function __construct(){
 $this->load->database();//、连接数据库
}
public function EdataAdd_M($objPHPExcel){
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();//获取数据条数
    $highestColumn = $sheet->getHighestColumn();//获取数据列数
    $highestColumn++;
    $Dbname=array('industry_buliding','civil_bulidling','public_buliding','waterss_buliding','heatingss_buliding','electricss_buliding','naturalgas_station','naturalgasgate_statio','secondarydisaster_source','fire_building','liquefiedgasss','communicationbs','bridge_buliding');
    $IfField=array("buildingNumber"=>"null","X"=>"null","Y"=>"null","propertyType"=>"null");
    $sql="INSERT INTO all_buliding";
    $TitleID=$this->getEdataColumnNum($highestColumn,$objPHPExcel);//字段名
    $mes=$this->getEdataRow($highestRow,$highestColumn,$objPHPExcel,$IfField,$TitleID);//数据
    $AllData=$mes[0];
    $SqlArray=$mes[1];
    // $savefile=$mes[2];
    if(!$mes[2]){ //如果有空数据就不插
        return $response = array(
          'status' =>false
        );
    }
    $sql.='('.implode(",",$TitleID).')'."VALUES".implode(",",$AllData);
    $resultAll=true;
    for($i=0;$i<count($mes[1]);$i++){
        if($SqlArray[$i]!=null){
            $sqlOther="INSERT INTO ".$Dbname[$i].'('.implode(",",$TitleID).')'."VALUES".implode(",",$SqlArray[$i]);
            $result=$this->db->query($sqlOther);
            $resultAll=$result && $resultAll;
        }
    }
    $query=$this->db->query($sql);
    $resultAll=$query && $resultAll&&$mes[2];
    $response = array(
      'status' =>$resultAll,
    //   'url' => $savefile
    );
    return $response;
    }
public function getEdataColumnNum($highestColumnNum,$objPHPExcel,$i=1,$h='A',$TitleID=null){
        $result=array();
        for($j=$h;$j!=$highestColumnNum;$j++){
            $X = $objPHPExcel->getActiveSheet()->getCell($j.$i)->getValue();
            if($i==1){
                $result[$j]=$X;
            }else{                
                $s=ord($j)-65;        
                if(is_numeric($X)){
                    $X==null?$result[$TitleID[$j]]='null':$result[$TitleID[$j]]=$X; 
                }else{
                    $X==null?$result[$TitleID[$j]]='null':$result[$TitleID[$j]]='"'.$X.'"'; 
                }
            }
        }
        return $result;
      }
public  function IfFieldF($Data,$IfField,$TitleID,$j){
        $x=array_intersect_assoc($IfField,$Data);
        if($x==null&&$Data['baidu_X']!='null'&&$Data['baidu_Y']!='null'){
        }elseif($x==null&&$Data['X']!='null'&&$Data['Y']!='null'){
            $Data=array_merge($Data,$this->convert($Data['X'].','.$Data['Y']));
        }else{
            // $this->WExcel($Data,$WritePHPExcel,$IfField,$j);
            return null;
      }
      return $Data;
}
// public function WExcel($Data,$WritePHPExcel,$IfField=null,$j=1){
//         for($i='A',$h=0;$i!='AN';$i++,$h++){
//             $keys=array_keys($Data);
//             $j==1?$Data1=$Data[$i]:$Data1=$Data[$keys[$h]];
//             $Data1=='null'?$Data1=null:$Data1;
//             $WritePHPExcel->setActiveSheetIndex(0)->setCellValue($i.$j, $Data1);  
//             if($IfField!=null && array_key_exists($keys[$h],$IfField)){
//                 if($IfField[$keys[$h]]==$Data[$keys[$h]]){
//                  $WritePHPExcel->getActiveSheet()->getStyle($i.$j)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//                  $WritePHPExcel->getActiveSheet()->getStyle($i.$j)->getFill()->getStartColor()->setARGB('FF0000');
//                 }
//             }
//         }
// }
public function addPart($Data,$TitleID,$SqlArray){
    switch($Data['propertyType']){
    case '"工业建筑"':array_push($SqlArray[0],('('.implode(",",$Data).')'));return $SqlArray;
    case '"民用建筑"':array_push($SqlArray[1],('('.implode(",",$Data).')'));return $SqlArray;
    case '"公共建筑"':array_push($SqlArray[2],('('.implode(",",$Data).')'));return $SqlArray;
    case '"供水系统"':array_push($SqlArray[3],('('.implode(",",$Data).')'));return $SqlArray;
    case '"供热系统"':array_push($SqlArray[4],('('.implode(",",$Data).')'));return $SqlArray;
    case '"供电系统"':array_push($SqlArray[5],('('.implode(",",$Data).')'));return $SqlArray;
    case '"天然气加气站"':array_push($SqlArray[6],('('.implode(",",$Data).')'));return $SqlArray;
    case '"天然气门站"':array_push($SqlArray[7],('('.implode(",",$Data).')'));return $SqlArray;
    case '"次生灾害源"':array_push($SqlArray[8],('('.implode(",",$Data).')'));return $SqlArray;
    case '"消防建筑"':array_push($SqlArray[9],('('.implode(",",$Data).')'));return $SqlArray;
    case '"液化气供应站"':array_push($SqlArray[10],('('.implode(",",$Data).')'));return $SqlArray;
    case '"通信基站"':array_push($SqlArray[11],('('.implode(",",$Data).')'));return $SqlArray;
    case '"桥梁建筑"':array_push($SqlArray[12],('('.implode(",",$Data).')'));return $SqlArray;
    }    
}
public function getEdataRow($highestRow,$highestColumnNum,$objPHPExcel,$IfField,$TitleID,$i=2,$h='A'){
        $AllData=array();$j=2;
        $SqlArray=array();
        $SqlArray[0]=array();
        $SqlArray[1]=array();
        $SqlArray[2]=array();
        $SqlArray[3]=array();
        $SqlArray[4]=array();
        $SqlArray[5]=array();
        $SqlArray[6]=array();
        $SqlArray[7]=array();
        $SqlArray[8]=array();
        $SqlArray[9]=array();
        $SqlArray[10]=array();
        $SqlArray[11]=array();
        $SqlArray[12]=array();
        // $WritePHPExcel = new PHPExcel();
        // $this->WExcel($TitleID,$WritePHPExcel);
        for(;$i<=$highestRow;$i++){
            $Data=$this->getEdataColumnNum($highestColumnNum,$objPHPExcel,$i,$h,$TitleID);
            $Data=$this->IfFieldF($Data,$IfField,$TitleID,$j);
            if($Data!=null){
                $SqlArray=$this->addPart($Data,$TitleID,$SqlArray);
                array_push($AllData,'('.implode(",",$Data).')');
            }else{
                $j++;
            }
        }
        // Save File
        // $objWriter = PHPExcel_IOFactory::createWriter($WritePHPExcel, 'Excel2007');
        // $date = date('YmdHis');
        // $savefile = './public/Excel/'."出错记录".'.xlsx';
        // $objWriter->save($savefile);
        $mes=array();
        $mes[0]= $AllData;
        $mes[1]=$SqlArray;
        $j>=3?$mes[2]= false:$mes[2]=true;
        // $j>=3?$mes[2]= $savefile:$mes[2]=null;
        return $mes;
      }

// public  function saveExcelToLocalFile($objWriter,$filename){
//         // make sure you have permission to write to directory
//         $filePath = 'tmp/'.$filename.'.xlsx';
//         $objWriter->save($filePath);
//         return $filePath;
//     }
public  function convert($coords){
    
        // $url='http://api.map.baidu.com/geoconv/v1/?coords='.$coords.'&from=1&to=5&ak=dAiSmSs6IHrw03DIrn0YTWWBTenyA9Iy';
        $url='http://api.map.baidu.com/geoconv/v1/?coords='.$coords.'&from=1&to=5&ak=RHKX4sKEYnreDcwAx8pYxqARPOYxRbjR';
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL,$url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $response = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
          //显示获得的数据
        //print_r($response);
          $needle='{';
        $m=strpos ($response,$needle,0);
        $response_json=substr($response,$m ,strlen($response));
        $response_json=json_decode($response_json);
        $result=$response_json->{'result'};
        $result=(array)$result[0];
        $a=array("baidu_X","baidu_Y");
        return array_combine($a,$result);;
      }
}
