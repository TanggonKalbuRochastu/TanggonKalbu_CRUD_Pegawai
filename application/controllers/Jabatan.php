<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jabatan extends CI_Controller {
	public function index($idPegawai)
	{
		$this->load->model('pegawai_model');		
		$data["jabatan_list"] = $this->pegawai_model->getJabatanByPegawai($idPegawai);
		$this->load->view('jabatan', $data);
	}
	public function create($idPegawai)
	{
		$this->load->helper('url','form');	
		$this->load->library('form_validation'); //untuk form validasi
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');//trim memo
		$this->load->model('pegawai_model');	
		if($this->form_validation->run()==FALSE){
			$this->load->view('tambah_jabatan_view');
		}else{

				$this->pegawai_model->insertJabatan($idPegawai);
				$this->load->view('tambah_jabatan_sukses');
		}
	}
	public function delete($idJabatan){
		$this->load->helper('url','form');
		$this->load->library('form_validation');
		$this->load->model('pegawai_model');
		$this->pegawai_model->deleteJabatan($idJabatan);
		if($this->form_validation->run()==FALSE){
			redirect('pegawai');
		}
	}
}
?>