<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MP_Back extends CI_Controller {

    /** 
     *  jadwal dosen 
    **/

	public function index(){
		$data['pesan'] = $this->session->userdata('p');
		$this->load->view('App/index',$data);
        $this->load->view('App/Jadwal');
        $this->load->view('App/Footer');
    }

	public function upload_excel_jadwal(){
        if( !isset($_FILES['file']['name']) || empty($_FILES['file']['name'])){
            $this->session->set_flashdata("p",'<script>swal("Error", "File Belum Dipilih", "error")</script>');
            redirect('MP_Back');
        }else{
            $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
            $id = 'jadwal.'.$ext;
            //$id = preg_replace('/\s+/', '_', $_FILES['file']['name']);
            $fileName = date('Y_m_d_His').'_JD_'.$id;
            $config['upload_path'] = 'application/uploads/excel/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'ods|xls|xlsx|csv';
            $config['max_size'] = 10000;
             
            $this->upload->initialize($config);
             
            if(! $this->upload->do_upload('file') ){
                $this->upload->display_errors();
                $this->session->set_flashdata("p",'<script>swal("Error", "Extensi file salah", "error")</script>');
                redirect('MP_Back');
            }
                 
            $media = $this->upload->data('file');
            //$inputFileName = APPPATH.'uploads\excel\\'.$fileName; //for windows only
            $inputFileName = APPPATH.'uploads/excel/'.$fileName; // linux
        
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                                                 
                //Sesuaikan sama nama kolom tabel di database                                
                 $data = array(
                    "kode_jurusan"=> $rowData[0][0],
                    "kode_mk"=> $rowData[0][1],
                    "nama_mk"=> strtoupper($rowData[0][2]),
                    "kelas"=> strtoupper($rowData[0][3]),
                    "sks"=> $rowData[0][4],
                    "semester"=> $rowData[0][5],
                    "jadwal"=> $rowData[0][6],
                    "pengajar"=> $rowData[0][7],
                    "ruang"=> strtoupper($rowData[0][8]),
                    "peserta"=> $rowData[0][9]
                );
                 
                //sesuaikan nama dengan nama tabel
                $insert = $this->db->insert("tb_jadwal",$data);
                delete_files($media['file_path']);  
            }
            if($insert){
                $this->session->set_flashdata("p",'<script>swal("Sukses", "Berhasil upload", "success")</script>');
                redirect('MP_Back');
            } else {
                $this->session->set_flashdata("p",'<script>swal("Error", "Gagal Upload", "error")</script>');
                redirect('MP_Back');
            }
        }
    }

    public function list_jadwal(){
        $list = $this->mp->get_data_jadwal();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jadwal) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jadwal->kode_jurusan;
            $row[] = $jadwal->nama_jurusan;
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
                        "recordsTotal" => $this->mp->count_all_jadwal(),
                        "recordsFiltered" => $this->mp->count_filtered_jadwal(),
                        "data"=>$data);
        echo json_encode($output);
    }

    /** 
     *  jadwal tata usaha
    **/
    
    public function jadwal_tu(){
        $data['pesan'] = $this->session->userdata('p');
        $prodi = $this->mp->getAllProdi();
        if($prodi->num_rows() > 0){
            $data['jurusan'] = $prodi->result();
        }
        $this->load->view('App/index',$data);
        $this->load->view('App/Jadwal_tu');
        $this->load->view('App/Footer');
    }

    public function upload_excel_tu(){
        if( !isset($_FILES['file']['name']) || empty($_FILES['file']['name'])){
            $this->session->set_flashdata("p",'<script>swal("Error", "File Belum Dipilih", "error")</script>');
            redirect('MP_Back/jadwal_tu');
        }else{
            $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
            $id = 'jadwal_tu.'.$ext;
            //$id = preg_replace('/\s+/', '_', $_FILES['file']['name']);
            $fileName = date('Y_m_d_His').'_TU_'.$id;
            $config['upload_path'] = 'application/uploads/excel/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'ods|xls|xlsx|csv';
            $config['max_size'] = 10000;
             
            $this->upload->initialize($config);
             
            if(! $this->upload->do_upload('file') ){
                $this->upload->display_errors();
                $this->session->set_flashdata("p",'<script>swal("Error", "Extensi file salah", "error")</script>');
                redirect('MP_Back/jadwal_tu');
            }
                 
            $media = $this->upload->data('file');
            //$inputFileName = APPPATH.'uploads\excel\\'.$fileName; //windows
            $inputFileName = APPPATH.'uploads/excel/'.$fileName; //linux
        
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                                                 
                //Sesuaikan sama nama kolom tabel di database                                
                $data = array(
                    "fakjur"=> $rowData[0][0],
                    "kode_tata_usaha"=> $rowData[0][1],
                    "hari"=> $rowData[0][2],
                    "jam"=> $rowData[0][3],
                    "tahun_ajaran" => $rowData[0][4]
                );
                 
                //sesuaikan nama dengan nama tabel
                $insert = $this->db->insert("tb_jadwal_tu",$data);
                delete_files($media['file_path']);  
            }
            if($insert){
                $this->session->set_flashdata("p",'<script>swal("Sukses", "Berhasil upload", "success")</script>');
                redirect('MP_Back/jadwal_tu');
            } else {
                $this->session->set_flashdata("p",'<script>swal("Error", "Gagal Upload", "error")</script>');
                redirect('MP_Back/jadwal_tu');
            }
        }
    }

    public function list_jadwal_tu(){
        $list = $this->mp->get_jadwal_tu();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jadwal_tu) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $jadwal_tu->fakjur;
            $row[] = $jadwal_tu->nama_jurusan;
            $row[] = $jadwal_tu->kode_tata_usaha;
            $row[] = $jadwal_tu->nama_tu;
            $hari = $jadwal_tu->hari;
            $jam = $jadwal_tu->jam;
            $row[] = $hari.', '.$jam;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="update_jadwal_tu('."'".$jadwal_tu->id_jadwal_tu."'".')"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_jadwal_tu('."'".$jadwal_tu->id_jadwal_tu."'".')"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</a>';
            $data[] = $row;
        }
        $output = array("draw"=>$_POST['draw'],
                        "recordsTotal" => $this->mp->count_all_jadwal_tu(),
                        "recordsFiltered" => $this->mp->count_filtered_jadwal_tu(),
                        "data"=>$data);
        echo json_encode($output);
    }
    
    public function kode_tu(){
        if($_POST){
            $kd = $this->security->xss_clean($this->input->post('prodi'));
            $kodetu = array('kode_tu'=>$kd);
            $q = $this->mp->ambil_like('tb_tatausaha',$kodetu,false,'after');
            if($q->num_rows() > 0 ){
                echo json_encode($q->result_array());
            }else{
                echo json_encode(null);
            }
        }else{
            redirect('MP_Back');
        }
    }

    public function tambah_jadwal_tu(){
        if($_POST){
            $data = array('fakjur'=>$this->security->xss_clean($this->input->post('prodi')),'kode_tata_usaha'=>$this->security->xss_clean($this->input->post('kodetu')),'hari'=>$this->security->xss_clean($this->input->post('hari')),
            'jam'=>$this->security->xss_clean($this->input->post('jam')),
            );
            $insert = $this->mp->tambah_data('tb_jadwal_tu',$data);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    public function update_jadwal_tu(){
        if($_POST){
            $data = array('fakjur'=>$this->security->xss_clean($this->input->post('prodi')),'kode_tata_usaha'=>$this->security->xss_clean($this->input->post('kodetu')),'hari'=>$this->security->xss_clean($this->input->post('hari')),
            'jam'=>$this->security->xss_clean($this->input->post('jam')),
            );
            $where = array('id_jadwal_tu'=>$this->security->xss_clean($this->input->post('val')));
            $update = $this->mp->update_tu($where,$data);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    public function edit_jadwal_tu(){
        if($_POST){
            $id = $this->security->xss_clean($this->input->post('id_jadwal'));
            $data = $this->mp->get_by_tu($id);
            $kd = $data->fakjur;
            $kodetu = array('kode_tu'=>$kd);
            $q = $this->mp->ambil_like('tb_tatausaha',$kodetu,false,'after');
            echo json_encode(array("edit"=>$data,"tu"=>$q->result_array()));    
        } else {
            redirect('MP_Back');
        }
    }

    public function hapus_jadwal_tu()
    {
        if($_POST){
            $id = array('id_jadwal_tu'=>$this->security->xss_clean($this->input->post('id_jadwal')));
            $this->mp->delete('tb_jadwal_tu',$id);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }


    /** 
     *  jadwal bimbingan dosen
    **/

    public function jadwal_bimbingan(){
        $data['pesan'] = $this->session->userdata('p');
        $prodi = $this->mp->getAllProdi();
        if($prodi->num_rows() > 0){
            $data['jurusan'] = $prodi->result();
        }
        $this->load->view('App/index',$data);
        $this->load->view('App/Jadwal_bimbingan');
        $this->load->view('App/Footer');
    }

    public function kode_dosen(){
        if($_POST){
            $kd = $this->security->xss_clean($this->input->post('kodedosen'));
            $kodedosen = array('kode_dosen'=>$kd);
            $q = $this->mp->ambil_satu('tb_dosen',$kodedosen);
            if($q->num_rows() > 0 ){
                echo json_encode($q->result());
            }else{
                echo json_encode(null);
            }
        }else{
            redirect('MP_Back');
        }
        
    }

    public function getDosen(){
        if($_POST){
            $prodi = $this->security->xss_clean($this->input->post('prodi'));
            $kodedosen = array('kode_dosen'=>$kd);
            $q = $this->mp->ambil_like('tb_dosen',$kodedosen,false,'both');
            if($q->num_rows() > 0 ){
                echo json_encode($q->result());
            }else{
                echo json_encode(null);
            }
        }else{
            redirect('MP_Back');
        }
    }

    public function list_jadwal_bimbingan(){
        $list = $this->mp->get_jadwal_bimbingan();
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
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="update_bimbingan('."'".$jadwal_bimbingan->id_jadwal_bimbingan."'".')"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_bimbingan('."'".$jadwal_bimbingan->id_jadwal_bimbingan."'".')"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</a>';
            $data[] = $row;
        }
        $output = array("draw"=>$_POST['draw'],
                        "recordsTotal" => $this->mp->count_all_jadwal_bimbingan(),
                        "recordsFiltered" => $this->mp->count_filtered_jadwal_bimbingan(),
                        "data"=>$data);
        echo json_encode($output);

    }

    public function tambah_bimbingan(){
        if($_POST){
            $data = array('jurusan'=>$this->security->xss_clean($this->input->post('prodi')),'dosen'=>$this->security->xss_clean($this->input->post('kodedosen')),'hari'=>$this->security->xss_clean($this->input->post('hari')),
            'jam'=>$this->security->xss_clean($this->input->post('jam')),
            'ruang'=>$this->security->xss_clean($this->input->post('ruang'))
            );
            $insert = $this->mp->tambah_data('tb_jadwal_bimbingan',$data);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    public function update_bimbingan(){
        if($_POST){
            $data = array('jurusan'=>$this->security->xss_clean($this->input->post('prodi')),'dosen'=>$this->security->xss_clean($this->input->post('kodedosen')),'hari'=>$this->security->xss_clean($this->input->post('hari')),
            'jam'=>$this->security->xss_clean($this->input->post('jam')),
            'ruang'=>$this->security->xss_clean($this->input->post('ruang'))
            );
            $where = array('id_jadwal_bimbingan'=>$this->security->xss_clean($this->input->post('val')));
            $update = $this->mp->update_bimbingan($where,$data);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    public function edit_bimbingan(){
        if($_POST){
            $id = $this->security->xss_clean($this->input->post('id_jadwal'));
            $data = $this->mp->get_by_bimbingan($id);
            echo json_encode($data);    
        } else {
            redirect('MP_Back');
        }
    }

    public function hapus_bimbingan()
    {
        if($_POST){
            $id = array('id_jadwal_bimbingan'=>$this->security->xss_clean($this->input->post('id_bimbingan')));
            $this->mp->delete('tb_jadwal_bimbingan',$id);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    /**
     * data dosen
     */

    public function upload_excel_dosen(){
        if( !isset($_FILES['file']['name']) || empty($_FILES['file']['name'])){
            $this->session->set_flashdata("p",'<script>swal("Error", "File Belum Dipilih", "error")</script>');
            redirect('MP_Back');
        }else{
            $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
            $id = 'data_dosen.'.$ext;
            //$id = preg_replace('/\s+/', '_', $_FILES['file']['name']);
            $fileName = date('Y_m_d_His').'_TU_'.$id;
            $config['upload_path'] = 'application/uploads/excel/';
            $config['file_name'] = $fileName;
            $config['allowed_types'] = 'ods|xls|xlsx|csv';
            $config['max_size'] = 10000;
             
            $this->upload->initialize($config);
             
            if(! $this->upload->do_upload('file') ){
                $this->upload->display_errors();
                $this->session->set_flashdata("p",'<script>swal("Error", "Extensi file salah", "error")</script>');
                redirect('MP_Back');
            }
                 
            $media = $this->upload->data('file');
            //$inputFileName = APPPATH.'uploads\excel\\'.$fileName; //windows
            $inputFileName = APPPATH.'uploads/excel/'.$fileName; //linux
        
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                                                 
                //Sesuaikan sama nama kolom tabel di database                                
                 $data = array(
                    "fakjur"=> $rowData[0][0],
                    "nip"=> $rowData[0][1],
                    "kode_dosen"=> $rowData[0][2],
                    "nama_dosen"=> $rowData[0][3],
                    "telepon"=> $rowData[0][4]
                );
                 
                //sesuaikan nama dengan nama tabel
                $insert = $this->db->insert("tb_dosen",$data);
                delete_files($media['full_path']);
            }
            if($insert){
                $this->session->set_flashdata("p",'<script>swal("Sukses", "Berhasil upload", "success")</script>');
                redirect('MP_Back/data_dosen');
            } else {
                $this->session->set_flashdata("p",'<script>swal("Error", "Gagal Upload", "error")</script>');
                redirect('MP_Back/data_dosen');
            }
        }
    }

    public function data_dosen(){
        $prodi = $this->mp->getAllProdi();
        if($prodi->num_rows() > 0){
            $data['jurusan'] = $prodi->result();
        }
        $data['pesan'] = $this->session->userdata('p');
        $this->load->view('App/index',$data);
        $this->load->view('App/Data_dosen');
        $this->load->view('App/Footer');
    }

    public function list_data_dosen(){
        $list = $this->mp->get_data_dosen();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $data_dosen) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_dosen->nama_jurusan;
            $row[] = $data_dosen->nip;
            $row[] = $data_dosen->kode_dosen;
            $row[] = $data_dosen->nama_dosen;
            $row[] = $data_dosen->telepon;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="update_dosen('."'".$data_dosen->id_dosen."'".')"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_dosen('."'".$data_dosen->id_dosen."'".')"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</a>';
            $data[] = $row;
        }
        $output = array("draw"=>$_POST['draw'],
                        "recordsTotal" => $this->mp->count_all_data_dosen(),
                        "recordsFiltered" => $this->mp->count_filtered_data_dosen(),
                        "data"=>$data);
        echo json_encode($output);

    }

    public function tambah_data_dosen(){
        if($_POST){
            $data = array('fakjur'=>$this->security->xss_clean($this->input->post('prodi')),
                'nip'=>$this->security->xss_clean($this->input->post('nip')),'kode_dosen'=>$this->security->xss_clean($this->input->post('kodedosen')),'nama_dosen'=>$this->security->xss_clean($this->input->post('namadosen')),
                'telepon'=>$this->security->xss_clean($this->input->post('telepon'))
            );
            $insert = $this->mp->tambah_data('tb_dosen',$data);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    public function update_data_dosen(){
        if($_POST){
            $data = array('fakjur'=>$this->security->xss_clean($this->input->post('prodi')),
                'nip'=>$this->security->xss_clean($this->input->post('nip')),'kode_dosen'=>$this->security->xss_clean($this->input->post('kodedosen')),'nama_dosen'=>$this->security->xss_clean($this->input->post('namadosen')),
                'telepon'=>$this->security->xss_clean($this->input->post('telepon'))
            );
            $where = array('id_dosen'=>$this->security->xss_clean($this->input->post('val')));
            $update = $this->mp->update_data_dosen($where,$data);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    public function edit_data_dosen(){
        if($_POST){
            $id = $this->security->xss_clean($this->input->post('id_dosen'));
            $data = $this->mp->get_by_dosen($id);
            echo json_encode($data);    
        } else {
            redirect('MP_Back');
        }
    }

    public function hapus_data_dosen(){
        if($_POST){
            $id = array('id_dosen'=>$this->security->xss_clean($this->input->post('id_dosen')));
            $this->mp->delete('tb_dosen',$id);
            echo json_encode(array('status'=>TRUE));
        }else{
            redirect('MP_Back');
        }
    }

    /**
     * Pengumuman
     */

    public function pengumuman(){
        $data['pesan'] = $this->session->userdata('p');
        $this->load->view('App/index',$data);
        $this->load->view('App/Pengumuman');
        $this->load->view('App/Footer');
    }

    public function list_pengumuman(){
        $list = $this->mp->get_pengumuman();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pengumuman) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pengumuman->nm_pengumuman;
            $row[] = $pengumuman->tgl_mulai;
            $row[] = $pengumuman->tgl_selesai;
            $row[] = $pengumuman->nm_gambar;
            if($pengumuman->status === '1'){
                $row[] = 'Aktif';
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="update_pengumuman('."'".$pengumuman->id_pengumuman."'".')"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_pengumuman('."'".$pengumuman->id_pengumuman."'".')"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</a> <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Aktifkan" onclick="aktifkan_pengumuman('."'".$pengumuman->id_pengumuman."','Aktifkan'".')"><i class="glyphicon glyphicon-ok-circle"></i> Aktifkan</a>';
            }else{
                $row[] = 'Aktif';
                $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="update_pengumuman('."'".$pengumuman->id_pengumuman."'".')"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_pengumuman('."'".$pengumuman->id_pengumuman."'".')"><i class="glyphicon glyphicon-trash"></i>&nbsp;Delete</a> <a class="btn btn-sm btn-default" href="javascript:void(0)" title="Non Aktifkan" onclick="aktifkan_pengumuman('."'".$pengumuman->id_pengumuman."','Non Aktifkan'".')"><i class="glyphicon glyphicon-ban-circle"></i> Non Aktifkan</a>';

            }
            $data[] = $row;
        }
        $output = array("draw"=>$_POST['draw'],
                        "recordsTotal" => $this->mp->count_all_pengumuman(),
                        "recordsFiltered" => $this->mp->count_filtered_pengumuman(),
                        "data"=>$data);
        echo json_encode($output);

    }
}

/* End of file MP_Back.php */
/* Location: ./application/controllers/MP_Back.php */