<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function gets()
    {
        return $this->db->query("SELECT * FROM mb_info")->result();
    }

    function get($option)
    {
        $result = $this->db->get_where('mb_info', array('email' => $option['email']))->row();

        return $result;
    }

    // 회원가입 정보 DB로 이동
    function add($option)
    {
        $this->db->set('email', $option['email']);
        $this->db->set('password', $option['password']);
        $this->db->set('name', $option['name']);
        $this->db->set('reg_date', 'NOW()', false);
        $this->db->insert('mb_info');
        $result = $this->db->insert_id();
        return $result;
    }


    // 아이디 비밀번호 체크 + 세션 정보 저장
    function login($auth)
    {
        $sql = "SELECT mb_id,name, email FROM mb_info WHERE email = '" . $auth['email'] . "' AND password = '" . $auth['password'] . "' ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

}