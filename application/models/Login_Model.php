<?php
class Login_Model extends CI_Model{
    public function __construct()
    {
        $this->load->database();//连接数据库
    }
    public function loginSelect($userName,$passWord){

        $sql="SELECT * FROM adminPower WHERE binary userName='$userName' AND binary userPassword='$passWord'";
        $result = $this->db->query($sql);
        //var_dump($result);
        return $result->result_array();
    }
    public function checkAdminPower(){
        $sql="SELECT * FROM adminPower WHERE userPower='2'";
        $result = $this->db->query($sql);
        //var_dump($result);
        return $result->result_array();
    }
    public function insertToTable($userName,$passWord){
        $power=2;
        $sql="INSERT INTO adminPower (userName,userPassword,userPower)VALUES('$userName','$passWord','$power')";
        $this->db->query($sql);
    }
    public function deleteToTable($id){
        $sql="DELETE FROM adminPower WHERE userID = $id";
        $this->db->query($sql);
    }
    public function checkUser($power){
        $sql="SELECT * FROM adminPower WHERE userID='$power'";
        $result = $this->db->query($sql);
        //var_dump($result);
        return $result->result_array();
    }
    public function page($tablename,$per_nums,$start_position){
        $this->db->limit($per_nums,$start_position);
        $query=$this->db->get($tablename);
        $data=$query->result();
        $data2['total_nums']=$this->db->count_all($tablename);
        $data2[]=$data; //这里大家可能看的优点不明白，可以分别将$data和$data2打印出来看看是什么结果。
        return $data2;
    }

}