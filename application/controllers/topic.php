<?php
if (!definded('BASEPATH')) exit('No direct script access allowed');

class Topic extends CI_Controller
{ // Topic 이라는 컨트롤러

    public function index()
    {
        $this->load->database();
        $this->load->view('head');
        $this->load->view('topic');
        $this->load->view('footer');
    }

}