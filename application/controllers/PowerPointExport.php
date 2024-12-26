<?php
/*
**@function Out put the word into public/PPT
**@need PHPWord Class in application/libraries/PHPPowerpoint
**@author zdx_y
**@date the last modified time 2017-4-4
*/
defined('BASEPATH') OR exit('No direct script access allowed');
//./public/ppt_images/phppowerpoint_logo.gif
class PowerPointExport extends CI_Controller{

public function index(){
	//echo  dirname(dirname(__FILE__));
	define('ROOT_PATH',dirname(dirname(__FILE__)));
	//echo ROOT_PATH;
	//echo ROOT_PATH.'/libraries/PHPPowerpoint.php';
		require_once ROOT_PATH.'/libraries/PHPPowerPoint.php';
		require_once ROOT_PATH.'/libraries/PHPPowerPoint/IOFactory.php';
//$this->load->library('PHPPowerpoint');
	//$this->load->library('PHPPowerpoint/IOFactory');
	// Create new PHPPowerPoint object
$objPHPPowerPoint = new PHPPowerPoint();


// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw");
$objPHPPowerPoint->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPPowerPoint->getProperties()->setTitle("Office 2007 PPTX Test Document");
$objPHPPowerPoint->getProperties()->setSubject("Office 2007 PPTX Test Document");
$objPHPPowerPoint->getProperties()->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.");
$objPHPPowerPoint->getProperties()->setKeywords("office 2007 openxml php");
$objPHPPowerPoint->getProperties()->setCategory("Test result file");

// Remove first slide
//echo date('H:i:s') . " Remove first slide\n";
$objPHPPowerPoint->removeSlideByIndex(0);

// Create templated slide
//echo date('H:i:s') . " Create templated slide\n";
$currentSlide = $this->createTemplatedSlide($objPHPPowerPoint); // local function


// Create a shape (text)
//echo date('H:i:s') . " Create a shape (rich text)\n";
$shape = $currentSlide->createRichTextShape();
$shape->setHeight(200);
$shape->setWidth(800);
$shape->setOffsetX(400);
$shape->setOffsetY(200);
$shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

//$textRun->getFont()->setBold(true);
//$textRun->getFont()->setSize(28);
//$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );



$textRun = $shape->createTextRun('松原市震后模拟房屋受损情况汇报');
$textRun->getFont()->setBold(true);
$textRun->getFont()->setSize(60);
$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );

$shape->createBreak();

$shape = $currentSlide->createRichTextShape();
$shape->setHeight(50);
$shape->setWidth(400);
$shape->setOffsetX(1000);
$shape->setOffsetY(600);
$shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

$textRun = $shape->createTextRun('----汇报人：xxx');
$textRun->getFont()->setBold(true);
$textRun->getFont()->setSize(28);
$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );

// Create templated slide
//echo date('H:i:s') . " Create templated slide\n";
$currentSlide =$this->createTemplatedSlide($objPHPPowerPoint); // local function

// Create a shape (text)
//echo date('H:i:s') . " Create a shape (rich text)\n";
$shape = $currentSlide->createRichTextShape();
$shape->setHeight(100);
$shape->setWidth(930);
$shape->setOffsetX(300);
$shape->setOffsetY(100);
$shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

$textRun = $shape->createTextRun('1.松原市震后模拟房屋受损情况');
$textRun->getFont()->setBold(true);
$textRun->getFont()->setSize(48);
$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );

// Create a shape (text)
//echo date('H:i:s') . " Create a shape (rich text)\n";
$shape = $currentSlide->createRichTextShape();
$shape->setHeight(400);
$shape->setWidth(930);
$shape->setOffsetX(300);
$shape->setOffsetY(200);
$shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

date_default_timezone_set('PRC'); //时间定位于北京时间，除去此函数可以在php.ini修改配置文件
	$year = date("Y");
	$month = date("m");
	$day = date("d");
	$hour = date("H");
	$minute = date("i");
	$second = date("s");

    $startX = $_POST['startX'];
    $startY = $_POST['startY'];
    $intensity = $_POST['intensity'];
    $capturearray=$_POST['capturearray'];
    
    $file_pictureA = './public/screen_images/A/';
    $file_pictureB = './public/screen_images/B/';
    $file_pictureC = './public/screen_images/C/';
    $file_pictureD = './public/screen_images/D/';
    $file_pictureE = './public/screen_images/E/';

$textRun = $shape->createTextRun('- '.$year.'年'.$month.'月'.$day.'日'.$hour.'时'.$minute.'分'.$second.'秒发生'.$intensity.'级地震');
$textRun->getFont()->setSize(36);
$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );

$shape->createBreak();
$shape->createBreak();


$textRun = $shape->createTextRun('- 震中位于松原市东经'.$startX.'，北纬'.$startY.'');
$textRun->getFont()->setSize(36);
$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );

$shape->createBreak();
$shape->createBreak();

$textRun = $shape->createTextRun('- 震区烈度圈、震区房屋破坏分布情况及房屋破坏占比情况见如下');
$textRun->getFont()->setSize(36);
$textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );

if($capturearray[0]==1){
    $currentSlide =$this->createTemplatedSlide($objPHPPowerPoint); // local function
    $darr=scandir($file_pictureA);
    $result=array();
    foreach ($darr as $key => $value) {
        array_push($result,str_replace(".jpg","",$value));
    }
    $bigdate=max($result);
    $bigdate.=".jpg";

// Add the first image
    $shape = $currentSlide->createDrawingShape();
    $shape->setName('Background');
    $shape->setDescription('Background');
    $shape->setPath('./public/screen_images/A/'.$bigdate);
    $shape->setWidth(1000);
    $shape->setHeight(500);
    $shape->setOffsetX(300);
    $shape->setOffsetY(100);

    $shape = $currentSlide->createRichTextShape();
    $shape->setHeight(50);
    $shape->setWidth(300);
    $shape->setOffsetX(700);
    $shape->setOffsetY(600);
    $shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

    $textRun = $shape->createTextRun('震区烈度圈图');
    $textRun->getFont()->setBold(true);
    $textRun->getFont()->setSize(20);
    $textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );
}
if($capturearray[1]==1){
    $currentSlide =$this->createTemplatedSlide($objPHPPowerPoint); // local function
    $darr=scandir($file_pictureB);
    $result=array();
    foreach ($darr as $key => $value) {
        array_push($result,str_replace(".jpg","",$value));
    }
    $bigdate=max($result);
    $bigdate.=".jpg";
// Add the first image
    $shape = $currentSlide->createDrawingShape();
    $shape->setName('Background');
    $shape->setDescription('Background');
    $shape->setPath('./public/screen_images/B/'.$bigdate);
    $shape->setWidth(1000);
    $shape->setHeight(500);
    $shape->setOffsetX(300);
    $shape->setOffsetY(100);

    $shape = $currentSlide->createRichTextShape();
    $shape->setHeight(50);
    $shape->setWidth(400);
    $shape->setOffsetX(700);
    $shape->setOffsetY(600);
    $shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

    $textRun = $shape->createTextRun('震区房屋破坏分布情况图');
    $textRun->getFont()->setBold(true);
    $textRun->getFont()->setSize(20);
    $textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );
}


if($capturearray[2]==1){
    $currentSlide =$this->createTemplatedSlide($objPHPPowerPoint); // local function
    $darr=scandir($file_pictureC);
    $result=array();
    foreach ($darr as $key => $value) {
        array_push($result,str_replace(".jpg","",$value));
    }
    $bigdate=max($result);
    $bigdate.=".jpg";
// Add the first image
    $shape = $currentSlide->createDrawingShape();
    $shape->setName('Background');
    $shape->setDescription('Background');
    $shape->setPath('./public/screen_images/C/'.$bigdate);
    $shape->setWidth(1000);
    $shape->setHeight(500);
    $shape->setOffsetX(300);
    $shape->setOffsetY(100);

    $shape = $currentSlide->createRichTextShape();
    $shape->setHeight(50);
    $shape->setWidth(400);
    $shape->setOffsetX(700);
    $shape->setOffsetY(600);
    $shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

    $textRun = $shape->createTextRun('房屋破坏占比情况图');
    $textRun->getFont()->setBold(true);
    $textRun->getFont()->setSize(20);
    $textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );
}
if($capturearray[3]==1){
    $currentSlide =$this->createTemplatedSlide($objPHPPowerPoint); // local function
    $darr=scandir($file_pictureD);
    $result=array();
    foreach ($darr as $key => $value) {
        array_push($result,str_replace(".jpg","",$value));
    }
    $bigdate=max($result);
    $bigdate.=".jpg";
// Add the first image
    $shape = $currentSlide->createDrawingShape();
    $shape->setName('Background');
    $shape->setDescription('Background');
    $shape->setPath('./public/screen_images/D/'.$bigdate);
    $shape->setWidth(1000);
    $shape->setHeight(500);
    $shape->setOffsetX(300);
    $shape->setOffsetY(100);

    $shape = $currentSlide->createRichTextShape();
    $shape->setHeight(50);
    $shape->setWidth(400);
    $shape->setOffsetX(700);
    $shape->setOffsetY(600);
    $shape->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

    $textRun = $shape->createTextRun('房屋破坏占比情况图');
    $textRun->getFont()->setBold(true);
    $textRun->getFont()->setSize(20);
    $textRun->getFont()->setColor( new PHPPowerPoint_Style_Color( 'FF3030' ) );
}
// Save PowerPoint 2007 file
//echo date('H:i:s') . " Write to PowerPoint2007 format\n";
$objWriter = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
//$objWriter->save(str_replace('.php', '.pptx', __FILE__));
$date = date('YmdHis');
$savefile = './public/PPT/'.$date.'.pptx';
$objWriter->save($savefile);
echo $savefile;	 
	// Save File
	// $objWriter = IOFactory::createWriter($PHPWord, 'Word2007');
 //    $date = date('YmdHis');
 //    $savefile = './public/Word/'.$date.'.docx';
 //    $objWriter->save($savefile);
 //    echo $savefile;
    
}
	
/**
 * Creates a templated slide
 * 
 * @param PHPPowerPoint $objPHPPowerPoint
 * @return PHPPowerPoint_Slide
 */
public  function createTemplatedSlide(PHPPowerPoint $objPHPPowerPoint)
{
	// Create slide
	$slide = $objPHPPowerPoint->createSlide();
	
	// Add background image
    $shape = $slide->createDrawingShape();
    $shape->setName('Background');
    $shape->setDescription('Background');
    $shape->setPath('./public/ppt_images/background.png');
    $shape->setWidth(800);
    $shape->setHeight(720);
    $shape->setOffsetX(0);
    $shape->setOffsetY(0);
    
    // Add logo
    $shape = $slide->createDrawingShape();
    $shape->setName('PHPPowerPoint logo');
    $shape->setDescription('PHPPowerPoint logo');
    $shape->setPath('./public/ppt_images/cidp.png');
    $shape->setHeight(150);
    $shape->setWidth(150);
    $shape->setOffsetX(10);
    $shape->setOffsetY(720 - 20 - 40-100);
    
    // Return slide
    return $slide;
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
