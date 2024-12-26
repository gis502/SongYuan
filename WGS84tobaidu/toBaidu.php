
<!--*****功能：把wgs84坐标转为百度地图坐标*******
    *****格式：要把ID设置为主键，有wgs84坐标下的lat和lng，该程序coordinate是数据库里面储存的经纬度
          只需把查询sql语句改为自己的字段，然后要有转换后的百度坐标下的lat和lng字段，
          在updatesql语句中更改为自己的字段。
          该程序每次请求50转化50个坐标，百度文档上每次最多可以转化100
          ********
 -->
<?php
//数据库连接信息 
// $servername = "172.17.130.173";
// $username = "root";
// $password = "root";
// $dbname="sy";

$servername = "47.92.216.173";
$username = "root";
$password = "gis502@hm";
$dbname="songyuan";

// $server="localhost:3306";
// $username="root";
// $password="123456";
// $dbname="songyuan";

// $servername="localhost:3306";
// $username="root";
// $password="123456";
// $dbname="songyuan";
// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
 
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
?>
<?php

        $sql_Count="SELECT COUNT(line) as count FROM zydl";//获取要转数据表内的线总数
        $result_Con = $conn->query($sql_Count);
        var_dump($result_Con);
        $result_Con=$result_Con->fetch_assoc()['count']; //得到线总数     
        $num=0;
        $start=1;
        $end=51;
        while (true) {
          if($end>=$result_Con){
             $end=$result_Con;
           }
            $sql="select id,lat,lng from zydl where id >=".$start." and id <=".$end; //获取经纬度，需要把coordinate改为自己的经纬度字段
            var_dump($sql);
            $result = $conn->query($sql);
            $p=0;
            $Point = array();
            $baiduXY=array();
            $coords=null;
           if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                $PointID[$p++]=str_replace(' ','',$row["id"]);//去除空格
                $Point[$p++]=str_replace(' ','',$row["lng"]);//去除空格
                $Point[$p++]=str_replace(' ','',$row["lat"]);//去除空格
              
                $coords=$coords.$row["lng"].",".$row["lat"].";";//经纬度拼接，符合百度接口
            }
           }
           var_dump($coords);
           exit;
           $coords=substr($coords,0 ,strlen($coords)-1);//把最后一个;去掉
            //百度坐标转化接口
            
            $url='http://api.map.baidu.com/geoconv/v1/?coords='.$coords.'&from=1&to=5&ak=RHKX4sKEYnreDcwAx8pYxqARPOYxRbjR';
          //  $url='http://api.map.baidu.com/geoconv/v1/?coords='.$coords.'&from=1&to=5&ak=dAiSmSs6IHrw03DIrn0YTWWBTenyA9Iy';//百度提供的坐标转换接口
           $url=str_replace(' ','',$url);//去除空格
           //var_dump($url);
          
          //php的请求百度接口

          $curl = curl_init();
          //设置抓取的url
          curl_setopt($curl, CURLOPT_URL,$url);
          //设置头文件的信息作为数据流输出
          curl_setopt($curl, CURLOPT_HEADER, 1);
          //设置获取的信息以文件流的形式返回，而不是直接输出。
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          //执行命令
          $response = curl_exec($curl);//接收百度接口返回的数据
          //关闭URL请求
          curl_close($curl);
            //显示百度接口返回的数据
           print_r($response);
             

               // return  $response;
            // var_dump($response);
            // var_dump(strlen($response) );
           $needle='{';
           $m=strpos ( $response ,$needle ,0 );//截取返回json数据
           $response_json=substr($response,$m ,strlen($response));//把字符串转为json数据
           $response_json=json_decode($response_json);
           // var_dump($response_json);
           // var_dump($m);
           $json_Length=count($response_json->{'result'});
         
           for ($i=0; $i <$json_Length; $i++) { 
               $lat=$response_json->{'result'}[$i]->{'x'}; //得到lat
               $lng=$response_json->{'result'}[$i]->{'y'}; //得到lng
               //var_dump($lat.','.$lng);
               $num++;
               $sql1="UPDATE ssgx SET baidu_X =".$lat.", baidu_Y = ".$lng." WHERE id = ".$num; //把数据插入到数据库
               var_dump($sql1);
               $result1 = $conn->query($sql1);
              var_dump($result1);
            }
            if ( $end==$result_Con) {
              var_dump(" you are success");
              exit;
            }
            $end1=$end;
            $start1=$start;
          $end=$end+($end1-$start1)+1;
          $start=$start+($end1-$start1)+1;
      }
 ?>
