<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('PHPExcel');
	}

	public function is_login(){
		if($this->session->userdata('logged_in') === FALSE || empty($this->session->userdata('logged_in'))) {
			$this->session->set_flashdata("pesan",'<script>$(document).ready(function(){swal("Oopss..", "Sesi habis, Silakan Login Lagi", "warning");});</script>');
            redirect('MP');
		}
	}

	public function is_home(){
		 if($this->session->userdata('logged_in') === TRUE) {
            redirect('MP/cek_tipe');
        }
	}

	public function valid($data){
		foreach ($data as $key) {
			$this->form_validation->set_rules($key, $key, 'required');
		}

		if(!$this->form_validation->run()){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	

}
