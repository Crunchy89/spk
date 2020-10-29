<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hitung extends MY_Controller
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
			$this->db->where('user_submenu.url', 'hitung');
			$access = $this->db->get()->result();
			if (!$access) {
				redirect('page');
			}
		}
		parent::__construct();
		$this->load->model('hitung_model', 'model');
	}
	public function index()
	{
		$data = [
			'judul' => 'Perhitungan AHP',
			'kriteria' => $this->db->get('kriteria')->result()
		];
		$this->load->view('index', $data);
	}
	public function getData()
	{
		$data = $this->model->getData();
		echo json_encode($data);
	}
	public function ahp()
	{
		$data = $this->model->ahp();
		echo json_encode($data);
	}
	public function nilai_kriteria()
	{
		$data = $this->model->nilai_kriteria();
		echo json_encode($data);
	}
	public function tambah()
	{
		$data = $this->model->tambah();
		echo json_encode($data);
	}
	public function matrix_baris()
	{
		$data = $this->model->matrix_baris();
		echo json_encode($data);
	}
	public function rasio()
	{
		$data = $this->model->rasio();
		echo json_encode($data);
	}
	public function ir()
	{
		$data = $this->model->ir();
		echo json_encode($data);
	}
}
