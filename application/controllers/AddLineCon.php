<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddLineCon extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('AddLine_Model');
        $this->load->helper('url_helper');
    }
    public function MapAddLine()
	{
        $data['linePoint']=$this->AddLine_Model->linePoint();
        //var_dump($data['linePoint']);
		//$this->load->view('addLine',$data);
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
	}
    public function MapLinePoints($table)
    {
        $data['linePoints']=$this->AddLine_Model->linePoints($table);
        $data['linesID']=$this->AddLine_Model->linesID($table);
        //var_dump($data['linePoint']);
        //$this->load->view('addLine',$data);

        echo json_encode($data,JSON_UNESCAPED_UNICODE);

    }
    public function AddMap()
    {
        //$data['linePoint']=$this->AddLine_Model->linePoint();
        //var_dump($data['linePoint']);
        $this->load->view('addLine');
    }
    public function AddRoodLine()
    {
        
        $this->load->view('addRoodLine');
    }
      
}
?>