<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MP_Model extends CI_Model {
	private $table_jadwal = 'tb_jadwal';
	private $column_order_jadwal = array(null,'tb_jadwal.kode_jurusan','nama_jurusan','kode_mk','nama_mk','kelas','sks','semester','jadwal','pengajar','ruang','peserta');
	private $column_search_jadwal = array('tb_jadwal.kode_jurusan','nama_jurusan','kode_mk','nama_mk','kelas','sks','semester','jadwal','pengajar','ruang','peserta');
	private $order_by_jadwal = array('tb_jadwal.kode_jurusan'=>'asc');

	private $table_jadwal_tu = 'tb_jadwal_tu';
	private $column_order_jadwal_tu = array(null,'fakjur','nama_jurusan','kode_tata_usaha','nama_tu');
	private $column_search_jadwal_tu = array('fakjur','nama_jurusan','kode_tata_usaha','nama_tu');
	private $order_by_jadwal_tu = array('fakjur'=>'asc');

	private $table_jadwal_bimbingan = 'tb_jadwal_bimbingan';
	private $column_order_jadwal_bimbingan = array(null, 'jurusan','nama_jurusan','dosen','nama_dosen');
	private $column_search_jadwal_bimbingan = array('jurusan','nama_jurusan','dosen','nama_dosen');
	private $order_by_jadwal_bimbingan = array('id_jurusan'=>'asc');

	private $table_dosen = 'tb_dosen';
	private $column_order_dosen = array(null, 'fakjur','nip','kode_dosen','nama_dosen','telepon');
	private $column_search_dosen = array('fakjur','nip','kode_dosen','nama_dosen','telepon');
	private $order_by_dosen = array('kode_dosen'=>'asc');

	private $table_pengumuman = 'tb_pengumuman';
	private $column_order_pengumuman = array(null, 'nm_pengumuman','tgl_mulai','tgl_selesai','nm_gambar','status');
	private $column_search_pengumuman = array('nm_pengumuman','tgl_mulai','tgl_selesai','nm_gambar','status');
	private $order_by_pengumuman = array('id_pengumuman'=>'asc');


	/**
	 * Fungsi Umum
	 */
	public function getAllProdi(){
		return $this->db->get('tb_jurusan');
	}
	
	public function ambil_satu($tabel, $param = null, $limit = null){
		return $this->db->get_where($tabel,$param,$limit);
	}

	public function tambah_data($table,$param = null){
		$this->db->insert($table,$param);
	}

	public function delete($table, $where){
		$this->db->where($where);
		$this->db->delete($table);
	}

	public function ambil_like($table, $where, $match, $side){
		$this->db->from($table);
		$this->db->like($where,$match,$side);
		return $this->db->get();
	}

	/**
	 * Jadwal Dosen
	 */
	private function _get_jadwal(){
		$this->db->from($this->table_jadwal);
		$this->db->join('tb_jurusan','tb_jadwal.kode_jurusan = tb_jurusan.kode_jurusan');
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

	public function get_data_jadwal(){
		$this->_get_jadwal();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_jadwal(){
		$this->_get_jadwal();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_jadwal(){
		$this->db->from($this->table_jadwal);
		return $this->db->count_all_results();
	}

	/**
	 * Jadwal Tata Usaha
	 */
	private function _get_jadwal_tu(){
		$this->db->from($this->table_jadwal_tu);
		$this->db->join('tb_jurusan','tb_jadwal_tu.fakjur = tb_jurusan.kode_jurusan');
		$this->db->join('tb_tatausaha','tb_jadwal_tu.kode_tata_usaha = tb_tatausaha.kode_tu');
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
		return $this->db->count_all_results();
	}

	function update_tu($where,$data){
        $this->db->update($this->table_jadwal_tu, $data, $where);
        return $this->db->affected_rows();
    }

	public function get_by_tu($id){
		$this->db->from($this->table_jadwal_tu);
		$this->db->join('tb_jurusan','tb_jadwal_tu.fakjur = tb_jurusan.kode_jurusan');
		$this->db->join('tb_tatausaha','tb_jadwal_tu.kode_tata_usaha = tb_tatausaha.kode_tu');
		$this->db->where('id_jadwal_tu',$id);
		$query = $this->db->get();

		return $query->row();
	}

	/**
	 * Jadwal Bimbingan
	 */
	private function _get_jadwal_bimbingan(){
		$this->db->from($this->table_jadwal_bimbingan);
		$this->db->join('tb_jurusan','tb_jadwal_bimbingan.jurusan = tb_jurusan.kode_jurusan');
		$this->db->join('tb_dosen','tb_jadwal_bimbingan.dosen = tb_dosen.kode_dosen');
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

	public function get_jadwal_bimbingan(){
		$this->_get_jadwal_bimbingan();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_jadwal_bimbingan(){
		$this->_get_jadwal_bimbingan();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_jadwal_bimbingan(){
		$this->db->from($this->table_jadwal_bimbingan);
		return $this->db->count_all_results();
	}

	function update_bimbingan($where,$data){
        $this->db->update($this->table_jadwal_bimbingan, $data, $where);
        return $this->db->affected_rows();
    }

	public function get_by_bimbingan($id){
		$this->db->from($this->table_jadwal_bimbingan);
		$this->db->join('tb_jurusan','tb_jadwal_bimbingan.jurusan = tb_jurusan.kode_jurusan');
		$this->db->join('tb_dosen','tb_jadwal_bimbingan.dosen = tb_dosen.kode_dosen');
		$this->db->where('id_jadwal_bimbingan',$id);
		$query = $this->db->get();

		return $query->row();
	}

	/**
	 * Data Dosen
	 */
	private function _get_data_dosen(){
		$this->db->from($this->table_dosen);
		$this->db->join('tb_jurusan','tb_dosen.fakjur = tb_jurusan.kode_jurusan');
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

	public function get_data_dosen(){
		$this->_get_data_dosen();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_data_dosen(){
		$this->_get_data_dosen();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_data_dosen(){
		$this->db->from($this->table_dosen);
		$this->db->join('tb_jurusan','tb_dosen.fakjur = tb_jurusan.kode_jurusan');
		return $this->db->count_all_results();
	}

	function update_data_dosen($where,$data){
        $this->db->update($this->table_dosen, $data, $where);
        return $this->db->affected_rows();
    }

	public function get_by_dosen($id){
		$this->db->from($this->table_dosen);
		$this->db->where('id_dosen',$id);
		$query = $this->db->get();

		return $query->row();
	}

	/**
	 * Pengumuman
	 */

	private function _get_pengumuman(){
		$this->db->from($this->table_pengumuman);
		$i=0;
		foreach ($this->column_search_pengumuman as $item) {
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item,$_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_pengumuman) - 1 == $i){
					$this->db->group_end();
				}
			}
			$i++;
		}

		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order_pengumuman[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
		} elseif (isset($this->order_by_pengumuman)) {
			$order = $this->order_by_pengumuman;
			$this->db->order_by(key($order),$order[key($order)]);
		}
	}

	public function get_pengumuman(){
		$this->_get_pengumuman();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_pengumuman(){
		$this->_get_pengumuman();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all_pengumuman(){
		$this->db->from($this->table_pengumuman);
		return $this->db->count_all_results();
	}

	function update_pengumuman($where,$data){
        $this->db->update($this->table_pengumuman, $data, $where);
        return $this->db->affected_rows();
    }

	public function get_by_pengumuman($id){
		$this->db->from($this->table_pengumuman);
		$this->db->where('id_pengumuman',$id);
		$query = $this->db->get();

		return $query->row();
	}



}
/* End of file MP_Model.php */
/* Location: ./application/models/MP_Model.php */