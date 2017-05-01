<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {

		public function __construct()
		{
			parent::__construct();
			//Do your magic here
		}	

		public function getDataPegawai()
		{
			$this->db->select("id,nama,nip,DATE_FORMAT(tanggalLahir,'%d-%m-%Y') as tanggalLahir,foto");
			$query = $this->db->get('pegawai');
			return $query->result();
		}

		public function getJabatanByPegawai($idPegawai)
		{
			$this->db->select("pegawai.nama as namaPegawai, namaJabatan,DATE_FORMAT(tanggalMulai,'%d-%m-%Y') as tanggalMulai,DATE_FORMAT(tanggalSelesai,'%d-%m-%Y') as tanggalSelesai, jabatan_pegawai.id");
			$this->db->where('fk_pegawai', $idPegawai);	
			$this->db->join('pegawai', 'pegawai.id = jabatan_pegawai.fk_pegawai', 'left');	
			$query = $this->db->get('jabatan_pegawai');
			return $query->result();
		}
		public function getAnakByPegawai($idPegawai)
		{
			$this->db->select("pegawai.nama as namaPegawai, anak.nama as namaAnak,DATE_FORMAT(anak.tanggalLahir,'%d-%m-%Y') as tanggalLahir");
			$this->db->where('fk_pegawai', $idPegawai);	
			$this->db->join('pegawai', 'pegawai.id = anak.fk_pegawai', 'left');	
			$query = $this->db->get('anak');
			return $query->result();
		}


		public function insertPegawai()
		{
			$object = array(
				'nama' => $this->input->post('nama'),
				'nip' => $this->input->post('nip'),
				'tanggalLahir' => $this->input->post('tanggalLahir'),
				'alamat' => $this->input->post('alamat'),
				'foto' => $this->upload->data('file_name')  );
			$this->db->insert('pegawai', $object);
		}

		public function getPegawai($id)
		{
			$this->db->where('id', $id);	
			$query = $this->db->get('pegawai',1);
			return $query->result();

		}

		public function updateById($id)
		{
			$data = array(
				'nama' => $this->input->post('nama'),
				'nip' => $this->input->post('nip'),
				'tanggalLahir' => $this->input->post('tanggalLahir'),
				'alamat' => $this->input->post('alamat'));
			$this->db->where('id', $id);
			$this->db->update('pegawai', $data);
		}
		public function deleteById($id)
		{
			$this -> db -> where('id', $id);
  			$this -> db -> delete('pegawai');
  			$this -> db -> where('fk_pegawai', $id);
  			$this -> db -> delete('jabatan_pegawai');
  			
		}
		public function insertJabatan($idPegawai)
		{	
			$object = array(
				'namaJabatan' => $this->input->post('jabatan'), 
				'tanggalMulai' => date('Y/m/d'),
				'fk_pegawai'=> $idPegawai
				);
			$this->db->insert('jabatan_pegawai', $object);
		}
		public function insertAnak($idPegawai){
			
			$object = array(
				'nama' => $this->input->post('anak'),
				'tanggalLahir' => date('Y/m/d'),	
				'fk_pegawai' => $idPegawai
				);
			$this->db->insert('anak', $object);
		}
		public function deleteJabatan($idJabatan){
			$this->db->where('id', $idJabatan);
			$this->db->delete('jabatan_pegawai');
		}
}

/* End of file Pegawai_Model.php */
/* Location: ./application/models/Pegawai_Model.php */
 ?>