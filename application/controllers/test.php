<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 테스트용 컨트롤러

class Test extends CI_Controller {

    function __construct(){
        parent::__construct();
        if (!isset($_SESSION)) {
            session_start();
        }

    }
    public function index(){
        $this->forms();
    }
    public function _remap($method){
        $this->load->view('header_v');

        if (method_exists($this, $method)) {
            $this -> {"{$method}"}();
        }

        $this->load->view('footer_v');
    }

    //폼 검증 테스트

    public function forms()
    {
        //Form validation 라이브러리 로드
        $this->load->library('form_validation');
        $this->load->helper('alert');

        // 변수 앞 "@"은 관련 에러를 무시함
        if(@$_SESSION["logged_in"] == TRUE){
            alert('이미 로그인 되어있습니다.', '/bbs/index.php/board/lists/ci_board/page/' );
        } else{

        //검증 규칙 설명

        // email - 필수 입력, 이메일 형식, DB와 비교, 중복 여부
        $this->form_validation->set_rules('email', 'email 주소', 'required|valid_email|callback_email_check');
        //이름 - 필수 입력, 최소 2글자, 최대 20글자
        $this->form_validation->set_rules('name', '이름', 'required|min_length[2]|max_length[12]');
        //비밀번호 - 최소 6글자, 최대 30글자, re_password 일치 여부
        $this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[20]|matches[re_password]');
        // 비밀번호 확인 - 필수항목
        $this->form_validation->set_rules('re_password', '비밀번호 확인', 'required');

            //회원가입 성공, 실패 시
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('/test/forms_v');
        } else {
            $this->load->model('auth_m');
            $this->auth_m->add(array
                (
                    'email'=>$this->input->post('email'),
                    'password'=>$this->input->post('password'),
                    'name'=>$this->input->post('name')
                )
            );
            $this->load->view('/test/form_success_v');
        }
        }
    }

    public function email_check($email)
    {
        $this->load->database();

        if ($email) {
            $result = array();
            $sql = "SELECT * FROM mb_info WHERE email = '" . $email . "'";
            $query = $this->db->query($sql);
            $result = @$query->row();

            if ($result) {
                $this->form_validation->set_message('email_check' . $email . '은 중복된 email 입니다.');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }


    public function name_check($login_email)
{
    $this->load->database();

    if ($login_email) {
        $result = array();
        $sql = "SELECT name FROM mb_info WHERE email ='" . $login_email . "'";
        $query = $this->db->query($sql);
        $result = $query->row();

        return $result;
    }
}
}