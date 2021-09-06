<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

// 사용자 인증 컨트롤러

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('auth_m');
        $this->load->helper('form');
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function index()
    {
        $this->login();
    }

    //헤더+바디+푸터
    public function _remap($method)
    {
        $this->load->view('header_v');
        if (method_exists($this, $method)) {
            $this->{"{$method}"}();
        }
        $this->load->view('footer_v');
    }

    // 회원가입
    function register()
    {
        //$this -> load->view('header_v');
        $this->load->library('form_validation');

        // email - 필수 입력, 이메일 형식, DB와 비교, 중복 여부
        $this->form_validation->set_rules('email', 'email 주소', 'required|valid_email');
        //이름 - 필수 입력, 최소 2글자, 최대 20글자
        $this->form_validation->set_rules('name', '이름', 'required|min_length[2]|max_length[12]');
        //비밀번호 - 최소 6글자, 최대 30글자, re_password 일치 여부
        $this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[20]|matches[re_password]');
        // 비밀번호 확인 - 필수항목
        $this->form_validation->set_rules('re_password', '비밀번호 확인', 'required');

        //회원가입 성공, 실패 시
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('test/forms_v');
        } else {
            $this->load->view('test/form_success_v');
        }
        //model auth_m의 add Function으로 이동
        $this->load->model('auth_m');
        $this->auth_m->add(array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'name' => $this->input->post('name')
        ));
    }

    //로그인
    public function login()
    {
        $this->load->library('form_validation');
        $this->load->helper('alert');

        //이메일,비밀번호 입력 방식 설정
        $this->form_validation->set_rules('email', '이메일', 'required|valid_email');
        $this->form_validation->set_rules('password', '비밀번호', 'required');

        echo '<meta http-equiv="Content-Type" content= "text/html; charset=utf-8" />';

        //이메일, 비밀번호 일치/불일치 시 if 문
        if ($this->form_validation->run() == TRUE) {
            $auth_data = array(
                'email' => $this->input->post('email', TRUE),
                'password' => $this->input->post('password', TRUE)
            );

            //auth_m 로그인 데이터 불러오기
            $result = $this->auth_m->login($auth_data);

            // 로그인 성공, 실패 시
            if ($result) {
                //이메일, 비밀번호가 맞는 경우 이메일 로그인 여부 세션 생성.
                $_SESSION["email"] = $result->email;
                $_SESSION["logged_in"] = TRUE;
                $_SESSION["name"] = $result->name;
                $_SESSION["mb_id"] = $result->mb_id;
                alert('로그인 되었습니다', '/bbs/index.php/board/lists/ci_board/page/1');
                exit;
            } else {
                alert('아이디나 비밀번호를 확인해주세요.', '/bbs/index.php/board/lists/ci_board/page/1');
                exit;
            }
        } else {
            $this->load->view('auth/login_v');
        }
    }

    // 로그아웃
    public function logout()
    {
        $this->load->helper('alert');
        session_destroy();
        //로그아웃 알림
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        alert('로그아웃 되었습니다.', '/bbs/index.php/board/lists/ci_board/page/1');
        exit;
    }
}