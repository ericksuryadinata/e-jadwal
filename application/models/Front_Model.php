<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front_Model extends CI_Model {
	private $table_jadwal = 'tb_jadwal';
	private $column_order_jadwal = array(null,'kode_mk','nama_mk','kelas','sks','semester','jadwal','pengajar','ruang','peserta');
	private $column_search_jadwal = array('kode_mk','nama_mk','kelas','sks','semester','jadwal','pengajar','ruang','peserta');
	private $order_by_jadwal = array('kode_jurusan'=>'asc');

	private $table_jadwal_tu = 'tb_jadwal_tu';
	private $column_order_jadwal_tu = array(null,'nama_jurusan','kode_tata_usaha','nama_tu');
	private $column_search_jadwal_tu = array('nama_jurusan','kode_tata_usaha','nama_tu');
	private $order_by_jadwal_tu = array('fakjur'=>'asc');

	private $table_jadwal_bimbingan = 'tb_jadwal_bimbingan';
	private $column_order_jadwal_bimbingan = array(null, 'jurusan','nama_jurusan','dosen','nama_dosen');
	private $column_search_jadwal_bimbingan = array('jurusan','nama_jurusan','dosen','nama_dosen');
	private $order_by_jadwal_bimbingan = array('jurusan'=>'asc');

	private $table_dosen = 'tb_dosen';
	private $column_order_dosen = array(null, 'fakjur','nip','kode_dosen','nama_dosen','telepon');
	private $column_search_dosen = array('fakjur','nip','kode_dosen','nama_dosen','telepon');
	private $order_by_dosen = array('kode_dosen'=>'asc');
	
	public function getKuliahDistinct($tabel,$param = null){
		$this->db->select('kode_mk, nama_mk');
		$this->db->distinct();
		$this->db->from($tabel);
		$this->db->where($param);
		$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		return $this->db->get();
	}

	public function getDosenDistinct($id){
		if($id === 'pd'){
			return $this->db->query("SELECT DISTINCT pengajar FROM (SELECT DISTINCT pengajar FROM tb_jadwal WHERE kode_jurusan = '' AND tahun_ajaran = (SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ) AS p ");	
		}else{
			return $this->db->query("SELECT DISTINCT pengajar FROM (SELECT DISTINCT pengajar FROM tb_jadwal WHERE kode_jurusan = $id AND tahun_ajaran = (SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ) AS p ");	
		}
	}

	public function getDosen($table,$where = null){
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

	public function getWhere($table,$where = null){
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

	public function getAllProdi(){
		return $this->db->get('tb_jurusan');
	}

	private function _get_jadwal($prodi = null, $mk = null, $dosen = null){
		$this->db->from($this->table_jadwal);
		if($prodi['kode_jurusan'] !== 'pd' && $mk['kode_mk'] !== 'mk' && $dosen['pengajar'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($mk);
			$this->db->where($dosen);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['kode_jurusan'] !== 'pd' && $mk['kode_mk'] !== 'mk'){
			$this->db->where($prodi);
			$this->db->where($mk);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['kode_jurusan'] !== 'pd' && $dosen['pengajar'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($dosen);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['kode_jurusan'] !== 'pd'){
			$this->db->where($prodi);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}else{
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}
		$i=0;
		foreach ($this->column_search_jadwal as $item) {
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item,$_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_jadwal) - 1 == $i){
					$this->db->group_end();
				}
			}
			$i++;
		}

		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order_jadwal[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
		} elseif (isset($this->order_by_jadwal)) {
			$order = $this->order_by_jadwal;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_data_jadwal($prodi = null, $mk = null, $dosen = null){
		$this->_get_jadwal($prodi, $mk, $dosen);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_jadwal($prodi = null, $mk = null, $dosen = null){
		$this->_get_jadwal($prodi, $mk, $dosen);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_jadwal($prodi = null, $mk = null, $dosen = null){
		$this->db->from($this->table_jadwal);
		if($prodi['kode_jurusan'] !== 'pd' && $mk['kode_mk'] !== 'mk' && $dosen['pengajar'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($mk);
			$this->db->where($dosen);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['kode_jurusan'] !== 'pd' && $mk['kode_mk'] !== 'mk'){
			$this->db->where($prodi);
			$this->db->where($mk);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['kode_jurusan'] !== 'pd' && $dosen['pengajar'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($dosen);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['kode_jurusan'] !== 'pd'){
			$this->db->where($prodi);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}else{
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}
		return $this->db->count_all_results();
	}

	private function _get_jadwal_tu(){
		$this->db->from($this->table_jadwal_tu);
		$this->db->join('tb_jurusan','tb_jadwal_tu.fakjur = tb_jurusan.kode_jurusan');
		$this->db->join('tb_tatausaha','tb_jadwal_tu.kode_tata_usaha = tb_tatausaha.kode_tu');
		$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		$i=0;
		foreach ($this->column_search_jadwal_tu as $item) {
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item,$_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_jadwal_tu) - 1 == $i){
					$this->db->group_end();
				}
			}
			$i++;
		}

		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order_jadwal_tu[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
		} elseif (isset($this->order_by_jadwal_tu)) {
			$order = $this->order_by_jadwal_tu;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_jadwal_tu(){
		$this->_get_jadwal_tu();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_jadwal_tu(){
		$this->_get_jadwal_tu();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_jadwal_tu(){
		$this->db->from($this->table_jadwal_tu);
		$this->db->join('tb_jurusan','tb_jadwal_tu.fakjur = tb_jurusan.kode_jurusan');
		$this->db->join('tb_tatausaha','tb_jadwal_tu.kode_tata_usaha = tb_tatausaha.kode_tu');
		$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		return $this->db->count_all_results();
	}

	
	private function _get_jadwal_bimbingan($prodi = null, $dosen = null){
		$this->db->from($this->table_jadwal_bimbingan);
		$this->db->join('tb_jurusan','tb_jadwal_bimbingan.jurusan = tb_jurusan.kode_jurusan');
		$this->db->join('tb_dosen','tb_jadwal_bimbingan.dosen = tb_dosen.kode_dosen');
		if($prodi['jurusan'] !== 'pd' && $dosen['dosen'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($dosen);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['jurusan'] !== 'pd'){
			$this->db->where($prodi);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}else{
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}
		$i=0;
		foreach ($this->column_search_jadwal_bimbingan as $item) {
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item,$_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_jadwal_bimbingan) - 1 == $i){
					$this->db->group_end();
				}
			}
			$i++;
		}

		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order_jadwal_bimbingan[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
		} elseif (isset($this->order_by_jadwal_bimbingan)) {
			$order = $this->order_by_jadwal_bimbingan;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_jadwal_bimbingan($prodi = null, $dosen = null){
		$this->_get_jadwal_bimbingan($prodi, $dosen);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_jadwal_bimbingan($prodi = null, $dosen = null){
		$this->_get_jadwal_bimbingan($prodi, $dosen);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_jadwal_bimbingan($prodi = null, $dosen = null){
		$this->db->from($this->table_jadwal_bimbingan);
		$this->db->join('tb_jurusan','tb_jadwal_bimbingan.jurusan = tb_jurusan.kode_jurusan');
		$this->db->join('tb_dosen','tb_jadwal_bimbingan.dosen = tb_dosen.kode_dosen');
		if($prodi['jurusan'] !== 'pd' && $dosen['dosen'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($dosen);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}elseif($prodi['jurusan'] !== 'pd'){
			$this->db->where($prodi);
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}else{
			$this->db->where('tahun_ajaran =(SELECT `tahun_semester` FROM `tb_tahunajar` WHERE `status` = 1) ',NULL,FALSE);
		}
		return $this->db->count_all_results();
	}

	private function _get_data_dosen($prodi = null, $dosen = null){
		$this->db->from($this->table_dosen);
		$this->db->join('tb_jurusan','tb_dosen.fakjur = tb_jurusan.kode_jurusan');
		if($prodi['fakjur'] !== 'pd' && $dosen['kode_dosen'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($dosen);
		}elseif($prodi['fakjur'] !== 'pd'){
			$this->db->where($prodi);
		}else{

		}
		$i=0;
		foreach ($this->column_search_dosen as $item) {
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item,$_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_dosen) - 1 == $i){
					$this->db->group_end();
				}
			}
			$i++;
		}

		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order_dosen[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
		} elseif (isset($this->order_by_dosen)) {
			$order = $this->order_by_dosen;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_data_dosen($prodi = null, $dosen = null){
		$this->_get_data_dosen($prodi, $dosen);
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_data_dosen($prodi = null, $dosen = null){
		$this->_get_data_dosen($prodi, $dosen);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_data_dosen($prodi = null, $dosen = null){
		$this->db->from($this->table_dosen);
		$this->db->join('tb_jurusan','tb_dosen.fakjur = tb_jurusan.kode_jurusan');
		if($prodi['fakjur'] !== 'pd' && $dosen['kode_dosen'] !== 'd'){
			$this->db->where($prodi);
			$this->db->where($dosen);
		}elseif($prodi['fakjur'] !== 'pd'){
			$this->db->where($prodi);
		}else{

		}
		return $this->db->count_all_results();
	}


}

/* End of file Front_Model.php */
/* Location: ./application/models/Front_Model.php */