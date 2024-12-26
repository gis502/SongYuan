<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/25 0025
 * Time: 下午 3:29
 */
class intensityDrawCon extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Shelter_Moder');
        $this->load->helper('url_helper');
    }
    public function circleDraw(){
        $this->load->view('intensityShow');
    }
}