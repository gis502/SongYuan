<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_Model');
        $this->load->model('Data_Model');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }

    //整个项目对的入口文件
	public function index()
	{
        $a['e']='yes';
		$this->load->view('login',$a);
    }
    //数据管理
    public function dataManage(){
        $this->load->view('datamanage');
    }
	//系统主目录跳转函数
	public function intentMainPage(){
        if(!$_POST){
            $this->load->view('login',$a);
        }else{
            $userName=$_POST['userName'];
            $passWord=$_POST['passWord'];
            if(!$userName||! $passWord){
                $a['e']='yes';
                $this->load->view('login',$a);
            }else{
                $data['user']=$this->Login_Model->loginSelect($userName,$passWord);
                //var_dump($data['user']);
                if ($data['user']==null) {
                    $a['e']='no';
                    $this->load->view('login',$a);
                }else{
                $userPower=$data['user'][0]['userPower'];
                $usercheck=$data['user'][0]['userName'];
                $passwcheck=$data['user'][0]['userPassword'];
                //var_dump($usercheck);
                $newData = array(
                    'userName'  => $userName,
                    'passWord'     => $passWord,
                    'power'=>   $userPower ,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($newData);
                $name = $_SESSION['userName'];
                $password =$_SESSION['passWord'];
                //var_dump($name);
                //var_dump($password);
                $data['All']=$this->Login_Model->checkAdminPower();
                if($name&&$password){

                    $this->load->view('index',$data);
                }else{
                    $this->load->view('login');
                }

                }
                
            }
        }

	}
    public function addUser($userName,$passWord){
        $this->Login_Model->insertToTable($userName,$passWord);
    }
    public function delUser($id,$power){
        $this->Login_Model->deleteToTable($id);
        $data['user']=$this->Login_Model->checkUser($power);
        $data['All']=$this->Login_Model->checkAdminPower();

        //分页开始
        $page_num = '5';//每页的数据
        $data['pageData']= $this->Login_Model->page('adminPower',$page_num,$this->uri->segment(3));
        //var_dump($data['pageData']);
        $total_nums=$data['pageData']['total_nums']; //这里得到从数据库中的总页数
        $data['query']=$data['pageData'][0]; //把查询结果放到$data['query']中
        //将对象变换为数组
        $this->load->library('pagination');
        $config['base_url'] = $this->config->item('base_url').'/index.php/Welcome/delUser/';
        $config['total_rows'] = $total_nums;//总共多少条数据
        $config['per_page'] = $page_num;//每页显示几条数据

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $config['first_link'] = '首页';
        $config['first_tag_open'] = '<li>';//“第一页”链接的打开标签。
        $config['first_tag_close'] = '</li>';//“第一页”链接的关闭标签。

        $config['last_link'] = '尾页';//你希望在分页的右边显示“最后一页”链接的名字。
        $config['last_tag_open'] = '<li>';//“最后一页”链接的打开标签。
        $config['last_tag_close'] = '</li>';//“最后一页”链接的关闭标签。

        $config['next_link'] = '下一页';//你希望在分页中显示“下一页”链接的名字。
        $config['next_tag_open'] = '<li>';//“下一页”链接的打开标签。
        $config['next_tag_close'] = '</li>';//“下一页”链接的关闭标签。

        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config['prev_tag_open'] = '<li>';//“上一页”链接的打开标签。
        $config['prev_tag_close'] = '</li>';//“上一页”链接的关闭标签。

        $config['cur_tag_open'] = '<li class="current">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</li>';//“当前页”链接的关闭标签。

        $config['num_tag_open'] = '<li>';//“数字”链接的打开标签。
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $this->load->view('index',$data);
    }
    //输入数据
    public function InputData(){
        $buildingNumber = $_POST['buildingNumber'];
        $X = $_POST['X'];
        $Y = $_POST['Y'];
        $baidu_X = $_POST['baidu_X'];
        $baidu_Y = $_POST['baidu_Y'];
        $propertyType = $_POST['propertyType'];
        $buildingName = $_POST['buildingName'];
        $nameOfHous = $_POST['nameOfHous'];
        $admiPosition = $_POST['admiPosition'];
        $height = $_POST['height'];
        $floor = $_POST['floor'];
        $floorArea = $_POST['floorArea'];
        $constructionAge = $_POST['constructionAge'];
        $structureTypeOne = $_POST['structureTypeOne'];
        $structureTypeTwo = $_POST['structureTypeTwo'];
        $earthquakeFortification = $_POST['earthquakeFortification'];
        $siteType = $_POST['siteType'];
        $foundationType = $_POST['foundationType'];
        $baseType = $_POST['baseType'];
        $exteriorAndInterior = $_POST['exteriorAndInterior'];
        $underDisadvantage = $_POST['underDisadvantage'];
        $scatAndNotWhole = $_POST['scatAndNotWhole'];
        $britWithoutDelay = $_POST['britWithoutDelay'];
        $partAndUneven = $_POST['partAndUneven'];
        $simpButNotRedu = $_POST['simpButNotRedu'];
        $remarks = $_POST['remarks'];
        $statusEvaluation = $_POST['statusEvaluation'];
        $sixDegrEarthDam = $_POST['sixDegrEarthDam'];
        $sevenDegrEarthDam = $_POST['sevenDegrEarthDam'];
        $eightDegrEarthDam = $_POST['eightDegrEarthDam'];
        $nineDegrEarthDam = $_POST['nineDegrEarthDam'];
        $tenDegrEarthDam = $_POST['tenDegrEarthDam'];
        $predictOutcomes = $_POST['predictOutcomes'];
        $popeOrCounty = $_POST['popeOrCounty'];
        $city = $_POST['city'];
        $streetOrTown = $_POST['streetOrTown'];
        $ToOrHuOrviOrCo = $_POST['ToOrHuOrviOrCo'];
        $no = $_POST['no'];
        //把获取到的前台数据放到一个数组里，按照数组下标依次取数
        $data =[
            $buildingNumber,$X,$Y,$baidu_X,$baidu_Y,$propertyType,$buildingName,$nameOfHous,$admiPosition,$height,$floor,
            $floorArea,$constructionAge,$structureTypeOne,$structureTypeTwo,$earthquakeFortification,$siteType,
            $foundationType,$baseType,$exteriorAndInterior,$underDisadvantage,$scatAndNotWhole,$britWithoutDelay,
            $partAndUneven,$simpButNotRedu,$remarks,$statusEvaluation,$sixDegrEarthDam,$sevenDegrEarthDam,
            $eightDegrEarthDam,$nineDegrEarthDam,$tenDegrEarthDam,$predictOutcomes,$popeOrCounty,$city,$streetOrTown,
            $ToOrHuOrviOrCo,$no
        ];
        //如果不转，会有中文乱码
        switch ($data[5]) {
            case 'qljz': $table="bridge_buliding"; $data[5] = "桥梁建筑"; break;
            case 'gyjz' :  $table="industry_buliding"; $data[5] = "工业建筑"; break;
            case 'myjz' :  $table="civil_bulidling"; $data[5] = "民用建筑"; break;
            case 'ggjzw' :  $table="public_buliding"; $data[5] = "公共建筑"; break;
            case 'gsxtjz' :  $table="waterss_buliding"; $data[5] = "供水系统"; break;
            case 'grxtjz' :  $table="heatingss_buliding"; $data[5] = "供热系统"; break;
            case 'gdxtjz' :  $table="electricss_buliding"; $data[5] = "供电系统"; break;
            case 'bdzmc' :  $table="substation_name"; $data[5] = "变电站名称"; break;
            case 'trqjqz' :  $table="naturalgas_station"; $data[5] = "天然气加气站"; break;
            case 'trqmz' :  $table="naturalgasgate_statio"; $data[5] = "天然气门站"; break;
            case 'cszhy' :  $table="secondarydisaster_source"; $data[5] = "次生灾害源"; break;
            case 'xfjz' :  $table="fire_building"; $data[5] = "消防建筑"; break;
            case 'yhqgyz' :  $table="liquefiedgasss"; $data[5] = "液化气供应站"; break;
            case 'txjz' :  $table="communicationbs"; $data[5] = "通信基站"; break;
            default:  $table=null; break;
          }
        $this->Data_Model->insertToTable($data[5],$data);//基本表
        if($table){
            $this->Data_Model->insertBuildingTable($table,$data[5],$data);//具体建筑表
        }        
    }
}
