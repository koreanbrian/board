<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//공통 게시판 모델
class Board_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    //리스트 불러오기
    function get_list($table = '', $type = '', $offset = '', $limit = '')
    {
        $limit_query = '';
        if ($limit != '' or $offset != '') {
            //페이징 있을 경우, 처리
            $limit_query = ' LIMIT ' . $offset . ', ' . $limit;
        }
        $sql = "SELECT subject, board_id, name, hits, ci_board.reg_date FROM ci_book.mb_info LEFT JOIN ci_board ON ci_board.member_id = mb_info.mb_id  ORDER BY board_id DESC " . $limit_query;
        $query = $this->db->query($sql);

        if ($type == 'count') {
            $result = $query->num_rows();
        } else {
            $result = $query->result(); //리턴값 : $result->board_id
        }
        return $result;
    }


    //게시물 상세보기
    //@return array
    function get_view($id)
    {
        //조회수 증가
        $updateSql = " UPDATE ci_board SET hits = hits + 1 WHERE board_id=?";
        $this->db->query($updateSql, array($id));

        $sql = "SELECT subject, board_id, name, hits, ci_board.reg_date, contents FROM ci_book.mb_info LEFT JOIN ci_board ON ci_board.member_id = mb_info.mb_id WHERE board_id = '" . $id . "'";
        $query = $this->db->query($sql);

        //게시물 내용 반환
        $result = $query->row();

        return $result;
    }

    //게시물 입력
    function insert_board($arrays)
    {
        $insert_array = array(
            'member_id' => $_SESSION["mb_id"],
            'subject' => $arrays['subject'],
            'contents' => $arrays['contents'],
            'reg_date' => date("Y-m-d H:i:s")
        );
        $result = $this->db->insert($arrays['table'], $insert_array);
        return $result;
    }

    //게시물 수정
    // array = 테이블명, 게시물 번호, 게시물 제목, 게시물 내용
    // boolean = 성공여부

    function modify_board($arrays)
    {
        $modify_array = array(
            'subject' => $arrays['subject'],
            'member_id' => $_SESSION["mb_id"],
            'contents' => $arrays['contents']
        );
        $where = array(
            'board_id' => $arrays['board_id']
        );

        // where랑 연결되는 글의 modify_array(제목, 내용)을 업데이트하는 것
        $result = $this->db->update($arrays['table'], $modify_array, $where);
        return $result;
    }

    function writer_check()
    {
        $board_id = $this->uri->segment(5);
        $sql = "SELECT email FROM ci_book.mb_info LEFT JOIN ci_board ON ci_board.member_id = mb_info.mb_id WHERE board_id = '" . $board_id . "'";
        $query = $this->db->query($sql);

        return $query->row();
    }

    //게시글 삭제
    function delete_content($table, $no)
    {
        $delete_array = array(
            'board_id' => $no
        );
        $result = $this->db->delete('ci_board', $delete_array);
        return $result;

    }
}