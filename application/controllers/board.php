<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

// 게시판 메인 컨트롤러
class Board extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('board_m');
        $this->load->helper(array('url', 'date', 'alert'));
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    //주소 생략시 실행되는 기본 index 매서드
    // echo 'lists' 에서 $this-> lists 로 바뀜
    public function index()
    {
        $this->lists();
    }

    //사이트 헤더 및 푸터 자동 추가
    public function _remap($method)
    {
        // header included
        $this->load->view('header_v');

        if (method_exists($this, $method)) {
            $this->{"{$method}"}();
        }
        //footer include
        $this->load->view('footer_v');

    }

    //url 중 키 값 구분하여 값 가져오도록
    //$url : segment_explode 한 url 값, $key : 가져오려는 값의 key, @return String $url[$k] : 리턴값
    function url_explode($url, $key)
    {
        $return_value = "";
        // 09999
        $cnt = count($url);

        for ($i = 0; $cnt > $i; $i++) {
            if ($url[$i] == $key) {
                $k = $i;
                $return_value = $url[$k];
                break;
            }
        }
        return $return_value;
    }

    //URL의 "/"를 delimiter로 사용, 배열로 바꿔 리턴
    function segment_explode($seg)
    {
        // 세그먼트 앞 뒤 "/" 제거 후 uri를 배열로 반환
        $len = strlen($seg);

        if (substr($seg, 0, 1) == '/') {
            $seg = substr($seg, 1, $len);
        }

        $len = strlen($seg);

        if (substr($seg, -1) == '/') {
            $seg = substr($seg, 0, $len - 1);
        }

        $seg_exp = explode("/", $seg);

        return $seg_exp;
    }

    //목록 불러오기
    public function lists()
    {

        //페이지네이션 라이브러리 로딩
        $this->load->library('pagination');

        //페이징 주소 $config 배열에는 설정값들이 들어감.
        //index.php 뒤 부터 1~n 값
        // segment(1)은 index.php 다음부터 시작
        $config['base_url'] = '/bbs/index.php/board/lists/ci_board/page';
        $uri_array = $this->segment_explode($this->uri->uri_string());
        $config['total_rows'] = $this->board_m->get_list('ci_board', 'count'); //게시물 전체 갯수 (ci_board 데이터 갯수 카운트)
        $config['per_page'] = 5; //한 페이지에 표시할 게시물 수
        $config['uri_segment'] = 5; //페이지 번호가 위치한 세그먼트 => segment(5)

        //페이지네이션 초기화
        $this->pagination->initialize($config);
        //페이지 링크를 생성하여 view에서 사용할 변수에 할당
        $data['pagination'] = $this->pagination->create_links();

        //게시물 목록을 불러오기 위한 offset,limit 값 가져오기
        // segment(5) 값이 false일 경우, return 1
        $page = $this->uri->segment(5, 1);

        if ($page > 1) {
            $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
            $start = ($page - 1) * $config['per_page'];
        }

        $limit = $config['per_page'];

        $data['list'] = $this->board_m->get_list($this->uri->segment(3), '', $start, $limit);
        $this->load->view('board/list_v', $data);
    }

    function view()
    {
        // 게시판 이름과 게시물 번호에 해당하는 게시물 가져오기
        $data["views"] = $this->board_m->get_view($this->uri->segment(4));

        // view 호출
        $this->load->view('board/view_v', $data);
    }

    //글 작성
    function write()
    {
        //form validation & helper 라이브러리
        $this->load->library('form_validation');
        $this->load->helper('alert');

        echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';

        if ($_SESSION["logged_in"] == TRUE) {

            // 폼 규칙 정의
            $this->form_validation->set_rules('subject', '제목', 'required');
            $this->form_validation->set_rules('contents', '내용', 'required');

            //글 전송 POST
            if ($this->form_validation->run() == TRUE) {

                $uri_array = $this->segment_explode($this->uri->uri_string());

                if (in_array('page', $uri_array)) {
                    $pages = urldecode($this->url_explode($uri_array, 'page'));
                } else {
                    $pages = 1;
                }

                //글 내용이 없을경우 프로그램 단에서 다시 체크
                if (!$this->input->post('subject', TRUE) and !$this->input->post('contents', TRUE)) {
                    alert('비정상적인 접근입니다.', '/bbs/index.php/board/lists/ci_board/page/' . $pages);
                    exit;
                }

                $write_data = array(
                    'subject' => $this->input->post('subject', TRUE),
                    'contents' => $this->input->post('contents', TRUE),
                    'email' => $_SESSION["email"],
                    'name' => $_SESSION["name"],
                    'member_id' => $_SESSION["mb_id"],
                    'table' => 'ci_board'
                );

                $result = $this->board_m->insert_board($write_data);

                if ($result) {
                    alert("입력되었습니다.", '/bbs/index.php/board/lists/ci_board/page/' . $pages);
                    exit;
                } else {
                    alert("다시 입력해주세요.", '/bbs/index.php/board/lists/ci_board/page/' . $pages);
                    exit;
                }
            } else {
                $this->load->view('board/write_v');
            }
        } else {
            alert('로그인 후 작성하세요', '/bbs/index.php/auth/login/');
            exit;
        }
    }

    // 글 수정 - view
    function modify()
    {
        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $uri_array = $this->segment_explode($this->uri->uri_string());

        //글 전송 POST

        if (in_array('page', $uri_array)) {
            $pages = urldecode($this->url_explode($uri_array, 'page'));
        } else {
            $pages = 1;
        }
        if (@$_SESSION["logged_in"] == TRUE) {
            $write_id = $this->board_m->writer_check();
            if (@$write_id->email != $_SESSION["email"]) {
                alert('본인이 작성한 글이 아닙니다.', '/bbs/index.php/board/lists/ci_board/page/' . $pages);
                exit;
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('subject', '제목', 'required');
            $this->form_validation->set_rules('contents', '내용', 'required');

            if ($this->form_validation->run() == TRUE) {
                if (!$this->input->post('subject', TRUE) and !$this->input - post('contents', TRUE)) {
                    alert('비정상적인 접근.', '/bbs/index.php/board/lists/ci_board/page/' . $pages);
                    exit;
                }
                $modify_data = array(
                    'table' => 'ci_board',
                    'board_id' => $this->uri->segment(5),
                    'subject' => $this->input->post('subject', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'contents' => $this->input->post('contents', TRUE)

                );

                $result = $this->board_m->modify_board($modify_data);
                if ($result) {
                    echo "수정 완료";
                    echo '<br><a href="/bbs/index.php/board/view/page/' . $this->uri->segment(5) . '" class="btn btn-primary">수정된 글 보기</a>';
                    exit;
                } else {
                    echo "수정 불가, 다시 수정해주세요.";
                    echo '<br><a href="/bbs/index.php/board/view/page/' . $this->uri->segment(5) . '" class="btn btn-primary">이전으로가기</a>';
                    exit;
                }
            } else {
                $data['views'] = $this->board_m->get_view($this->uri->segment(5));
                $this->load->view('board/modify_v', $data);
            }
        } else {
            alert('로그인 후 수정하세요.', '/bbs/index.php/auth/login/');
            exit;
        }
    }

    //글 삭제
    function delete()
    {
        $this->load->helper('alert');
        echo '<meta http-equiv="Content_Type" content = "text/html; charset = utf-8" />';

        if (@$_SESSION["logged_in"] == TRUE) {
            $write_id = $this->board_m->writer_check();
            if ($write_id->email != $_SESSION["email"]) {
                alert('본인이 작성한 글이 아닙니다.', '/bbs/index.php/board/');
                exit;
            }

            $return = $this->board_m->delete_content('ci_board', $this->uri->segment(5));
            if ($return) {
                echo "삭제 완료";
                echo '<br><a href="/bbs/index.php/board/" class="btn btn-primary">목록 </a>';
                exit;
            } else {
                echo "삭제 실패";
                echo '<br><a href="/bbs/index.php/board/view/ci_board/board_id/' . $this->uri->segment(5) . '" class="btn btn-primary">이전으로가기</a>';
                exit;
            }
        } else {
            alert('로그인 후 삭제하세요.', '/bbs/index.php/auth/login/');
            exit;
        }
    }
}
