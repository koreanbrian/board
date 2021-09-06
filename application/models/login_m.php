<?php
class User_model extends CI_model {
    // 회원 정보 모델 생성 USER_MODEL

    function __construct()
    {
        parent::__contstruct();
    }
    function gets(){
        return $this->db->query("SELECT * FROM mb_info")->result();
    }

    function get($option){
        $result =$this->db->get_where('user',array('email'=>$option['email']))->row();
        var_dump($this->db->last_query());
        return $result;
    }


    function add($option)
    {
        $this->db->set('email',$option['email']);
        $this->db->set('password',$option['password']);
        $this->db->set('created','NOW()',false);
        $this->db->insert('user');
        $result=$this->db->insert_id();
        return $result;
    }
}