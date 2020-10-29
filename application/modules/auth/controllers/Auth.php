<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

	public function __construct()
	{
		if ($this->session->userdata('role')) {
			redirect('admin');
		}
		parent::__construct();
		$this->load->model('auth_model', 'model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['sekolah'] = $this->db->get_where('sekolah', ['id_sekolah' => 1])->row();
		auth('index', $data);
	}
	public function login()
	{
		$this->form_validation->set_rules($this->model->rules());
		if ($this->form_validation->run()) {
			$data = $this->model->login();
			echo json_encode($data);
		} else {
			$data = [
				'status' => false,
				'pesan' => 'Kolom Username dan Password tidak boleh kosong'
			];
			echo json_encode($data);
		}
	}
}
