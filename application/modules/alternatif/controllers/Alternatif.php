<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alternatif extends MY_Controller
{

	public function __construct()
	{
		if (!$this->session->userdata('role')) {
			redirect('auth');
		}
		if ($this->session->userdata('role')) {
			$this->db->select('*');
			$this->db->from('user_access');
			$this->db->join('user_submenu', 'user_access.id_menu=user_submenu.id_menu', 'inner');
			$this->db->where('user_access.id_role', $this->session->userdata('role'));
			$this->db->where('user_submenu.url', 'alternatif');
			$access = $this->db->get()->result();
			if (!$access) {
				redirect('page');
			}
		}
		parent::__construct();
		$this->load->model('Alternatif_model', 'model');
	}
	public function index()
	{
		$data = [
			'judul' => 'Alternatif'
		];
		$this->load->view('index', $data);
	}
	public function getData()
	{
		$data = $this->model->getData();
		echo json_encode($data);
	}
	public function aksi()
	{
		$aksi = $this->input->post('aksi');
		$data = [];
		if ($aksi == 'tambah') {
			$data = $this->model->tambah();
		} elseif ($aksi == 'edit') {
			$data = $this->model->edit();
		} elseif ($aksi == 'hapus') {
			$data = $this->model->hapus();
		}
		echo json_encode($data);
	}
}
