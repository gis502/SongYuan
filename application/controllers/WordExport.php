<?php
/*
**@function Out put the word into public/Word
**@need PHPWord Class in application/libraries/PHPWord
**@author zdx_y
**@date the last modified time 2017-4-4
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class WordExport extends CI_Controller{
public function describe_content($num){
	$content='';
	switch((int)$num){
		case 0:$content='';
		break;
		case 1:$content='对市区而言，部分框架结构建筑的填充墙可能会出现裂缝。';
		break;
		case 2:$content='对市区而言，一定数量的框架结构填充墙会出现裂缝，少量女儿墙和出屋面烟囱会歪斜或掉落。';
		break;
		case 3:$content='可能导致少量危房倒塌并造成百余人轻伤及少量重伤。对市区可导致超过半数的框架房屋填充墙出现明显开裂，少量女儿墙、出屋面烟囱掉落。部分砖混房屋底层窗间墙、墙角可能出现裂缝。';
		break;
		case 4:$content='可能导致百余栋危房倒塌或严重破坏，有少量人员死亡，几十人重伤，几百人轻伤。对市区可能导致少量老旧危房倒塌，近1/4框架、砖混及高层剪力墙结构出现明显墙体裂缝，较多的女儿墙、出屋面烟囱掉落。';
		break;
		case 5:$content='可能导致千余栋危房倒塌或严重破坏，有数百人死亡，千余人重伤，几千人轻伤。对市区可能导致近半数老旧危房倒塌，近1/4框架、砖混结构中等或严重破坏，多数高层剪力墙结构出现明显墙体裂缝，少量出现主体结构构建损伤。';
		break;
		case 6:$content='可能导致千余栋危房倒塌或严重破坏，有近千人死亡，千余人重伤，数千人轻伤。对市区可能导致超过半数老旧危房倒塌，近1/2框架、砖混结构中等或严重破坏，多数高层剪力墙结构出现明显墙体裂缝，少量出现主体结构构建损伤。';
		break;
		default:
		$content='';
	}
	return $content;
}
public function index(){
	// var_dump($_POST);
	$detail_address=$_POST['detail_address'];//经纬度转详细地址
	$describe_flag=$_POST['describe_flag'];//描述语句的切换标志
	$FailureType=$_POST['FailureType'];//破坏类型
	$startX = $_POST['startX'];
	$startY = $_POST['startY'];
	$intensity = $_POST['intensity'];
	$capturearray=$_POST['capturearray'];
	$pointarray=$_POST['markerpoint'];
	$warming_points=$_POST['warming_points'];
	$mpoint=json_decode($warming_points, true);
	$ppoint=json_decode($pointarray, true);
	$this->load->library('PHPWord');
	$this->load->library('PHPWord/IOFactory');
	$PHPWord = new PHPWord();
	// New portrait section
	$section = $PHPWord->createSection();
	//Get time stamp
	date_default_timezone_set('PRC'); //时间定位于北京时间，除去此函数可以在php.ini修改配置文件
	$year = date("Y");
	$month = date("m");
	$day = date("d");
	$hour = date("H");
	$minute = date("i");
	$second = date("s");
 

	// Add header
	$header = $section->createHeader();
	$table = $header->addTable();
	$table->addRow();
	$table->addCell(4500)->addText($year.'年'.$month.'月'.$day.'日');
	$table->addCell(4500)->addText('测试版',null,array('align'=>'right'));
	// Add listitem elements
	$PHPWord->addFontStyle('myOwnStyle', array('name'=>'FangSong', 'size'=>'14'));
	$PHPWord->addParagraphStyle('P-Style', array('spaceAfter'=>95));
	$listStyle = array('listType'=>PHPWord_Style_ListItem::TYPE_NUMBER_NESTED);
	$section->addListItem('松原市震后受损情况推演', 0, 'myOwnStyle', $listStyle, 'P-Style');
	// Add the main text elements
	$PHPWord->addFontStyle('rmStyle', array('bold'=>false, 'name'=>'FangSong', 'size'=>'14'));
	$PHPWord->addParagraphStyle('pmStyle', array('align'=>'left','spacing'=>150, 'spaceAfter'=>100,'spaceBefore'=>50));
	$section->addText($year.'年'.$month.'月'.$day.'日'.$hour.'时'.$minute.'分'.$second.'秒发生'.$intensity.'级地震，震中位于'.$detail_address.'东经'.$startX.'，北纬'.$startY.'。震区烈度圈、震区房屋破坏分布情况及房屋破坏占比情况如图下。', 'rmStyle', 'pmStyle');
	$file_pictureA = './public/screen_images/A/';
	$file_pictureB = './public/screen_images/B/';
	$file_pictureC = './public/screen_images/C/';
	$file_pictureD = './public/screen_images/D/';
	$file_pictureE = './public/screen_images/E/';
	$bigdate=scandir($file_pictureA);
	//var_dump($big);
	if ($capturearray[0]==1) {
		$darr=scandir($file_pictureA);
		$result=array();
		foreach ($darr as $key => $value) {
		    array_push($result,str_replace(".jpg","",$value));
		}
		$bigdate=max($result);
		$bigdate.=".jpg";

		$section->addImage($file_pictureA.$bigdate, array('width'=>650, 'height'=>350, 'align'=>'center'));
		$PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		$PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		$section->addText('震区烈度圈图', 'r4Style', 'p4Style');
		$section->addTextBreak(2);
	}else{
		//echo "A不存在";
		// $section->addImage('./public/screen_images/D201707050922.jpg', array('width'=>650, 'height'=>350, 'align'=>'center'));
		// $PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		// $PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		// $section->addText('震区烈度圈图', 'r4Style', 'p4Style');
		// $section->addTextBreak(2);
	}
	if ($capturearray[1]==1) {
		//echo  "B存在";
		$darr=scandir($file_pictureB);
		$result=array();
		foreach ($darr as $key => $value) {
		    array_push($result,str_replace(".jpg","",$value));
		}
		$bigdate=max($result);
		$bigdate.=".jpg";
		$section->addImage($file_pictureB.$bigdate, array('width'=>650, 'height'=>350, 'align'=>'center'));
		$PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		$PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		$section->addText('震区房屋破坏情况分布图', 'r4Style', 'p4Style');
		$section->addTextBreak(2);
	}else{
		//echo "B不存在";
		// $section->addImage('./public/screen_images/D201707050924.jpg', array('width'=>650, 'height'=>350, 'align'=>'center'));
		// $PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		// $PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		// $section->addText('震区房屋破坏情况分布图', 'r4Style', 'p4Style');
		// $section->addTextBreak(2);
	}
	if ($capturearray[2]==1) {
		$darr=scandir($file_pictureC);
		$result=array();
		foreach ($darr as $key => $value) {
		    array_push($result,str_replace(".jpg","",$value));
		}
		$bigdate=max($result);
		$bigdate.=".jpg";
		$section->addImage($file_pictureC.$bigdate, array('width'=>650, 'height'=>350, 'align'=>'center'));
		$PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		$PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		$section->addText('震区房屋破坏情况饼状图', 'r4Style', 'p4Style');
		$section->addTextBreak(2);
	}else{
		//echo "C不存在";
		// $section->addImage('./public/screen_images/C201703311606.jpg', array('width'=>650, 'height'=>350, 'align'=>'center'));
		// $PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		// $PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		// $section->addText('震区房屋破坏情况占比图', 'r4Style', 'p4Style');
		// $section->addTextBreak(2);
	}
		if ($capturearray[3]==1) {
		$darr=scandir($file_pictureD);
		$result=array();
		foreach ($darr as $key => $value) {
		    array_push($result,str_replace(".jpg","",$value));
		}
		$bigdate=max($result);
		$bigdate.=".jpg";
		$section->addImage($file_pictureD.$bigdate, array('width'=>650, 'height'=>350, 'align'=>'center'));
		$PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		$PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		$section->addText('震区房屋破坏情况柱状图', 'r4Style', 'p4Style');
		$section->addTextBreak(2);
	}else{
		//echo "C不存在";
		// $section->addImage('./public/screen_images/C201703311606.jpg', array('width'=>650, 'height'=>350, 'align'=>'center'));
		// $PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		// $PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		// $section->addText('震区房屋破坏情况占比图', 'r4Style', 'p4Style');
		// $section->addTextBreak(2);
	}
		if ($capturearray[4]==1) {
		$darr=scandir($file_pictureE);
		$result=array();
		foreach ($darr as $key => $value) {
		    array_push($result,str_replace(".jpg","",$value));
		}
		$bigdate=max($result);
		$bigdate.=".jpg";
		$section->addImage($file_pictureE.$bigdate, array('width'=>650, 'height'=>350, 'align'=>'center'));
		$PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		$PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		$section->addText('市区内建筑情况', 'r4Style', 'p4Style');
		$section->addTextBreak(2);
	}else{
		//echo "C不存在";
		// $section->addImage('./public/screen_images/C201703311606.jpg', array('width'=>650, 'height'=>350, 'align'=>'center'));
		// $PHPWord->addFontStyle('r4Style', array('bold'=>true, 'name'=>'FangSong', 'size'=>'9'));
		// $PHPWord->addParagraphStyle('p4Style', array('align'=>'center', 'spaceAfter'=>100));
		// $section->addText('震区房屋破坏情况占比图', 'r4Style', 'p4Style');
		// $section->addTextBreak(2);
	}

// 定义表格样式
	$styleTable = array('alignMent' => 'center', 'cellMargin'=>80,'borderLeftColor'=>'ffffff','borderRightColor'=>'ffffff','borderInsideVColor'=>'ffffff');
	$styleFirstRow = array('borderBottomSize'=>16, 'borderBottomColor'=>'434343', 'bgColor'=>'ffffff');
	// 定义单元格样式
	$styleCell = array('valign'=>'center');
	$firstCellStyle = array('valign'=>'center','borderTopSize'=>16,'borderTopColor'=>'434343','borderBottomSize'=>16,'borderBottomColor'=>'434343');
	$styleCellBTLR = array('valign'=>'center','textDirection'=>\PHPWord_Style_Cell::TEXT_DIR_BTLR);
	// 定义第一行文字样式
	$fontStyle = array('bold'=>true, 'align'=>'center');
	$PHPWord->addParagraphStyle('pStyle', array('bold'=>true,'align'=>'center'));
	// 定义表格样式
	$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
	// 定义标题样式
	$titleFont = array('bold'=>true,'size'=>20);

if( $ppoint!=null ){

	// 添加标题
	$section->addText('预估受灾区域',$titleFont,array('align'=>'center'));
	$section->addText('本次'.$intensity.'级地震的受灾区域预估有'.count($ppoint).'个受到'.$FailureType.'的区域。','rmStyle','pmStyle');
	// 根据震级添加不同文本
	if($intensity>=4.0&&$intensity<4.7){
		$section->addText('根据此次地震产生的最高烈度为6度，影响范围直径10公里左右；产生烈度为6度的影响范围直径为20公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if($intensity>=4.7&&$intensity<5.3){
		$section->addText('根据此次地震产生的最高烈度为7度，影响范围直径10公里左右；产生烈度为6度的影响范围直径为30公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if($intensity>=5.3&&$intensity<5.7){
		$section->addText('根据此次地震产生的最高烈度为7度，影响范围直径20公里左右；产生烈度为6度的影响范围直径为60公里左右。在极震区可能会造成少量人员轻伤。'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=5.7&&$intensity<6.3) {
		$section->addText('根据此次地震产生的最高烈度为8度，影响范围直径20公里左右；产生烈度为7度的影响范围直径为40公里左右；产生烈度为6度的影响范围直径为80公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=6.3&&$intensity<6.7) {
		$section->addText('根据此次地震产生的最高烈度可能达到9度，影响范围直径10公里左右；产生烈度为8度的影响范围直径为40公里左右；产生烈度为7度的影响范围直径100公里左右；产生烈度为6度的影响范围直径200公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=6.7&&$intensity<7.3) {
		$section->addText('根据此次地震产生的最高烈度可能达到9-10度，影响范围直径15公里左右；产生烈度为8度的影响范围直径为60公里左右；产生烈度为7度的影响范围直径140公里左右；产生烈度为6度的影响范围直径300公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=7.3&&$intensity<=8.0) {
		$section->addText('根据此次地震产生的最高烈度可能达到10度，影响范围直径10公里左右；产生烈度为9度的影响范围直径为20公里左右；产生烈度为8度的影响范围直径为60公里左右；产生烈度为7度的影响范围直径140公里左右；产生烈度为6度的影响范围直径300公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}
	// 添加表格
	foreach ($ppoint as $key => $value) {
		$table=$section->addTable('myOwnTableStyle');
		$table->addRow(600);
		$table->addCell(2000, $firstCellStyle)->addText('预估受灾区域'.($key+1), $fontStyle,'pStyle');
		$table->addCell(2000, $firstCellStyle)->addText('中心点', $fontStyle,'pStyle');
		$table->addCell(2000, $firstCellStyle)->addText('东经：'.$value['lng'], $fontStyle,'pStyle');
		$table->addCell(2000, $firstCellStyle)->addText('北纬：'.$value['lat'], $fontStyle,'pStyle');
		$table->addRow(600);
		$table->addCell(2000, $styleCell)->addText('周围建筑', $styleFirstRow,'pStyle');
		foreach ($value['marher'] as $shy => $conmar) {
			foreach ($mpoint as $sky => $worthy) {
				if($worthy['baidu_X']==$conmar['lng']&&$worthy['baidu_Y']==$conmar['lat']){
					$table->addRow(400);
					$table->addCell(2000, $styleCell)->addText('坐标点'.($shy+1), $fontStyle,'pStyle');
					$table->addCell(2000, $styleCell)->addText('东经：'.round($conmar['lng'],7), $fontStyle,'pStyle');
					$table->addCell(2000, $styleCell)->addText('北纬：'.round($conmar['lat'],7), $fontStyle,'pStyle');
					$table->addCell(2000, $styleCell)->addText($worthy['buildingName'], $fontStyle,'pStyle');
				}
			}
		}
		$section->addTextBreak(3);
	}


}else{
	// 根据震级添加不同文本
	// if($intensity>=4.7&&$intensity<5.3){
	// 	$section->addText('根据此次地震产生的最高烈度为7度，影响范围直径10公里左右；产生烈度为6度的影响范围直径为30公里左右；对市区而言，部分框架结构建筑的填充墙可能会出现裂缝。','rmStyle','pmStyle');
	// }else if($intensity>=5.3&&$intensity<5.7){
	// 	$section->addText('根据此次地震产生的最高烈度为7度，影响范围直径20公里左右；产生烈度为6度的影响范围直径为60公里左右。在极震区可能会造成少量人员轻伤。对市区而言，一定数量的框架结构填充墙会出现裂缝，少量女儿墙和出屋面烟囱会歪斜或掉落。','rmStyle','pmStyle');
	// }else if ($intensity>=5.7&&$intensity<6.3) {
	// 	$section->addText('根据此次地震产生的最高烈度为8度，影响范围直径20公里左右；产生烈度为7度的影响范围直径为40公里左右；产生烈度为6度的影响范围直径为80公里左右；可能导致少量危房倒塌并造成百余人轻伤及少量重伤。对市区可导致超过半数的框架房屋填充墙出现明显开裂，少量女儿墙、出屋面烟囱掉落。部分砖混房屋底层窗间墙、墙角可能出现裂缝。','rmStyle','pmStyle');
	// }else if ($intensity>=6.3&&$intensity<6.7) {
	// 	$section->addText('根据此次地震产生的最高烈度可能达到9度，影响范围直径10公里左右；产生烈度为8度的影响范围直径为40公里左右；产生烈度为7度的影响范围直径100公里左右；产生烈度为6度的影响范围直径200公里左右；可能导致百余栋危房倒塌或严重破坏，有少量人员死亡，几十人重伤，几百人轻伤。对市区可能导致少量老旧危房倒塌，近1/4框架、砖混及高层剪力墙结构出现明显墙体裂缝，较多的女儿墙、出屋面烟囱掉落。','rmStyle','pmStyle');
	// }else if ($intensity>=6.7&&$intensity<7.3) {
	// 	$section->addText('根据此次地震产生的最高烈度可能达到9-10度，影响范围直径15公里左右；产生烈度为8度的影响范围直径为60公里左右；产生烈度为7度的影响范围直径140公里左右；产生烈度为6度的影响范围直径300公里左右；可能导致千余栋危房倒塌或严重破坏，有数百人死亡，千余人重伤，几千人轻伤。对市区可能导致近半数老旧危房倒塌，近1/4框架、砖混结构中等或严重破坏，多数高层剪力墙结构出现明显墙体裂缝，少量出现主体结构构建损伤。','rmStyle','pmStyle');
	// }else if ($intensity>=7.3&&$intensity<=8.0) {
	// 	$section->addText('根据此次地震产生的最高烈度可能达到10度，影响范围直径10公里左右；产生烈度为9度的影响范围直径为20公里左右；产生烈度为8度的影响范围直径为60公里左右；产生烈度为7度的影响范围直径140公里左右；产生烈度为6度的影响范围直径300公里左右；可能导致千余栋危房倒塌或严重破坏，有近千人死亡，千余人重伤，数千人轻伤。对市区可能导致超过半数老旧危房倒塌，近1/2框架、砖混结构中等或严重破坏，多数高层剪力墙结构出现明显墙体裂缝，少量出现主体结构构建损伤。','rmStyle','pmStyle');
	// }
	if($intensity>=4.0&&$intensity<4.7){
		$section->addText('根据此次地震产生的最高烈度为6度，影响范围直径10公里左右；产生烈度为6度的影响范围直径为20公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if($intensity>=4.7&&$intensity<5.3){
		$section->addText('根据此次地震产生的最高烈度为7度，影响范围直径10公里左右；产生烈度为6度的影响范围直径为30公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if($intensity>=5.3&&$intensity<5.7){
		$section->addText('根据此次地震产生的最高烈度为7度，影响范围直径20公里左右；产生烈度为6度的影响范围直径为60公里左右。在极震区可能会造成少量人员轻伤。'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=5.7&&$intensity<6.3) {
		$section->addText('根据此次地震产生的最高烈度为8度，影响范围直径20公里左右；产生烈度为7度的影响范围直径为40公里左右；产生烈度为6度的影响范围直径为80公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=6.3&&$intensity<6.7) {
		$section->addText('根据此次地震产生的最高烈度可能达到9度，影响范围直径10公里左右；产生烈度为8度的影响范围直径为40公里左右；产生烈度为7度的影响范围直径100公里左右；产生烈度为6度的影响范围直径200公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=6.7&&$intensity<7.3) {
		$section->addText('根据此次地震产生的最高烈度可能达到9-10度，影响范围直径15公里左右；产生烈度为8度的影响范围直径为60公里左右；产生烈度为7度的影响范围直径140公里左右；产生烈度为6度的影响范围直径300公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}else if ($intensity>=7.3&&$intensity<=8.0) {
		$section->addText('根据此次地震产生的最高烈度可能达到10度，影响范围直径10公里左右；产生烈度为9度的影响范围直径为20公里左右；产生烈度为8度的影响范围直径为60公里左右；产生烈度为7度的影响范围直径140公里左右；产生烈度为6度的影响范围直径300公里左右；'.$this->describe_content($describe_flag),'rmStyle','pmStyle');
	}
	
}
	 
	// Save File
	$objWriter = IOFactory::createWriter($PHPWord, 'Word2007');
    $date = date('YmdHis');
    $savefile = './public/Word/'.$date.'.docx';
    $objWriter->save($savefile);
    echo $savefile;
    
}
	//发送标题强制用户下载文件
	public function sefile(){  
        $data = $_GET[zdx];  
        $filename = $data;    
        header('Content-Type: application/octet-stream');       
        header('content-disposition:attachment;filename='.basename($filename));
        header('content-length:'.filesize($filename));
        readfile($filename);
        unlink($filename);
    }

	
}
