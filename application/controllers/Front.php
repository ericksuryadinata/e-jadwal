<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function index(){
        $this->load->view('index');
    }

	public function jadwal_dosen(){
        $prodi = $this->front->getAllProdi();
        if($prodi->num_rows() > 0){
            $data['jurusan'] = $prodi->result();
        }
		$this->load->view('jadwal_dosen',$data);
    }
    
    public function jadwal_tata_usaha(){
        $this->load->view('jadwal_tu');
    }

    public function bimbingan_dosen(){
        $prodi = $this->front->getAllProdi();
        if($prodi->num_rows() > 0){
            $data['jurusan'] = $prodi->result();
        }
        $this->load->view('bimbingan_dosen',$data);
    }

	public function list_jadwal(){
        $prodi = array('kode_jurusan'=>$this->security->xss_clean($this->input->post('prodi')));
        $mk = array('kode_mk'=>$this->security->xss_clean($this->input->post('mk')));
        $dosen = array('pengajar'=>$this->security->xss_clean($this->input->post('dosen')));
        $list = $this->front->get_data_jadwal($prodi, $mk, $dosen);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jadwal) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jadwal->kode_mk;
            $row[] = $jadwal->nama_mk;
            $row[] = $jadwal->kelas;
            $row[] = $jadwal->sks;
            $row[] = $jadwal->semester;
            $row[] = $jadwal->jadwal;
            $row[] = $jadwal->pengajar;
            $row[] = $jadwal->ruang;
            $row[] = $jadwal->peserta;
            $data[] = $row;
        }
        $output = array("draw"=>$_POST['draw'],
                        "recordsTotal" => $this->front->count_all_jadwal($prodi, $mk, $dosen),
                        "recordsFiltered" => $this->front->count_filtered_jadwal($prodi, $mk, $dosen),
                        "data"=>$data);
        echo json_encode($output);
    }

    public function getKuliah(){
        if($_POST){
            $prodi = $this->security->xss_clean($this->input->post('prodi'));
            $dosen = $this->front->getDosenDistinct($prodi);
            $mk = $this->front->getKuliahDistinct('tb_jadwal',array("kode_jurusan" => $prodi));
            echo json_encode(array("mk"=>$mk->result_array(),"dosen"=>$dosen->result_array()));
        }else{
            redirect('Front');
        }
    }

    public function getDosen(){
        if($_POST){
            $prodi = $this->security->xss_clean($this->input->post('prodi'));
            if($prodi === 'pd'){
                echo json_encode(null);
            }else{
                $dosen = $this->front->getDosen('tb_dosen',array('kode_dosen'=>$prodi));
                echo json_encode(array('dosen'=>$dosen->result_array()));
            }
        }else{
            redirect('front');
        }
    }

    public function list_jadwal_tu(){
        $list = $this->front->get_jadwal_tu();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jadwal_tu) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jadwal_tu->nama_jurusan;
            $row[] = $jadwal_tu->kode_tata_usaha;
            $row[] = $jadwal_tu->nama_tu;
            $hari = $jadwal_tu->hari;
            $jam = $jadwal_tu->jam;
            $row[] = $hari.', '.$jam;
            $data[] = $row;
        }
        $output = array("draw"=>$_POST['draw'],
                        "recordsTotal" => $this->front->count_all_jadwal_tu(),
                        "recordsFiltered" => $this->front->count_filtered_jadwal_tu(),
                        "data"=>$data);
        echo json_encode($output);
    }

    public function list_jadwal_bimbingan(){
        $prodi = array('jurusan'=>$this->security->xss_clean($this->input->post('prodi')));
        $dosen = array('dosen'=>$this->security->xss_clean($this->input->post('dosen')));
        $list = $this->front->get_jadwal_bimbingan($prodi,$dosen);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jadwal_bimbingan) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jadwal_bimbingan->nama_jurusan;
            $row[] = $jadwal_bimbingan->kode_dosen;
            $row[] = $jadwal_bimbingan->nama_dosen;
            $hari = $jadwal_bimbingan->hari;
            $jam = $jadwal_bimbingan->jam;
            $row[] = $hari.', '.$jam;
            $row[] = $jadwal_bimbingan->ruang;
            $data[] = $row;
        }
        $output = array("draw"=>$_POST['draw'],
                        "recordsTotal" => $this->front->count_all_jadwal_bimbingan($prodi,$dosen),
                        "recordsFiltered" => $this->front->count_filtered_jadwal_bimbingan($prodi,$dosen),
                        "data"=>$data);
        echo json_encode($output);

    }

}
